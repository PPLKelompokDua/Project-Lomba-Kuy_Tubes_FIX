<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ManageTeamTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @group manageteam */

    public function test_user_can_login_from_landing_page()
    {
        // Buat user dummy
        $user = User::factory()->create([
            'email' => 'admin@lombakuy.com',
            'password' => bcrypt('admin123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/')
                    ->clickLink('Log In')
                    ->assertPathIs('/login')
                    ->type('email', $user->email)
                    ->type('password', '12345678')
                    ->press('Log In')
                    ->assertPathIs('/dashboard') // sesuaikan path home kalau redirect ke lain
                    ->clickLink('Invitations')
                    ->assertPathIs('/invitations')
                    ->visit(route('invitations.index', ['team_id' => $team->id]))
                    ->assertSee('Invite Member for Your Teams')
                    ->select('user_id', $user->id)  // ⬅️ Sesuaikan dengan name dropdown user
                    ->select('team_id', $team->id)     // ⬅️ Sesuaikan dengan name dropdown team
                    ->press('Send Invitation') // sesuaikan dengan label tombol kamu
                    ->assertPathIs('/invitations');
        });

        
    }
}
