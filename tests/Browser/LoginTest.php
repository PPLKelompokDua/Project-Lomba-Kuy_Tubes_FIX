<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @group login */

    public function test_user_can_login_from_landing_page()
    {
        // Buat user dummy
        $user = User::factory()->create([
            'email' => 'admin@lombakuy.com',
            'password' => bcrypt('admin123'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/')
                    ->click('@login-link')
                    ->assertPathIs('/login')
                    ->type('email', $user->email)
                    ->type('password', 'admin123')
                    ->press('Log In');
        });
    }
}
