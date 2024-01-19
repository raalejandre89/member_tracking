<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeMembers;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Retrieve the members of a specific project.
     */
    public function getMembers(string $id)
    {
        $members = Project::find($id)->members()->get();

        return response($members);
    }

    /**
     * @param \App\Http\Requests\ChangeMembers $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function changeMembers(ChangeMembers $request)
    {
        $project = Project::find($request->input('id'));

        if ($request->has('members_ids')) {
            if ($project->members()->count()) { //Updating
                $project->members()->sync($request->input('members_ids'));
            } else { //Adding
                $project->members()->attach($request->input('members_ids'));
            }
        } else {
            if ($project->members()->count()) { //Deleting All
                $project->members()->detach();
            }
        }

        return response('Project Updated!');
    }
}
