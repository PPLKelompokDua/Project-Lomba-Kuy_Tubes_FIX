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
        $this->call([
            UserSeeder::class,
            CompetitionSeeder::class,
            AssessmentQuestionsSeeder::class,
            ArticleSeeder::class,
            LearningVideoSeeder::class,
        ]);
    }
}