<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AdminCreateArticleTest extends DuskTestCase
{
    use DatabaseMigrations;
    /** @group article */
    public function test_admin_can_create_article_with_valid_data()
    {
        Storage::fake('public'); // Untuk testing upload gambar

        $admin = User::factory()->create([
            'email' => 'admin@lombakuy.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin', // pastikan ada role kalau dibutuhkan
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
                    ->type('email', $admin->email)
                    ->type('password', 'admin123')
                    ->press('Log In')
                    ->pause(1000)
                    ->assertSee('Welcome, Admin!')
                    ->clickLink('Article Management')
                    ->pause(1000)
                    ->assertSee('Articles')
                    ->click('@add-article') // pastikan tombol Add Article punya Dusk selector
                    ->assertPathIs('/admin/articles/create')

                    // Isi form
                    ->type('title', 'Dusk Test Article')
                    ->select('category', 'Motivation')
                    ->select('status', 'published')
                    ->type('hashtags', 'testing,dusk,automation')
                    ->type('body', 'This is a test article body content.')

                    // Submit
                    ->scrollTo('@submit-article')
                    ->press('@submit-article')
                    ->pause(1000)
                    ->assertSee('Article has been successfully added.'); // atau pesan yang muncul
        });
    }

    /** @group articlenegative */
    public function test_admin_cannot_create_article_with_missing_title()
    {
        Storage::fake('public');

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
                    ->pause(500)
                    ->clickLink('Article Management')
                    ->pause(500)
                    ->click('@add-article')
                    ->assertPathIs('/admin/articles/create')

                    // Kosongin title
                    ->type('title', '') // kosong
                    ->select('category', 'Motivation')
                    ->select('status', 'published')
                    ->type('hashtags', '#error, #case')
                    ->type('body', 'Body content without title')

                    ->scrollTo('@submit-article')
                    ->press('@submit-article')
                    ->pause(1000)

                    // Cek bahwa masih di halaman form
                    ->assertPathIs('/admin/articles/create')
                    ->assertInputValue('title', '') // tetap kosong
                    ->screenshot('missing-title-validation');
        });
    }


    /** @group articleedit */
    public function test_admin_can_edit_article_title_only()
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'email' => 'admin@lombakuy.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        $article = \App\Models\Article::factory()->create([
            'title' => 'Old Title',
            'user_id' => $admin->id,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $article) {
            $browser->visit('/login')
                    ->type('email', $admin->email)
                    ->type('password', 'admin123')
                    ->press('Log In')
                    ->pause(500)
                    ->clickLink('Article Management')
                    ->pause(1000)
                    ->assertSee('Articles')

                    // Klik tombol edit berdasarkan ID artikel
                    ->click('@edit-article-' . $article->id)
                    ->assertPathBeginsWith('/admin/articles/' . $article->id . '/edit')

                    // Edit title saja
                    ->type('title', 'Updated Title')
                    ->scrollTo('@submit-article')
                    ->pause(1000)
                    ->press('@submit-article')
                    ->pause(2000)
                    ->assertSee('Article has been successfully updated.');
        });
    }

    /** @group articleeditnegative */
    public function test_admin_cannot_edit_article_with_empty_title()
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'email' => 'admin@lombakuy.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        $article = \App\Models\Article::factory()->create([
            'title' => 'Original Title',
            'user_id' => $admin->id,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $article) {
            $browser->visit('/login')
                    ->type('email', $admin->email)
                    ->type('password', 'admin123')
                    ->press('Log In')
                    ->pause(500)
                    ->clickLink('Article Management')
                    ->pause(500)
                    ->click('@edit-article-' . $article->id)
                    ->assertPathBeginsWith('/admin/articles/' . $article->id . '/edit')

                    // Kosongkan title
                    ->type('title', '')
                    ->scrollTo('@submit-article')
                    ->press('@submit-article')
                    ->pause(1000)
                    ->assertSee('Thumbnail');
        });
    }

    /** @group articleshow */
    public function test_admin_can_view_article_detail()
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'email' => 'admin@lombakuy.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        $article = \App\Models\Article::factory()->create([
            'title' => 'View Test Article',
            'user_id' => $admin->id,
            'body' => 'This is a detailed test body.',
        ]);

        $this->browse(function (Browser $browser) use ($admin, $article) {
            $browser->visit('/login')
                    ->type('email', $admin->email)
                    ->type('password', 'admin123')
                    ->press('Log In')
                    ->pause(500)
                    ->clickLink('Article Management')
                    ->pause(2000)
                    ->click('@view-article-' . $article->id)
                    ->pause(1000)
                    ->assertSee('View Test Article')
                    ->assertSee('This is a detailed test body.');
        });
    }

    /** @group articledelete */
    public function test_admin_can_delete_article()
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'email' => 'admin@lombakuy.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        $article = \App\Models\Article::factory()->create([
            'title' => 'Delete Me',
            'user_id' => $admin->id,
        ]);

        $this->browse(function (Browser $browser) use ($admin, $article) {
            $browser->visit('/login')
                    ->type('email', $admin->email)
                    ->type('password', 'admin123')
                    ->press('Log In')
                    ->pause(500)
                    ->clickLink('Article Management')
                    ->pause(500)

                    // Konfirmasi artikel ada dulu
                    ->assertSee('Delete Me')

                    // Gunakan script untuk submit form delete
                    ->script("document.querySelector('[dusk=\"delete-article-{$article->id}\"]').submit();");
        });
    }
}
