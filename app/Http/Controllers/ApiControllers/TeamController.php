<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Team;

class TeamController extends Controller
{
    /**
     * Retrieve the members of a specific team.
     */
    public function getMembers(string $id)
    {
        $members = Team::find($id)->members()->get();

        return response($members);
    }
}
