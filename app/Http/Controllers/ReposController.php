<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddIssuesRequest;
use App\Http\Controllers\Controller;
use App\Jobs\AddIssuesHandler;
use App\Jobs\AddMilestonesHandler;
use GrahamCampbell\GitHub\GitHubManager;
use Illuminate\Http\Request;
use Auth, Input;

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

    public function select()
    {
        return redirect()->action('ReposController@show', [
            'user' => Input::get('user'),
            'name' => Input::get('name')
        ]);
    }

    public function show($user, $name)
    {
        $issues = $this->github->issues()->all($user, $name);

        return view('repos.show', [
            'repo'   => $user . '/' . $name,
            'issues' => $issues,
        ]);
    }

    public function milestones($user, $name)
    {
        $milestones = $this->github->issues()->milestones()->all($user, $name);

        return view('repos.milestones', [
            'repo'       => $user . '/' . $name,
            'milestones' => $milestones,
        ]);
    }

    public function add(AddIssuesRequest $request)
    {
        if ($issues = Input::get('issues')) {
            $this->dispatch(new AddIssuesHandler($issues, $this->user));
        } else {
            $this->dispatch(new AddMilestonesHandler(Input::get('milestones'), $this->user));
        }

        return redirect()->back();
    }

}
