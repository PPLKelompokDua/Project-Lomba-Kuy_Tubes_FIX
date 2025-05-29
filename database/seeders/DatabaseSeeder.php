<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Competition;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\Invitation;
use App\Models\Message;
use App\Models\SavedCompetition;
use App\Models\AssessmentHistory;
use App\Models\TeamRecommendation;
use App\Models\Assessment;
use App\Models\Contact;
use App\Models\Registration;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Event;
use App\Models\ForumPost;
use App\Models\Task;
use App\Models\Notification;
use App\Models\Feedback;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentOption;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@lombakuy.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'notification_preferences' => ['email', 'in_app'],
        ]);

        // Create organizer users
        $organizers = User::factory()->count(3)->create([
            'role' => 'organizer',
            'notification_preferences' => ['email', 'in_app'],
        ]);

        // Create regular users
        $users = User::factory()->count(10)->create([
            'role' => 'user',
            'notification_preferences' => ['email', 'in_app'],
        ]);

        // Create competitions
        $competitions = [];
        $competitionCategories = ['Academic', 'Technology', 'Business', 'Arts', 'Sports'];

        for ($i = 0; $i < 15; $i++) {
            $competitions[] = Competition::create([
                'title' => 'Competition ' . ($i + 1),
                'description' => 'Description for competition ' . ($i + 1),
                'category' => $competitionCategories[array_rand($competitionCategories)],
                'prize' => rand(1000000, 10000000),
                'deadline' => Carbon::now()->addDays(rand(1, 30)),
                'registration_link' => 'https://example.com/register',
                'location' => 'Location ' . ($i + 1),
                'start_date' => Carbon::now()->addDays(rand(1, 10)),
                'end_date' => Carbon::now()->addDays(rand(11, 40)),
                'max_participants' => rand(10, 100),
                'photo' => 'competition_' . ($i + 1) . '.jpg',
                'organizer_id' => $organizers->random()->id,
            ]);
        }

        // Create teams
        $teams = [];
        $teamStatuses = ['ongoing', 'finished'];
        for ($i = 0; $i < 8; $i++) {
            $competition = $competitions[array_rand($competitions)];
            $teams[] = Team::create([
                'name' => 'Team ' . ($i + 1),
                'description' => 'Description for team ' . ($i + 1),
                'leader_id' => $users->random()->id,
                'competition_id' => $competition->id,
                'competition_name' => $competition->title,
                'category' => $competition->category,
                'deadline' => $competition->deadline,
                'location' => $competition->location,
                'status_team' => $teamStatuses[array_rand($teamStatuses)],
            ]);
        }

        // Create team members
        foreach ($teams as $team) {
            $memberCount = rand(2, 5);
            $availableUsers = $users->whereNotIn('id', [$team->leader_id])->random($memberCount);
            
            foreach ($availableUsers as $user) {
                TeamMember::create([
                    'team_id' => $team->id,
                    'user_id' => $user->id,
                    'status' => 'accepted',
                ]);
            }
        }

        // Create invitations
        foreach ($teams as $team) {
            $invitationCount = rand(1, 3);
            $availableUsers = $users->whereNotIn('id', [$team->leader_id])->random($invitationCount);
            
            foreach ($availableUsers as $user) {
                Invitation::create([
                    'team_id' => $team->id,
                    'sender_id' => $team->leader_id,
                    'receiver_id' => $user->id,
                    'status' => 'pending',
                ]);
            }
        }

        // Create messages
        foreach ($teams as $team) {
            $messageCount = rand(5, 15);
            for ($i = 0; $i < $messageCount; $i++) {
                $teamMembers = $team->members;
                if ($teamMembers->isNotEmpty()) {
                    $sender = $teamMembers->random();
                    $invitation = Invitation::where('team_id', $team->id)->first();
                    Message::create([
                        'sender_id' => $sender->id,
                        'receiver_id' => $team->leader_id,
                        'invitation_id' => $invitation ? $invitation->id : null,
                        'content' => 'Message ' . ($i + 1) . ' from team ' . $team->name,
                        'read' => rand(0, 1),
                    ]);
                }
            }
        }

        // Create saved competitions
        foreach ($users as $user) {
            $savedCount = rand(1, 5);
            $competitionsToSave = collect($competitions)->random($savedCount);
            
            foreach ($competitionsToSave as $competition) {
                SavedCompetition::create([
                    'user_id' => $user->id,
                    'competition_id' => $competition->id,
                ]);
            }
        }

        // Create assessment questions and options
        $questions = [
            [
                'category' => 'Gaya Kerja',
                'question' => 'Bagaimana Anda menangani tekanan dalam tim?'
            ],
            [
                'category' => 'Kepemimpinan',
                'question' => 'Apa peran yang Anda sukai dalam tim?'
            ],
            [
                'category' => 'Problem Solving',
                'question' => 'Bagaimana Anda mendekati pemecahan masalah?'
            ],
            [
                'category' => 'Motivasi',
                'question' => 'Apa yang paling memotivasi Anda?'
            ],
            [
                'category' => 'Komunikasi',
                'question' => 'Bagaimana Anda menangani konflik dalam tim?'
            ]
        ];

        foreach ($questions as $questionData) {
            $assessmentQuestion = AssessmentQuestion::create([
                'category' => $questionData['category'],
                'question' => $questionData['question'],
            ]);

            // Create options for each question
            $options = [
                ['label' => 'A', 'text' => 'Sangat Tidak Setuju'],
                ['label' => 'B', 'text' => 'Tidak Setuju'],
                ['label' => 'C', 'text' => 'Netral'],
                ['label' => 'D', 'text' => 'Setuju'],
                ['label' => 'E', 'text' => 'Sangat Setuju'],
            ];

            foreach ($options as $option) {
                AssessmentOption::create([
                    'assessment_question_id' => $assessmentQuestion->id,
                    'label' => $option['label'],
                    'text' => $option['text'],
                ]);
            }
        }

        // Create assessments
        $personalityTypes = ['INTJ', 'ENFP', 'ISTJ', 'ENFJ'];
        $roleTypes = ['Leader', 'Member', 'Specialist', 'Coordinator'];
        $userAssessments = [];
        
        foreach ($users as $user) {
            $userAssessments[$user->id] = Assessment::create([
                'user_id' => $user->id,
                'results' => json_encode([
                    'personality' => $personalityTypes[array_rand($personalityTypes)],
                    'preferences' => $roleTypes[array_rand($roleTypes)]
                ]),
                'total_score' => rand(1, 100),
                'assessment_type' => 'team',
                'recommended_role' => $roleTypes[array_rand($roleTypes)],
                'strengths' => 'Komunikasi, Kepemimpinan, Problem Solving',
                'weaknesses' => 'Manajemen Waktu, Detail Oriented',
                'compatibility_score' => rand(1, 100),
            ]);
        }

        // Create assessment histories
        foreach ($users as $user) {
            if (isset($userAssessments[$user->id])) {
                AssessmentHistory::create([
                    'user_id' => $user->id,
                    'assessment_data' => json_encode([
                        'score' => rand(1, 100),
                        'answers' => [
                            'question1' => 'A',
                            'question2' => 'B',
                            'question3' => 'C',
                        ]
                    ]),
                    'personality_type' => $personalityTypes[array_rand($personalityTypes)],
                    'preferred_role' => $roleTypes[array_rand($roleTypes)],
                ]);
            }
        }

        // Create team recommendations
        foreach ($users as $user) {
            TeamRecommendation::create([
                'user_id' => $user->id,
                'role_recommendation' => $roleTypes[array_rand($roleTypes)],
                'strengths' => 'Komunikasi, Kepemimpinan, Problem Solving',
                'weaknesses' => 'Manajemen Waktu, Detail Oriented',
                'compatibility_score' => rand(1, 100),
            ]);
        }

        // Create tasks
        $taskStatuses = ['pending', 'in_progress', 'blocked', 'completed'];
        
        foreach ($teams as $team) {
            $taskCount = rand(3, 8);
            $teamMembers = $team->members;
            
            for ($i = 0; $i < $taskCount; $i++) {
                $assignedTo = $teamMembers->isNotEmpty() ? $teamMembers->random()->id : null;
                $status = $taskStatuses[array_rand($taskStatuses)];
                
                Task::create([
                    'team_id' => $team->id,
                    'title' => 'Task ' . ($i + 1),
                    'description' => 'Description for task ' . ($i + 1),
                    'status' => $status,
                    'due_date' => Carbon::now()->addDays(rand(1, 30)),
                    'assigned_user_id' => $assignedTo,
                    'user_id' => $team->leader_id,
                    'completed_at' => $status === 'completed' ? Carbon::now() : null,
                    'blocked_at' => $status === 'blocked' ? Carbon::now() : null,
                    'last_activity_at' => Carbon::now(),
                    'blocker_reason' => $status === 'blocked' ? 'Blocked reason' : null,
                ]);
            }
        }

        // Create posts
        foreach ($users as $user) {
            $postCount = rand(1, 3);
            for ($i = 0; $i < $postCount; $i++) {
                Post::create([
                    'user_id' => $user->id,
                    'caption' => 'Post caption ' . ($i + 1),
                    'media' => 'post_' . ($i + 1) . '.jpg',
                ]);
            }
        }

        // Create comments
        $posts = Post::all();
        foreach ($posts as $post) {
            $commentCount = rand(1, 5);
            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $users->random()->id,
                    'content' => 'Comment ' . ($i + 1),
                ]);
            }
        }

        // Create likes
        foreach ($posts as $post) {
            $likeCount = rand(1, 10);
            $usersToLike = $users->random($likeCount);
            
            foreach ($usersToLike as $user) {
                Like::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                ]);
            }
        }

        // Create notifications
        $notificationTypes = ['invitation', 'message', 'task', 'system'];
        
        foreach ($users as $user) {
            $notificationCount = rand(1, 5);
            for ($i = 0; $i < $notificationCount; $i++) {
                Notification::create([
                    'user_id' => $user->id,
                    'invitation_id' => Invitation::inRandomOrder()->first()->id,
                    'type' => $notificationTypes[array_rand($notificationTypes)],
                    'message' => 'Notification ' . ($i + 1),
                    'is_read' => rand(0, 1),
                    'link' => '/notifications/' . ($i + 1),
                ]);
            }
        }

        // Create feedback
        $feedbackTypes = ['member', 'organizer', 'platform'];
        
        foreach ($teams as $team) {
            $feedbackCount = rand(1, 3);
            for ($i = 0; $i < $feedbackCount; $i++) {
                Feedback::create([
                    'team_id' => $team->id,
                    'sender_id' => $users->random()->id,
                    'target_user_id' => $users->random()->id,
                    'type' => $feedbackTypes[array_rand($feedbackTypes)],
                    'content' => 'Feedback ' . ($i + 1),
                ]);
            }
        }

        // Create forum posts
        foreach ($users as $user) {
            $forumPostCount = rand(1, 2);
            for ($i = 0; $i < $forumPostCount; $i++) {
                ForumPost::create([
                    'user_id' => $user->id,
                    'title' => 'Forum Post ' . ($i + 1),
                    'content' => 'Forum post content ' . ($i + 1),
                ]);
            }
        }

        // Create events
        for ($i = 0; $i < 5; $i++) {
            Event::create([
                'name' => 'Event ' . ($i + 1),
                'description' => 'Description for event ' . ($i + 1),
                'date' => Carbon::now()->addDays(rand(1, 30)),
                'location' => 'Location ' . ($i + 1),
            ]);
        }

        // Create contacts
        for ($i = 0; $i < 5; $i++) {
            Contact::create([
                'name' => 'Contact ' . ($i + 1),
                'email' => 'contact' . ($i + 1) . '@example.com',
                'subject' => 'Subject ' . ($i + 1),
                'message' => 'Message ' . ($i + 1),
            ]);
        }

        // Create registrations
        $registrationStatuses = ['pending', 'approved', 'rejected'];
        
        foreach ($competitions as $competition) {
            $registrationCount = rand(1, 5);
            $usersToRegister = $users->random($registrationCount);
            
            foreach ($usersToRegister as $user) {
                $status = $registrationStatuses[array_rand($registrationStatuses)];
                Registration::create([
                    'user_id' => $user->id,
                    'competition_id' => $competition->id,
                    'status' => $status,
                    'notes' => 'Registration notes for ' . $user->name,
                    'additional_data' => json_encode(['team_size' => rand(1, 5)]),
                    'approved_at' => $status === 'approved' ? Carbon::now() : null,
                    'rejected_at' => $status === 'rejected' ? Carbon::now() : null,
                ]);
            }
        }
    }
}
