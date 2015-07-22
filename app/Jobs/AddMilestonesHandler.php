<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Report;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use GrahamCampbell\GitHub\GitHubManager;

class AddMilestonesHandler extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels, DispatchesJobs;

    protected $milestones;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $milestones, User $user)
    {
        $this->user       = $user;
        $this->milestones = $milestones;
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
        foreach ($this->milestones as $milestone) {
            $i = explode('/', $milestone);

            $milestone = $github->api('issue')->all($i[0], $i[1], ['milestone' => $i[2], 'state' => 'all']);
            foreach ($milestone as $issue) {
                $issues[] = $i[0] . '/' . $i[1] . '/' . $issue['number'];
            }
        }

        $this->dispatch(new AddIssuesHandler($issues, $this->user));

    }
}
