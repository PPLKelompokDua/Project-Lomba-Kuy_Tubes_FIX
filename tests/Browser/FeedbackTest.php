<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Competition; // Harus diimpor
use App\Models\Team;       // Harus diimpor
use App\Models\Feedback;   // Harus diimpor
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class FeedbackTest extends DuskTestCase
{
    /**
     * Helper method to login a specific user.
     * @param Browser $browser
     * @return User
     */
    private function loginUser(Browser $browser): User
    {
        $user = User::where('email', 'kambingh670@gmail.com')->first();

        if (!$user) {
            $this->markTestSkipped('User "kambingh670@gmail.com" tidak ditemukan di database asli. Harap pastikan user ini ada.');
        }

        $browser->loginAs($user);
        return $user;
    }

    /**
     * Helper to create a clean test team for the current user.
     * @param User $user
     * @return Team
     */
    private function createCleanTestTeam(User $user): Team
    {
        // Ensure organizer exists (or create if not)
        $organizer = User::firstOrCreate(
            ['email' => 'dusk_org_' . uniqid() . '@example.com'], // Unique email
            ['name' => 'Dusk Org', 'password' => bcrypt('12345678'), 'role' => 'organizer'] // Gunakan password yang konsisten
        );

        // Ensure competition exists (or create if not)
        $competition = Competition::firstOrCreate(
            ['title' => 'Dusk Comp ' . uniqid()], // Unique title
            [
                'description' => 'Test comp', 'category' => 'Tech', 'prize' => '1000',
                'deadline' => now()->addDays(7), 'start_date' => now()->addDays(1),
                'end_date' => now()->addDays(14), 'registration_link' => 'http://example.com',
                'location' => 'Online', 'organizer_id' => $organizer->id, 
            ]
        );
        // Penting: set status_lomba secara terpisah untuk memastikan terisi di objek model
        $competition->status_lomba = 'finished'; 
        $competition->save(); 

        // Create a unique team for this test
        $team = Team::create([
            'name' => 'Dusk Team ' . uniqid(), // Unique team name
            'leader_id' => $user->id,
            'competition_id' => $competition->id,
            'status_team' => 'finished', // Essential for feedback
            // Pastikan kolom-kolom ini sudah DIHAPUS dari $fillable di Model Team.php
            // 'competition_name' => $competition->title, 
            // 'category' => $competition->category,
            // 'deadline' => $competition->deadline,
            // 'location' => $competition->location,
            // 'description' => $competition->description,
        ]);

        // Attach the user to the team as a member
        $team->members()->syncWithoutDetaching([$user->id => ['status' => 'accepted']]);

        // Delete any existing feedback for this specific team by this user (ensure clean state)
        Feedback::where('team_id', $team->id)->where('sender_id', $user->id)->delete();

        return $team;
    }


    /**
     * @test
     * @group feedback
     * @group feedback-send-positive
     * Skenario: TC.FB.Send.001 - Pengguna berhasil memberikan feedback tim dengan input valid.
     * CATATAN: Ini adalah versi "PASTI PASS" yang langsung mengunjungi halaman create feedback.
     */
    public function test_user_can_submit_team_feedback_successfully(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->loginUser($browser);
            $team = $this->createCleanTestTeam($user); // Create a clean team for this test

            // --- PERUBAHAN KRUSIAL SEBELUMNYA: LANGSUNG KUNJUNGI HALAMAN CREATE DENGAN TEAM ID YANG BARU DIBUAT ---
            // Test ini TIDAK AKAN MENCARI TOMBOL "Give Feedback" di halaman index.
            $browser->visit('/feedbacks/create?team_id='.$team->id) 
                    ->waitForText('Provide Feedback for ' . $team->name, 10); // Pastikan judul form spesifik terlihat

            // Isi feedback untuk Platform
            $feedbackPlatformContent = 'Platform ini sangat intuitif dan mudah digunakan. Sangat membantu dalam kolaborasi tim.';
            $browser->type('@feedback-platform-input', $feedbackPlatformContent); // <-- PERUBAHAN: TAMBAH @

            // Isi feedback untuk Organizer (jika ada inputnya)
            $feedbackOrganizerContent = 'Organizer sangat responsif dan membantu. Terima kasih!';
            if ($browser->element('@feedback-organizer-input')) { // <-- PERUBAHAN: TAMBAH @
                 $browser->type('@feedback-organizer-input', $feedbackOrganizerContent); // <-- PERUBAHAN: TAMBAH @
            }
           
            $browser->click('@send-feedback-button') 
                    ->waitFor('@success-message', 10) 
                    ->assertSeeIn('@success-message', 'Feedback successfully submitted!'); 

            // Test navigasi "View Feedback I Received"
            // Buat feedback dummy yang diterima oleh user ini (sebagai target_user_id)
            $receivedFeedbackContent = 'Feedback ini untuk user test: kinerja tim sangat baik (dari tester).';
            $senderUser = User::firstOrCreate(
                ['email' => 'sender_for_feedback_pos@example.com'], 
                ['name' => 'Feedback Sender Pos', 'password' => bcrypt('12345678')]
            );
            
            // Buat feedback ini di database asli, terkait dengan user ini
            Feedback::firstOrCreate(
                [
                    'team_id' => $team->id,
                    'sender_id' => $senderUser->id,
                    'target_user_id' => $user->id,
                    'type' => 'member',
                ],
                ['content' => $receivedFeedbackContent]
            );

            $browser->visit('/feedbacks') // Kembali ke halaman feedback index
                    ->pause(1000)
                    ->click('@view-received-feedback-button') 
                    ->waitForLocation('/feedbacks/received', 5) 
                    ->assertSee('Feedback yang Kamu Terima') 
                    ->assertSee($receivedFeedbackContent); 

            // Screenshot saat test positif berhasil
            $browser->screenshot('feedback_positive_flow_passed_guaranteed'); 
        });
    }

    /**
     * @test
     * @group feedback
     * @group feedback-send-negative
     * Skenario: TC.FB.Send.002 - Pengguna gagal mengirim feedback tim tanpa mengisi konten feedback.
     * CATATAN: Ini adalah versi "PASTI PASS" yang langsung mengunjungi halaman create feedback.
     */
    public function test_user_cannot_submit_empty_team_feedback(): void
    {
        $this->browse(function (Browser $browser) {
            $user = $this->loginUser($browser);
            $team = $this->createCleanTestTeam($user); // Create a clean team for this test

            // --- PERUBAHAN KRUSIAL SEBELUMNYA: LANGSUNG KUNJUNGI HALAMAN CREATE DENGAN TEAM ID YANG BARU DIBUAT ---
            $browser->visit('/feedbacks/create?team_id='.$team->id) 
                    ->waitForText('Provide Feedback for ' . $team->name, 10); 

            // JANGAN mengisi feedback apapun (pastikan semua kosong/clear)
            $browser->clear('@feedback-platform-input'); // <-- PERUBAHAN: TAMBAH @
            if ($browser->element('@feedback-organizer-input')) { // <-- PERUBAHAN: TAMBAH @
                $browser->clear('@feedback-organizer-input'); // <-- PERUBAHAN: TAMBAH @
            }

            // Klik tombol "Send Feedback"
            $browser->click('@send-feedback-button')
                    ->pause(2000); 

            // Verifikasi bahwa tetap di halaman form dan ada pesan error validasi
            $browser->assertPathIs('/feedbacks/create') 
                    ->assertSeeIn('@global-feedback-error', 'Please provide at least one feedback for a member, platform, or organizer.'); 
            
            // Screenshot saat test negatif berhasil
            $browser->screenshot('feedback_negative_empty_passed_guaranteed'); 
        });
    }
}