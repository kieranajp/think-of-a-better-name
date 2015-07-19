<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Report;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use GrahamCampbell\GitHub\GitHubManager;

class AddIssuesHandler extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $issues;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $issues, User $user)
    {
        $this->user   = $user;
        $this->issues = $issues;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(GitHubManager $github)
    {
        $github->authenticate($this->user->token, 'http_token');

        $issues = [];
        foreach ($this->issues as $issue) {
            $i = explode('/', $issue);
            $issues[] = (object)$github->issues()->show($i[0], $i[1], $i[2]);
        }

        if ($report = Report::findByUser($this->user)) {
            $report->issues = array_merge($report->issues, $issues);
        } else {
            $report = new Report([
                'user_id' => $this->user->id,
                'issues'  => $issues,
            ]);
        }

        return $report->save();
    }
}
