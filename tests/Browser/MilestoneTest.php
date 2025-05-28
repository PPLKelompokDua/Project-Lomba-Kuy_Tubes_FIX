<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;

class MilestoneTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_create_team_and_set_milestone()
    {
        $user = User::factory()->create([
            'email' => 'faza@gmail.com',
            'password' => bcrypt('123456789'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/')
                ->clickLink('Log In')
                ->assertPathIs('/login')
                ->type('email', $user->email)
                ->type('password', '123456789')
                ->press('Log In')
                ->pause(1000); // Tunggu halaman selesai load

            // Klik "My Team" - pastikan ada @dusk di blade: dusk="my-team-button"
            $browser->click('@my-team-button')
                ->assertPathIs('/teams')
                ->pause(1000);

            // Klik "Create New Team" - pastikan ada @dusk: dusk="create-new-team-button"
            $browser->click('@create-new-team-button')
                ->assertPathIs('/teams/create')
                ->pause(1000);

            // Isi form Team Details
            $browser->type('team_name', 'BPMSI24/25')
                ->type('competition_name', 'Cyber Crime in Charge')
                ->select('category', 'National') // pastikan nama select-nya "category"
                ->pause(500);

            // Isi Competition Details
            $browser->type('deadline', '2025-05-28') // pastikan input-nya bertipe "date"
                ->type('location', 'Telkom University, Bandung')
                ->type('short_description', 'blablabla')
                ->pause(500);

            // Submit form
            $browser->press('Save') // sesuaikan dengan teks tombol submit kamu
                ->pause(1000);

            // Klik Back to My Teams
            $browser->clickLink('Back to My Teams')
                ->assertPathIs('/teams');
        });
    }
}
