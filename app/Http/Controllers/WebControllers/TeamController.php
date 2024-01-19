<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DestroyTeam;
use App\Http\Requests\StoreTeam;
use App\Http\Requests\UpdateTeam;
use App\Models\Team;

class TeamController extends Controller
{
    /**
     * Display a listing of the team.
     */
    public function index()
    {
        $teams = Team::all();

        return view('teams.index')->with('teams', $teams);
    }

    /**
     * Store a newly created team in storage.
     */
    public function store(StoreTeam $request)
    {
        $input = $request->only(['name']);
        Team::create($input);

        return response('Team Added!');
    }

    /**
     * Display the specified team.
     */
    public function show(string $id)
    {
        $team = Team::find($id);

        return response($team);
    }

    /**
     * Update the specified team in storage.
     */
    public function update(UpdateTeam $request, string $id)
    {
        $team = Team::find($id);
        $input = $request->only(['name']);
        $team->update($input);

        return response('Team Updated!');
    }

    /**
     * Remove the specified team from storage.
     */
    public function destroy(DestroyTeam $request, string $id)
    {
        Team::destroy($id);

        return response('Team deleted!');
    }

    /**
     * Retrieve the members of a specific team.
     */
    public function getMembers(string $id)
    {
        $members = Team::find($id)->members()->get();

        return response($members);
    }
}
