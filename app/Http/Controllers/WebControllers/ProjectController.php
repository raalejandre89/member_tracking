<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProject;
use App\Http\Requests\UpdateProject;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $projects = Project::all();
        $membersWithoutProjects = Member::doesntHave('projects')->get();

        return view('projects.index')
            ->with('projects', $projects)
            ->with('members', $membersWithoutProjects);
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(StoreProject $request)
    {
        $input = $request->only(['name']);
        Project::create($input);

        return response('Project Added!');
    }

    /**
     * Display the specified project.
     */
    public function show(string $id)
    {
        $project = Project::find($id);

        return response($project);
    }

    /**
     * Update the specified project in storage.
     */
    public function update(UpdateProject $request, string $id)
    {
        $project = Project::find($id);
        $input = $request->only(['name']);
        $project->update($input);

        return response('Project Updated!');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(string $id)
    {
        Project::destroy($id);

        return response('Project deleted!');
    }
}
