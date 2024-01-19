<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class MemberWebEndpointsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_displays_members()
    {
        $response = $this->get(route('member.index'));
        $response->assertStatus(200);
        $response->assertViewIs('members.index');
    }

    /** @test */
    public function show_displays_member_details()
    {
        $member = Member::factory()->create();
        $response = $this->get(route('member.show', $member->id));
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'first_name' => $member->first_name,
            'last_name' => $member->last_name,
            'city' => $member->city,
            'state' => $member->state,
            'country' => $member->country,
            'team_id' => $member->team_id
        ]);
    }

    /** @test */
    public function store_saves_and_redirects()
    {
        $team = Team::factory()->create();
        $memberData = [
            'first_name' => 'Ricardo',
            'last_name' => 'Alejandre',
            'city' => 'Seffner',
            'state' => 'Florida',
            'country' => 'USA',
            'team_id' => $team->id,
        ];

        $response = $this->post(route('member.store'), $memberData);

        $response->assertStatus(200);
        $this->assertEquals('Member Added!', $response->getContent());
        $this->assertDatabaseHas('members', $memberData);
    }

    /** @test */
    public function store_without_team()
    {
        $memberData = [
            'first_name' => 'Ricardo',
            'last_name' => 'Alejandre',
            'city' => 'Seffner',
            'state' => 'Florida',
            'country' => 'USA',
        ];

        $response = $this->post(route('member.store'), $memberData);
        $response->assertStatus(422);
    }

    /** @test */
    public function store_with_duplicate_first_name_and_last_name()
    {
        $team = Team::factory()->create();
        $member = Member::factory()->create();
        $memberData = [
            'first_name' => $member->first_name,
            'last_name' => $member->last_name,
            'city' => 'Seffner',
            'state' => 'Florida',
            'country' => 'USA',
            'team_id' => $team->id,
        ];

        $response = $this->post(route('member.store'), $memberData);
        $response->assertStatus(422);
    }

    /** @test */
    public function update_updates_and_redirects()
    {
        $member = Member::factory()->create();

        $updatedData = [
            'id' => $member->id,
            'first_name' => 'Alfredo',
            'last_name' => 'Alejandre',
            'city' => 'Manzanillo',
            'state' => 'Granma',
            'country' => 'Cuba',
            'team_id' => $member->team_id,
        ];

        $response = $this->put("/member/{$member->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertEquals('Member Updated!', $response->getContent());
        $this->assertDatabaseHas('members', $updatedData);
    }

    /** @test */
    public function destroy_deletes_and_redirects()
    {
        $member = Member::factory()->create();

        $response = $this->delete(route('member.destroy', $member));

        $response->assertStatus(200);
        $this->assertEquals('Member deleted!', $response->getContent());
        $this->assertDatabaseMissing('members', ['id' => $member->id]);
    }
}
