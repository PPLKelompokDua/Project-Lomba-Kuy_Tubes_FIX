<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminDashboardButtonsTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @group admin-dashboard
     */
    public function admin_can_navigate_using_sidebar_and_logout()
    {
        $admin = User::factory()->create([
            'email' => 'admin@lombakuy.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
                ->type('email', $admin->email)
                ->type('password', 'admin123')
                ->press('Log In')
                ->waitForText('Welcome, Admin!', 5) // Tunggu sampai benar-benar masuk
                ->assertPathIs('/admin/dashboard');

            // 1. Dashboard
            $browser->clickLink('Dashboard')
                ->waitForLocation('/admin/dashboard', 5)
                ->assertPathIs('/admin/dashboard');

            // 2. View Feedback
            $browser->clickLink('View Feedback')
                ->waitForLocation('/admin/feedbacks', 5)
                ->assertPathIs('/admin/feedbacks');

            // 3. Assessment Question Management
            $browser->clickLink('Assessment Question Management')
                ->waitForLocation('/admin/assessment-questions', 5)
                ->assertPathIs('/admin/assessment-questions');

            // 4. Article Management
            $browser->clickLink('Article Management')
                ->waitForLocation('/admin/articles', 5)
                ->assertPathIs('/admin/articles');

            // 5. Learning Videos Management
            $browser->clickLink('Learning Videos Management')
                ->waitForLocation('/admin/learning-videos', 5)
                ->assertPathIs('/admin/learning-videos');

            // 6. Logout (pakai Dusk selector atau visible form logout button)
            $browser->visit('/admin/dashboard') // kembali ke dashboard dulu supaya form logout tersedia
                ->waitFor('form[action="' . route('logout') . '"] button', 5)
                ->click('form[action="' . route('logout') . '"] button')
                ->waitForLocation('/', 5)
                ->assertPathIs('/');
        });
    }
}
