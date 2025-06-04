<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Competition;
use App\Models\Team;
use App\Models\Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ManageTeamTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @group manageteam */
    public function test_user_can_create_team_then_invite_other_user_with_a_team()
    {
        $user = User::factory()->create([
            'email' => 'ripa@gmail.com',
            'password' => bcrypt('porseni23'),
        ]);

        $competition = Competition::factory()->create();
        $team = Team::factory()->create([
            'leader_id' => $user->id,
        ]);

        


        $this->browse(function (Browser $browser) use ($user, $competition, $team) {
            return $browser->visit('/')
                ->clickLink('Log In')
                ->assertPathIs('/login')
                ->type('email', $user->email)
                ->type('password', 'porseni23')
                ->press('Log In')
                ->assertPathIs('/dashboard')
                ->screenshot('debug-dashboard')
                ->click("@view-details-{$competition->id}")
                ->assertPathBeginsWith("/competitions/{$competition->id}")
                ->clickLink('Find Team Members')
                ->click('@invite-Gong')
                ->click('@create-team')
                ->type('@team-name', 'Tim Tam')
                ->scrollIntoView('@submit-team')
                ->press('@submit-team')
                ->waitForLocation('/invitations')
                ->waitFor('@send-invitation')
                ->select('@select-user', (string) $user->id)
                ->select('@select-team', (string) $team->id)
                ->click('@send-invitation')
                ->pause(1000)
                ->screenshot('after-invitation')
                ->waitForText('Success! Invitation sent!')
                ->assertSee('Invitation sent');
        });
    }

    public function test_user_can_send_message_in_invitation_chat()
    {
        $user = User::factory()->create([
            'email' => 'ripa@gmail.com',
            'password' => bcrypt('porseni23'),
        ]);

        $receiver = User::factory()->create([
            'name' => 'Gong',
            'email' => 'gong@gmail.com',
        ]);

        $invitation = \App\Models\Invitation::factory()->create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'status' => 'pending',
        ]);

    


        $this->browse(function (Browser $browser) use ($user, $invitation) {
            return $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'porseni23')
                ->press('Log In')
                ->assertPathIs('/dashboard')
                ->visit('/invitations')
                ->screenshot('invitation-list')
                ->click('@message-button-' . $invitation->id) // pastikan ada attribute `dusk="message-button-{{ $invitation->id }}"`
                ->assertPathIs('/invitations/' . $invitation->id)
                ->type('textarea[name="content"]', 'ikutlombayuk') // sesuaikan nama field jika perlu
                ->screenshot('after-chat-load')
                ->click('@send-message-button') // pastikan tombol kirim punya attribute dusk
                ->waitForText('ikutlombayuk')
                ->assertSee('ikutlombayuk')
                ->screenshot('chat-sent');
        });
    }

    public function test_receiver_can_accept_invitation_from_notification()
    {
        $sender = User::factory()->create([
            'email' => 'ripa@gmail.com',
            'password' => bcrypt('porseni23')
        ]);

        $receiver = User::factory()->create([
            'email' => 'gong@gmail.com',
            'password' => bcrypt('porseni23')
        ]);

        $team = Team::factory()->create([
            'leader_id' => $sender->id,
            'name' => 'Tim Gacor'
        ]);

        $invitation = \App\Models\Invitation::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'team_id' => $team->id,
            'status' => 'pending'
        ]);

        $notification = Notification::create([
            'user_id' => $receiver->id,
            'message' => 'Cut Rifa invited you to join the Tim Tam',
            'is_read' => false,
            'invitation_id' => $invitation->id, // <-- WAJIB
        ]);

        $this->browse(function (Browser $browser) use ($receiver, $invitation) {
            $browser->visit('/login')
                    ->type('email', $receiver->email)
                    ->type('password', 'porseni23')
                    ->press('Log In')
                    ->assertPathIs('/dashboard')
                    ->click('@notification-button') // klik lonceng
                    ->waitFor('@notification-item')
                    ->assertSee('Cut Rifa invited you to join the Tim Tam'); // verifikasi isi pesan
        });
    }


}
