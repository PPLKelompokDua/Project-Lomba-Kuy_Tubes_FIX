<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TeamProductivityTest extends DuskTestCase
{
    public function test_team_productivity_page_displays_charts_and_bottlenecks(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->clickLink('Log in')
                ->assertPathIs('/login')
                ->type('email', 'pipit@gmail.com')
                ->type('password', 'revalina30')
                ->press('LOG IN')
                ->assertPathIs('/tasks')
                ->visit('/team-productivity')
                ->assertSee('Task Distribution')
                ->assertSee('Bottleneck Analysis')

                // Cek jika ada chart dan task "tets" atau lainnya ditampilkan
                ->assertSee('tets')
                ->assertSee('Pending') // atau In Progress, Completed, dll

                // Verifikasi label status chart (berdasarkan screenshot)
                ->assertSee('Completed')
                ->assertSee('In Progress')
                ->assertSee('Blocked')
                ->assertSee('Pending');
        });
    }
}
