<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Team;
use App\Models\Task;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ManageTaskTest extends DuskTestCase
{
    use DatabaseMigrations;
     /** @group managetask */
    public function test_leader_can_create_task_in_team()
    {
        $leader = User::factory()->create([
            'email' => 'ripa@gmail.com',
            'password' => bcrypt('porseni23')
        ]);

        $member = User::factory()->create([
            'name' => 'Gong',
            'email' => 'gong@gmail.com',
            'password' => bcrypt('porseni23')
        ]);

        $team = Team::factory()->create([
            'leader_id' => $leader->id,
            'name' => 'Tim Gacor'
        ]);

        $team->members()->attach($member->id);

       
        $this->browse(function (Browser $browser) use ($leader, $team) {
            $browser->visit('/login')
                ->type('email', $leader->email)
                ->type('password', 'porseni23')
                ->press('Log In')
                ->assertPathIs('/dashboard')
                ->visit("/teams/{$team->id}/tasks")
                ->type('@task-title', 'Design')
                ->type('@input-description', 'Design web')
                ->keys('@input-due-date', now()->addDays(2)->format('Y-m-d'))
                ->select('@select-status', 'pending')
                // Assign To dikosongkan (unassigned)
                ->press('@button-submit')
                ->pause(2000)
                
                ->screenshot('task-created-unassigned')
                ->assertSee('Design')
                ->assertSee('Pending')
                ->assertSee('Unassigned');
        });

        
    }


}
