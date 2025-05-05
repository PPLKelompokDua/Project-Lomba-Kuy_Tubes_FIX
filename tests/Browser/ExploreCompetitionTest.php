<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Competition;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;

class ExploreCompetitionTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @group explore
     */
    public function user_can_access_explore_page()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'email' => 'vilson@gmail.com',
                'password' => bcrypt('12345678'),
            ]);

            $browser->loginAs($user)
                    ->visit('/explore')
                    ->pause(1000)
                    ->assertSee('Eksplorasi Katalog Lomba');
        });
    }

    /**
     * @test
     * @group explore
     */
    public function user_can_click_see_detail_and_open_competition_detail_page()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'email' => 'vilson@gmail.com',
                'password' => bcrypt('12345678'),
            ]);

            $competition = Competition::factory()->create([
                'title' => 'Lomba Tes Dusk',
                'description' => 'Deskripsi test lomba.',
                'category' => 'Teknologi',
                'prize' => 'Rp 5.000.000',
                'deadline' => now()->addDays(7),
                'start_date' => now()->addDays(10),
                'end_date' => now()->addDays(17),
                'registration_link' => 'https://example.com/register',
                'location' => 'Online',
                'organizer_id' => $user->id,
            ]);

            $browser->loginAs($user)
                    ->visit('/dashboard')
                    ->pause(1000)
                    ->click('@lihat-semua-lomba')
                    ->waitForLocation('/explore')
                    ->pause(1000)
                    ->type('search', 'Lomba Tes Dusk')
                    ->pause(500)
                    ->script("document.querySelector('form[action*=explore] button[type=submit]').click();");

                $browser->pause(3000) // waktu render
                    ->scrollIntoView("@lihat-detail-{$competition->id}") // 💡 ini penting!
                    ->pause(1000) // beri waktu untuk animasi AOS selesai
                    ->waitFor("@lihat-detail-{$competition->id}", 5)
                    ->click("@lihat-detail-{$competition->id}")
                    ->assertPathIs('/competitions/' . $competition->id)
                    ->assertSee('Deskripsi test lomba.');
        });
    }

    /**
     * @test
     * @group explorepaginate
     */
    public function test_user_can_navigate_pagination_on_explore_page()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create([
                'email' => 'paginationtester@example.com',
                'password' => bcrypt('password123'),
            ]);

            // Buat 30 lomba agar bisa terpaginasikan (misal 12 per halaman)
            Competition::factory()
                ->count(30)
                ->sequence(
                    ...collect(range(1, 30))->map(fn ($i) => [
                        'title' => "Lomba Tes Page $i",
                        'organizer_id' => $user->id,
                        'created_at' => now()->subMinutes(31 - $i), // penting!
                    ])
                )
                ->create();

            $browser->loginAs($user)
                ->visit('/dashboard')
                ->pause(1000)
                ->click('@lihat-semua-lomba')
                ->waitForLocation('/explore')
                ->pause(2000)
                ->assertSee('Eksplorasi Katalog Lomba')

                // Verifikasi daftar lomba muncul
                ->waitForText('Lomba Tes Page 1', 10)
                ->assertSee('Lomba Tes Page 1')

                // Screenshot sebelum klik halaman 2
                ->screenshot('explore-page-before-pagination')

                // Pastikan pagination muncul lalu klik ke halaman 2
                ->waitFor('@pagination-active', 10)
                ->scrollIntoView('@pagination-active')
                ->pause(500)
                ->clickLink('2')

                // Validasi pindah halaman
                ->pause(2000)
                ->assertQueryStringHas('page', '2')
                ->assertSee('Lomba Tes Page') // pastikan masih melihat data
                ->screenshot('explore-page-after-pagination');
        });
    }


    /**
     * @test
     * @group explorefilter
     */
    public function test_user_can_filter_competitions_by_category_and_prize()
    {
        $this->browse(function (Browser $browser) {
            $competition = \App\Models\Competition::factory()->create([
                'title' => 'Lomba Teknologi Besar',
                'category' => 'Teknologi',
                'prize' => 'Rp 10.000.000',
                'deadline' => now()->addDays(10),
                'start_date' => now()->addDays(1),
                'end_date' => now()->addDays(15),
            ]);
        
            $browser->visit('/explore')
                ->waitForText('Eksplorasi Katalog Lomba', 10)
                ->assertSee('Eksplorasi Katalog Lomba')
                ->select('#category', 'Teknologi')
                ->select('#prize', 'gt2');
        
            $browser->script("document.querySelector('[dusk=\"filter-form\"]').submit();");
        
            $browser->pause(1500)
                ->assertQueryStringHas('category', 'Teknologi')
                ->assertQueryStringHas('prize_range', 'gt2')
                ->screenshot('before-wait-text')
                ->assertSee('Eksplorasi Katalog Lomba')
                ->screenshot('filter-kategori-dan-hadiah');
        });
    }
}
