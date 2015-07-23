<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Report;

class ReportsController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show()
    {
        $report = Report::findByUser($this->user);

        $issues = [];

        if ($report) {
            foreach ($report->issues as $issue) {
                $url = explode('/', $issue['url']);
                $repo = implode('/', [ $url[4], $url[5] ]);
                $issues[$repo][] = $issue;
            }
        }

        return view('reports.show', [
            'user'   => $this->user,
            'report' => $issues
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy()
    {
        Report::where('user_id', $this->user->id)->delete();

        return redirect()->back();
    }
}
