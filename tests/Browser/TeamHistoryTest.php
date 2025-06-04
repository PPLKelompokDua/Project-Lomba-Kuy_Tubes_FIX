<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Team;
use App\Models\Competition;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TeamHistoryTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @group history */
    public function test_user_can_see_all_teams_in_my_team_page()
    {
        $user = User::factory()->create([
            'email' => 'user@gmail.com',
            'password' => bcrypt('password123'),
        ]);

        $ongoingCompetition = Competition::factory()->create();
        $finishedCompetition = Competition::factory()->create();

        // Buat tim ongoing
        $teamOngoing = Team::factory()->create([
            'leader_id' => $user->id,
            'name' => 'Team Aktif',
            'status_team' => 'ongoing',
            'competition_id' => $ongoingCompetition->id,
        ]);

        // Buat tim finished
        $teamFinished = Team::factory()->create([
            'leader_id' => $user->id,
            'name' => 'Team Selesai',
            'status_team' => 'finished',
            'competition_id' => $finishedCompetition->id,
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password123')
                ->press('Log In')
                ->assertPathIs('/dashboard')
                ->clickLink('My Team')
                ->assertPathIs('/teams')
                ->waitForText('My Teams & Competitions Portfolio')
                ->assertSee('Team Aktif')
                ->assertSee('Team Selesai')
                ->assertSee('All Teams')
                ->screenshot('riwayat-my-team-page');
        });
    }


    public function test_user_can_filter_active_teams()
    {
        $user = User::factory()->create([
            'email' => 'ripa@gmail.com',
            'password' => bcrypt('porseni23'),
        ]);

        // Ongoing team
        $activeTeam = Team::factory()->create([
            'leader_id' => $user->id,
            'name' => 'Tim Aktif',
            'status_team' => 'ongoing',
        ]);

        // Finished team
        $finishedTeam = Team::factory()->create([
            'leader_id' => $user->id,
            'name' => 'Tim Selesai',
            'status_team' => 'finished',
        ]);

        $this->browse(function (Browser $browser) use ($user, $activeTeam, $finishedTeam) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'porseni23')
                ->press('Log In')
                ->assertPathIs('/dashboard')
                ->clickLink('My Team')
                ->assertPathIs('/teams')
                ->waitForText('My Teams & Competitions Portfolio')
                ->click('@filter-active') // ← pastikan tombolnya ada dusk="filter-active"
                ->waitForText('Tim Aktif')
                ->assertSee('Tim Aktif')
                ->assertDontSee('Tim Selesai')
                ->screenshot('filter-active-teams');
        });
    }


    /** @group finished */
    public function test_user_can_filter_finished_teams()
    {
        $user = User::factory()->create([
            'email' => 'user@gmail.com',
            'password' => bcrypt('password123'),
        ]);

        // Finished team
        $finishedTeam = Team::factory()->create([
            'leader_id' => $user->id,
            'name' => 'Tim Selesai',
            'status_team' => 'finished',
        ]);

        // Ongoing team
        $ongoingTeam = Team::factory()->create([
            'leader_id' => $user->id,
            'name' => 'Tim Aktif',
            'status_team' => 'ongoing',
        ]);

        $this->browse(function (Browser $browser) use ($user, $finishedTeam, $ongoingTeam) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password123')
                ->press('Log In')
                ->assertPathIs('/dashboard')
                ->clickLink('My Team')
                ->assertPathIs('/teams')
                ->waitForText('My Teams & Competitions Portfolio')
                ->click('@filter-finished') // ← pastikan tombolnya ada dusk="filter-finished"
                ->waitForText('Tim Selesai')
                ->assertSee('Tim Selesai')
                ->assertDontSee('Tim Aktif')
                ->screenshot('filter-finished-teams');
        });
    }


    /** @group piwditel */
    public function test_user_can_view_team_details()
    {
        $user = User::factory()->create([
            'email' => 'ripa@gmail.com',
            'password' => bcrypt('porseni23'),
        ]);

        $team = Team::factory()->create([
            'leader_id' => $user->id,
            'name' => 'Tim Tam',
        ]);

        $this->browse(function (Browser $browser) use ($user, $team) {
            $browser->visit('/login')
                ->type('email', 'ripa@gmail.com')
                ->type('password', 'porseni23')
                ->press('Log In')
                ->assertPathIs('/dashboard')
                ->visit('/teams')
                ->assertSee($team->name)
                ->click("@view-details-{$team->id}")
                ->assertPathIs("/teams/{$team->id}")
                ->waitForText('Competition Preview')
                ->assertSee('Tim Tam')
                ->assertSee('Competition Name')
                ->screenshot('after-view-details');
        });
    }





}
