<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddIssuesRequest;
use App\Jobs\AddIssuesHandler;
use App\Jobs\AddMilestonesHandler;
use Auth;
use Input;
use GrahamCampbell\GitHub\GitHubManager;
use Illuminate\Http\Request;

class ReposController extends Controller
{
    protected $user;

    public function __construct(GitHubManager $github)
    {
        $this->user = Auth::user();
        $this->github = $github;
        $this->github->authenticate($this->user->token, 'http_token');
    }

    /**
     * Ask for a repo name.
     *
     * @return Response
     */
    public function index()
    {
        return view('repos.ask');
    }

    /**
     * Load in the selected repo
     *
     * @return Redirect
     */
    public function select()
    {
        return redirect()->action('ReposController@milestones', [
            'user' => Input::get('user'),
            'name' => Input::get('name')
        ]);
    }

    /**
     * Show the list of issues in the repo
     *
     * @param  string $user Repo owner
     * @param  string $name Repo name
     * @return Response
     */
    public function show($user, $name)
    {
        $issues = $this->github->issues()->all($user, $name, ['state' => 'all', 'per_page' => 100]);

        return view('repos.show', [
            'repo'   => $user . '/' . $name,
            'issues' => $issues,
        ]);
    }

    /**
     * Show the list of milestones in the repo
     * @param  string $user Repo owner
     * @param  string $name Repo name
     * @return Response
     */
    public function milestones($user, $name)
    {
        $milestones = $this->github->issues()->milestones()->all($user, $name, ['state' => 'all', 'per_page' => 100]);

        return view('repos.milestones', [
            'repo'       => $user . '/' . $name,
            'milestones' => $milestones,
        ]);
    }

    /**
     * Add an issue or milestone to the report
     *
     * @param AddIssuesRequest $request
     * @return Redirect
     */
    public function add(AddIssuesRequest $request)
    {
        if ($issues = Input::get('issues')) {
            $this->dispatch(new AddIssuesHandler($issues, $this->user));
        } else {
            $this->dispatch(new AddMilestonesHandler(Input::get('milestones'), $this->user));
        }

        return redirect()->back()->with('status', 'Issues added successfully');
    }

}
