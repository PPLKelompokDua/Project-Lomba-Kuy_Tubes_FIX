<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OrganizerLombaTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** 
     * @test
     * @group organizercreate 
     * */
    public function test_organizer_can_create_competition_successfully()
    {
        Storage::fake('public');

        $this->browse(function (Browser $browser) {
            $organizer = User::factory()->create([
                'role' => 'organizer',
                'email' => 'organizer@example.com',
                'password' => bcrypt('12345678'),
            ]);

            $browser->loginAs($organizer)
                ->visit('/organizer/dashboard')
                ->assertSee("Selamat datang, {$organizer->name}!")
                ->clickLink('Tambah Lomba Baru')
                ->assertPathIs('/organizer/competitions/create')
                ->pause(1000)

                // Scroll agar semua input terlihat
                ->scrollIntoView('#competitionForm')
                ->pause(500)

                // Isi input field biasa
                ->type('title', 'Lomba Uji Dusk')
                ->type('description', 'Ini adalah deskripsi lomba untuk test dusk.')
                ->select('category_select', 'Teknologi')
                ->type('prize', 'Rp 10.000.000')
                ->type('registration_link', 'https://example.com/daftar')
                ->type('max_participants', '100')
                ->type('location', 'Online')

                // Isi input tanggal pakai script agar stabil
                ->script([
                    "document.querySelector('#deadline').value = '2025-05-07'",
                    "document.querySelector('#start_date').value = '2025-05-08'",
                    "document.querySelector('#end_date').value = '2025-07-07'",
                ]);

            $browser->pause(500)
                ->screenshot('isi-form-sesudah-tanggal')

                // Kirim form via JavaScript agar stabil
                ->script("document.getElementById('competitionForm').submit();");

            // Tunggu dan validasi redirect
            $browser->pause(3000)
                    ->assertPathIs('/organizer/competitions')
                    ->assertSee('Lomba Uji Dusk')
                    ->screenshot('lomba-berhasil-disubmit');
        });
    }

    /** 
     * @test
     * @group organizercreateback
     */
    public function test_organizer_can_go_back_from_create_page()
    {
        $this->browse(function (Browser $browser) {
            $organizer = User::factory()->create([
                'role' => 'organizer',
                'email' => 'organizer2@example.com',
                'password' => bcrypt('12345678'),
            ]);

            $browser->loginAs($organizer)
                ->visit('/organizer/competitions/create')
                ->assertSee('Tambah Lomba Baru')

                // Klik tombol kembali
                ->clickLink('Kembali ke Dashboard')
                ->pause(1000)

                // Pastikan redirect ke halaman index kompetisi
                ->assertPathIs('/organizer/competitions')
                ->screenshot('kembali-ke-index-kompetisi');
        });
    }

    /** 
     * @test
     * @group organizerdetail 
     */
    public function test_organizer_can_view_and_go_back_from_competition_detail()
    {
        $this->browse(function (Browser $browser) {
            $organizer = User::factory()->create([
                'role' => 'organizer',
                'email' => 'organizer3@example.com',
                'password' => bcrypt('12345678'),
            ]);

            // Buat 1 lomba
            $competition = \App\Models\Competition::factory()->create([
                'organizer_id' => $organizer->id,
                'title' => 'Lomba Detail Dusk',
            ]);

            $browser->loginAs($organizer)
                ->visit('/organizer/competitions')
                ->assertSee('Lomba Detail Dusk')

                // Klik tombol detail (pakai icon eye)
                ->click('@lihat-detail-' . $competition->id)
                ->pause(1000)
                ->assertSee($competition->title)

                // Klik tombol Kembali (di bagian bawah)
                ->clickLink('Kembali')
                ->pause(1000)
                ->assertPathIs('/organizer/competitions')
                ->screenshot('detail-dan-kembali-berhasil');
        });
    }

    /** 
     * @test
     * @group organizeredit
     */
    public function test_organizer_can_edit_competition_successfully()
    {
        $this->browse(function (Browser $browser) {
            $organizer = User::factory()->create([
                'role' => 'organizer',
                'email' => 'organizer@example.com',
                'password' => bcrypt('12345678'),
            ]);

            // Buat lomba dummy dulu
            $competition = \App\Models\Competition::factory()->create([
                'organizer_id' => $organizer->id,
                'title' => 'Lomba Awal Dusk',
            ]);

            $browser->loginAs($organizer)
                ->visit('/organizer/competitions')
                ->assertSee('Lomba Awal Dusk')

                // Klik tombol edit (pakai icon)
                ->click('@edit-lomba-' . $competition->id)
                ->assertPathIs('/organizer/competitions/' . $competition->id . '/edit')
                ->pause(1000)

                // Edit judul saja
                ->type('title', 'Lomba Sudah Diedit Dusk')
                ->script("document.getElementById('competitionForm').submit();");

            $browser->pause(2000)
                ->assertPathIs('/organizer/competitions')
                ->assertSee('Lomba Sudah Diedit Dusk')
                ->screenshot('edit-berhasil');
        });
    }

    /** 
     * @test
     * @group organizereditinvalid
     */
    public function test_organizer_cannot_submit_invalid_edit_form()
    {
        $this->browse(function (Browser $browser) {
            $organizer = User::factory()->create([
                'role' => 'organizer',
                'email' => 'organizer@example.com',
                'password' => bcrypt('12345678'),
            ]);

            $competition = \App\Models\Competition::factory()->create([
                'organizer_id' => $organizer->id,
                'title' => 'Lomba Tidak Valid',
            ]);

            $browser->loginAs($organizer)
                ->visit('/organizer/competitions/' . $competition->id . '/edit')
                ->assertSee('Edit Lomba')

                // Kosongkan title dan submit
                ->clear('title')
                ->script("document.getElementById('competitionForm').submit();");

            $browser->pause(1500)
                ->assertPathIs('/organizer/competitions/' . $competition->id . '/edit')
                ->assertSee('Terjadi Kesalahan')
                ->assertSee('Judul Lomba') // Validasi muncul
                ->screenshot('edit-invalid-error');
        });
    }

    /** 
     * @test
     * @group organizerdel
     */
    public function test_organizer_can_delete_competition_from_index()
    {
        $this->browse(function (Browser $browser) {
            $organizer = User::factory()->create([
                'role' => 'organizer',
                'email' => 'organizer@example.com',
                'password' => bcrypt('12345678'),
            ]);

            $competition = \App\Models\Competition::factory()->create([
                'title' => 'Lomba Akan Dihapus',
                'organizer_id' => $organizer->id,
            ]);

            $browser->loginAs($organizer)
                ->visit('/organizer/competitions')
                ->assertSee('Lomba Akan Dihapus')
                ->script("window.confirm = () => true;");

            $browser->click('@hapus-lomba-' . $competition->id)
                ->pause(2000)
                ->assertPathIs('/organizer/competitions')
                ->assertDontSee('Lomba Akan Dihapus')
                ->screenshot('hapus-index-berhasil');
        });
    }

    /** 
     * @test
     * @group organizernavi
     */
    public function test_organizer_can_navigate_to_dashboard_and_logout()
    {
        $this->browse(function (Browser $browser) {
            $organizer = User::factory()->create([
                'role' => 'organizer',
                'email' => 'organizer@example.com',
                'password' => bcrypt('12345678'),
            ]);

            $competition = \App\Models\Competition::factory()->create([
                'title' => 'Lomba Logout Test',
                'organizer_id' => $organizer->id,
            ]);

            $browser->loginAs($organizer)
                ->visit("/organizer/competitions/{$competition->id}")
                ->assertSee('Lomba Logout Test')

                // Klik tombol "Dashboard" di header
                ->clickLink('Dashboard')
                ->pause(1000)
                ->assertPathIs('/organizer/dashboard')

                // Klik foto profil
                ->click('button[aria-label="User menu"]')
                ->pause(500)

                // Klik tombol Logout dari dropdown
                ->click('form[action="' . route('logout') . '"] button[type="submit"]')
                ->pause(1000)

                // Validasi redirect ke halaman login (atau landing)
                ->assertPathIs('/')
                ->screenshot('organizer-logout-success');
        });
    }
}
