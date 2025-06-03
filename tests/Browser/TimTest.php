<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TimTest extends DuskTestCase
{

    /** @group tim */

    public function test_user_can_login_and_create_team()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('http://127.0.0.1:8000/login')
                    ->type('email', 'faza@gmail.com')
                    ->screenshot('debug-login-page')
                    ->type('password', '123456789')
                    ->press('Log In')

                    #my team
                    ->clickLink('My Team')
                    ->clickLink('Create New Team')
                    ->Type('name', 'Naila')
                    ->pause(5000)
                    ->Type('competition_name', 'Lomba mancing')
                    ->Type('category', 'Kecamatan')
                    ->screenshot('deadline')
                    ->Type('deadline', '2025-06-15')
                    ->Type('location', 'Bojos')
                    ->Type('description', 'Lomba dibuka untuk umum')
                    ->press('Create Team')
                    ->pause(5000)
                    ->clickLink('Back to My Teams')
                    ->clickLink('Timeline')
                    ->clickLink('Add Milestone')
                    ->Type('title', 'Lomba mancing')
                    ->Type('description', 'Ayo kita mancing kepiting')
                    ->Type('start_date', '2025-03-06')
                    ->Type('start_time', '09:00')
                    ->Type('end_date', '04-06-2025')
                    ->Type('end_time', '20:00')
                    ->click('label[for="status_completed"]')

                    ->scrollTo('button[type=submit]')
                    ->press('Save Milestone')
                    ->clickLink('Back to Milestones')
                    ->clickLink('Review Tasks')
                    ->clickLink('Create New Task')
                    ->Type('title', 'Siapkan umpan')
                    ->Type('description', 'Siapkan umpan sesuai dengan jenis ikan')
                    ->Type('due_date', '06-06-2025')
                    ->screenshot('click')
                    ->select('status', 'in_progress')
                    ->select('assigned_user_id', '1')
                    ->press('Create Task');
        });
    }
}
