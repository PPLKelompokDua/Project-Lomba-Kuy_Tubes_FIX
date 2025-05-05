<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GetStartedTest extends DuskTestCase
{
    /**
     * @group getstarted
     */
    public function test_user_can_click_get_started_button_in_hero()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(1000)
                ->assertSee('Get Started')
                ->scrollTo('a[href="/register"] button') // Tombol di Hero section
                ->pause(500)
                ->click('a[href="/register"] button')
                ->pause(1000)
                ->assertPathIs('/register');
        });
    }

    /**
     * @group getstarted
     */
    public function test_user_can_click_get_started_button_in_footer()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->pause(1000)
                    ->assertSee('Get Started')
                    ->click('@footer-get-started-button') // gunakan selector Dusk untuk presisi
                    ->pause(1000)
                    ->assertPathIs('/register');
        });
    }

    /**
     * @group getstarted
     */

    public function test_user_can_submit_contact_form_with_valid_input()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->scrollIntoView('@contact-nama')
                    ->type('@contact-nama', 'Budi Santoso')
                    ->type('@contact-email', 'budi@example.com')
                    ->type('@contact-subjek', 'Tanya tentang lomba')
                    ->type('@contact-pesan', 'Halo, saya tertarik dengan lomba ini. Bisa saya dapatkan info lebih lanjut?')
                    ->click('@contact-submit')
                    ->pause(1000)
                    ->assertSeeIn('@contact-success', 'Pesan Anda berhasil dikirim!');
        });
    }
}
