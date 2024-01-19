<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeTeam;
use App\Models\Member;

use function view;

class MemberController extends Controller
{

    /**
     * @param \App\Http\Requests\ChangeTeam $request
     * @return void
     */
    public function changeTeam(ChangeTeam $request)
    {
        $member = Member::find($request->input('id'));

        $member->team_id = $request->input('team_id');
        $member->save();

        return response('New team assigned!');
    }
}
