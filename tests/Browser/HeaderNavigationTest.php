<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HeaderNavigationTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @group headeruser */
    public function test_user_can_navigate_header_links()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'email' => 'user@example.com',
                'password' => bcrypt('password123'),
            ]);

            // Login & ensure landing on dashboard
            $browser->loginAs($user)
                    ->visit('/dashboard')
                    ->assertSee('Selamat datang')
                    ->pause(1000);

            // Klik "Dashboard" dari header
            $browser->clickLink('Dashboard')
                    ->pause(1000)
                    ->assertPathIs('/dashboard');

            // Klik "Eksplorasi Lomba"
            $browser->clickLink('Eksplorasi Lomba')
                    ->pause(1000)
                    ->assertPathIs('/explore');

            // Kembali ke dashboard agar bisa klik logout (jika perlu)
            $browser->visit('/dashboard')
                    ->pause(1000);

            // Klik tombol profil (trigger dropdown)
            $browser->click('.relative button[aria-label="User menu"]')
                    ->pause(500);

            // Klik logout
            $browser->click('form[action*="logout"] button')
                    ->pause(1000)
                    ->assertPathIs('/');
        });
    }
}
