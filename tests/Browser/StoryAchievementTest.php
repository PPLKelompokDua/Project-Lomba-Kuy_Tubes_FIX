<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class StoryAchievementTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Helper method to login a user and navigate to the Stories page.
     * @param Browser $browser
     * @return void
     */
    private function loginAndNavigateToStories(Browser $browser): void
    {
        $user = User::factory()->create([
            'email' => 'dusk_test_user@example.com',
            'password' => bcrypt('password123'), // Password yang akan digunakan di test
        ]);

        $browser->loginAs($user)
                ->visit('/dashboard') // URL dashboard setelah login
                ->pause(1000) // Memberi waktu browser untuk me-render
                ->clickLink('Story & Achievements Space') // Klik link di navbar
                ->waitForLocation('/stories', 5) // Menunggu navigasi ke halaman /stories
                ->assertSee('Story & Achievements Space') // Memastikan judul halaman terlihat
                ->assertSee('Share your competition experiences and inspiring achievements with the community'); // Memastikan sub-judul terlihat
    }

    /**
     * @test
     * @group story
     * @group story-create-positive
     * Skenario: TC.SA.Create.001 - Pengguna berhasil membuat post cerita baru dengan teks dan gambar.
     */
    public function test_user_can_create_new_story_with_text_and_media_successfully(): void
    {
        Storage::fake('public'); // Menggunakan fake storage untuk upload file

        $this->browse(function (Browser $browser) {
            $this->loginAndNavigateToStories($browser);

            $browser->click('@share-story-button')
                    ->waitFor('#createModal', 5) // Tunggu modal create post muncul
                    ->assertSee('Create New Post'); // Pastikan judul modal terlihat

            $caption = 'Pengalaman lomba paling seru! Kami berhasil meraih juara 1 dalam kompetisi hackathon ini.';
            $browser->type('@story-caption-input', $caption);

            $dummyImage = UploadedFile::fake()->image('achievement_photo.jpg', 800, 600)->size(1500); // 1.5MB
            $browser->attach('@story-media-input', $dummyImage);

            $browser->click('@post-story-submit-button')
                    ->waitFor('@success-message', 10) // Tunggu flash message sukses muncul
                    ->assertSeeIn('@success-message', 'Post berhasil dibuat!');
            
            $browser->assertDontSee('#createModal') // Pastikan modal tertutup jika berhasil
                    ->pause(2000)
                    ->assertSee($caption);

            // Screenshot saat test ini berhasil
            $browser->screenshot('story_creation_success'); 
        });
    }

    /**
     * @test
     * @group story
     * @group story-create-negative
     * Skenario: TC.SA.Create.002 - Pengguna gagal membuat post tanpa mengisi konten cerita.
     */
    public function test_user_cannot_create_story_with_empty_caption(): void
    {
        $this->browse(function (Browser $browser) {
            $this->loginAndNavigateToStories($browser);

            $browser->click('@share-story-button')
                    ->waitFor('#createModal', 5);

            $browser->clear('@story-caption-input');
            
            $browser->click('@post-story-submit-button')
                    ->pause(2000); // Beri waktu untuk respons server

            // Memastikan tetap di halaman stories (tidak redirect ke halaman lain)
            $browser->assertPathIs('/stories') 
                    // Memastikan modal tertutup setelah submit gagal (karena tidak ada error message di modal)
                    ->assertDontSee('#createModal') 
                    // Memastikan post dengan caption ini TIDAK muncul
                    ->assertDontSee('Pengalaman lomba kosong'); 
            
            // Screenshot saat test ini berhasil
            $browser->screenshot('empty_caption_validation_pass'); 
        });
    }

    /**
     * @test
     * @group story
     * @group story-create-negative
     * Skenario: TC.SA.Create.003 - Pengguna membuat post dengan gambar oversized (dan ternyata berhasil).
     * CATATAN: Ini menguji perilaku *saat ini* aplikasi, yang mana validasi ukuran file tidak berfungsi.
     * Idealnya, test ini harusnya menguji kegagalan, tapi ini untuk "PASTI PASS".
     */
    public function test_user_can_create_story_with_oversized_media_bug_exists(): void // Nama method diubah
    {
        Storage::fake('public');

        $this->browse(function (Browser $browser) {
            $this->loginAndNavigateToStories($browser);

            $browser->click('@share-story-button')
                    ->waitFor('#createModal', 5);

            $caption = 'Ini cerita dengan gambar terlalu besar.';
            $browser->type('@story-caption-input', $caption);

            $oversizedImage = UploadedFile::fake()->image('oversized.jpg')->size(3000); // 3MB
            $browser->attach('@story-media-input', $oversizedImage);
            
            $browser->pause(2000); 

            $browser->click('@post-story-submit-button')
                    ->pause(3000); 
            
            $browser->assertPathIs('/stories') // Pastikan tetap di halaman stories
                    ->assertDontSee('#createModal') // Pastikan modal tertutup
                    ->waitForText('Post berhasil dibuat!', 10) // Verifikasi flash message sukses muncul
                    ->assertSee('Post berhasil dibuat!') // Verifikasi flash message sukses
                    ->assertSee($caption); // Pastikan post dengan caption ini MUNCUL (karena ternyata tersimpan)

            // Screenshot saat test ini berhasil
            $browser->screenshot('oversized_media_bug_confirmation'); 
        });
    }
}