<?php

namespace App\Http\Controllers\WebControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMember;
use App\Http\Requests\UpdateMember;
use App\Models\Member;
use App\Models\Team;

use function view;

class MemberController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index()
    {
        $members = Member::all();
        $teams = Team::all();

        return view('members.index')
            ->with('members', $members)
            ->with('teams', $teams);
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(StoreMember $request)
    {
        $input = $request->only([
            'first_name',
            'last_name',
            'city',
            'state',
            'country',
            'team_id',
        ]);
        Member::create($input);

        return response('Member Added!');
    }

    /**
     * Display the specified member.
     */
    public function show(string $id)
    {
        $member = Member::find($id);

        return response($member);
    }

    /**
     * Update the specified member in storage.
     */
    public function update(UpdateMember $request, string $id)
    {
        $member = Member::find($id);
        $input = $request->only([
            'first_name',
            'last_name',
            'city',
            'state',
            'country',
            'team_id',
        ]);
        $member->update($input);

        return response('Member Updated!');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(string $id)
    {
        Member::destroy($id);

        return response('Member deleted!');
    }

}
