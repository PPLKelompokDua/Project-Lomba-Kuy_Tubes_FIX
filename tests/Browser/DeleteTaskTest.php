<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteTaskTest extends DuskTestCase
{
    public function test_user_can_delete_task(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Log in')
                ->assertPathIs('/login')
                ->type('email', 'pipit@gmail.com')
                ->type('password', 'revalina30')
                ->press('LOG IN')

                // Pastikan halaman tasks terbuka
                ->waitForText('Your Tasks', 5)
                ->assertPathIs('/tasks')

                // Cari dan hapus task dengan judul tertentu, misalnya: "test"
                ->with('.card:contains("test")', function ($card) {
                    $card->press('Delete');
                })

                ->pause(1000) // Tunggu setelah klik delete
                ->assertDontSee('test'); // Pastikan task tidak ada lagi
        });
    }
}
