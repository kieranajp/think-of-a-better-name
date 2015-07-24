<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Report;
use App\User;
use GrahamCampbell\GitHub\GitHubManager;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

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

        $issues = new Collection();
        foreach ($this->issues as $issue) {
            $i = explode('/', $issue);
            $issues->push((object)$github->issues()->show($i[0], $i[1], $i[2]));
        }

        if ($report = Report::findByUser($this->user)) {
            $report->issues = array_merge($report->issues, $issues);
        } else {
            $report = new Report([
                'user_id' => $this->user->id,
                'issues'  => $issues->sortByDesc('number'),
            ]);
        }

        return $report->save();
    }
}
