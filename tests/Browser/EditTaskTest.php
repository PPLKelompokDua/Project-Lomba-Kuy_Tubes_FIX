<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditTaskTest extends DuskTestCase
{
    public function test_user_can_edit_task(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Log in')
                ->assertPathIs('/login')
                ->type('email', 'pipit@gmail.com')
                ->type('password', 'revalina30')
                ->press('LOG IN')
                ->waitForText('Your Tasks', 5)
                ->assertPathIs('/tasks')

                // Pastikan task dengan title "tets" ada
                ->assertSee('tets')

                // Klik tombol Edit pada task "tets"
                ->with('.card:contains("tets")', function ($card) {
                    $card->press('Edit');
                })

                ->pause(1000) // tunggu modal muncul

                // Ubah field dalam modal
                ->type('title', 'tets updated')
                ->type('description', 'test updated')
                ->press('Save Changes')

                ->pause(1000) // tunggu simpan selesai

                // Cek bahwa perubahan terlihat
                ->assertSee('tets updated')
                ->assertSee('test updated');
        });
    }
}
