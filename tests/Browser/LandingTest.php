<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LandingTest extends DuskTestCase
{
    /**
     * @group landing
     */
    public function test_navigation_links_scroll_to_correct_sections()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(1000) // Biarkan halaman fully render
                ->assertSee('LombaKuy')

                // Navigasi header
                ->clickLink('Features')
                ->pause(500)
                ->assertPresent('#features')

                ->clickLink('FAQ')
                ->pause(500)
                ->assertPresent('#faq')

                ->clickLink('About Us')
                ->pause(500)
                ->assertPresent('#aboutus');

            // Klik tombol "Explore Features" (di Hero)
            $browser->script("document.querySelector('a[href=\"#features\"] button')?.click();");
            $browser->pause(1000)
                    ->assertPresent('#features');

            // Lanjutkan ke bagian lain
            $browser->clickLink('How It Works')
                    ->pause(500)
                    ->assertPresent('#how-it-works')

                    ->clickLink('Testimonials')
                    ->pause(500)
                    ->assertPresent('#testimonials')

                    ->clickLink('Contact Us')
                    ->pause(500)
                    ->assertPresent('#contact');
        });
    }
}
