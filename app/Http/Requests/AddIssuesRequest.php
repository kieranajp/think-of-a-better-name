<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AddIssuesRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // The GitHub API will decide that for us
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'issues' => 'required_without:milestones',
            'milestones' => 'required_without:issues',
        ];
    }
}
