<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DashboardButtonsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @group dashboard
     */
    public function user_can_click_all_dashboard_buttons()
    {
        $user = User::factory()->create([
            'email' => 'vilson@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/dashboard')
                ->pause(2000);

            // 1. Click "Find Competitions"
            $browser->clickLink('Find Competitions')
                ->pause(1000)
                ->assertPathIs('/explore')
                ->back()->pause(2000);

            // 2. Click "See All" on Saved Competitions
            $browser->clickLink('See All')
                ->pause(1000)
                ->assertPathIs('/saved-competitions')
                ->back()->pause(2000);

            // 3. Click "See More" on Upcoming Schedule
            $browser->clickLink('See More →')
                ->pause(1000)
                ->assertPathIs('/teams')
                ->back()->pause(2000);

            // 4. Click "See All" on Recommended Competitions
            $browser->click('@lihat-semua-lomba')
                ->pause(1000)
                ->assertPathIs('/explore')
                ->back()->pause(2000);

            // 5. Click "View Profile"
            $browser->clickLink('View Profile')
                ->pause(1000)
                ->assertPathIs('/profile')
                ->back()->pause(2000);

            // 6. Click "Assessment"
            $browser->clickLink('Assessment')
                ->pause(1000)
                ->assertPathIs('/assessment')
                ->back()->pause(2000);

            // 7. Click "My Team"
            $browser->clickLink('My Team')
                ->pause(1000)
                ->assertPathIs('/teams')
                ->back()->pause(2000);

            // 8. Click "Invitations"
            $browser->clickLink('Invitations')
                ->pause(1000)
                ->assertPathIs('/invitations')
                ->back()->pause(2000);

            // 9. Click "Story & Achivements Space"
            $browser->clickLink('Story & Achivements Space')
                ->pause(1000)
                ->assertPathIs('/stories') // fixed from /posts to /stories
                ->back()->pause(2000);

            // 10. Click "See All" in Competition Videos & Tips
            $browser->assertSee('Competition Videos & Tips')
                ->click('@lihat-semua-video')
                ->pause(1000)
                ->assertPathIs('/learning-videos')
                ->back()->pause(2000);

            // 11. Click "Read More Articles"
            $browser->clickLink('Read More Articles')
                ->pause(1000)
                ->assertPathIs('/articles')
                ->back()->pause(2000);
        });
    }
}
