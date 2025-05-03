<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @group register */
    public function test_user_can_register_successfully()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->assertPathIs('/register') // pastikan kita di halaman register
                    ->waitFor('input[name="name"]', 5) // tunggu form muncul (maks. 5 detik)
                    ->type('name', 'Test User')
                    ->type('email', 'testregister@example.com')
                    ->select('role', 'organizer')
                    ->type('password', 'password123')
                    ->type('password_confirmation', '')
                    ->check('terms')
                    ->press('Daftar Sekarang')
                    ->assertPathBeginsWith('/organizer');
        });
    }
}
