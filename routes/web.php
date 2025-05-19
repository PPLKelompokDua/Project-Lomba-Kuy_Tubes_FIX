<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\Organizer\CompetitionController as OrganizerCompetitionController;
use Illuminate\Support\Facades\Auth;
use App\Models\Competition;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\TeamRecommendationController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\RecommendationsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamsMemberController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\AssessmentQuestionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CompetitionMilestoneController;

// 🌐 Landing Page
Route::get('/', fn() => view('welcome'))->name('welcome');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// 🔐 Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/search-suggestions', [CompetitionController::class, 'searchSuggestions']);

// 🔍 Public Explore (tanpa login)
Route::get('/explore', [CompetitionController::class, 'explore'])->name('explore');
Route::get('/competitions/explore', [CompetitionController::class, 'explore'])->name('competitions.explore');

// 🔐 Protected Routes (role-based dashboard)
Route::middleware(['auth'])->group(function () {
    
    // Feedback Routes
    Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks.index');
    Route::get('/feedbacks/create', [FeedbackController::class, 'create'])->name('feedbacks.create');
    Route::get('/feedbacks/received', [FeedbackController::class, 'received'])->name('feedbacks.received');
    Route::get('/feedbacks/{team_id}/edit', [FeedbackController::class, 'edit'])->name('feedbacks.edit');
    Route::put('/feedbacks/update-by-team/{team_id}', [FeedbackController::class, 'updateByTeam'])->name('feedbacks.updateByTeam');
    Route::delete('/feedbacks/destroy-by-team/{team_id}', [FeedbackController::class, 'destroyByTeam'])->name('feedbacks.destroyByTeam');
    Route::post('/feedbacks', [FeedbackController::class, 'store'])->name('feedbacks.store');

    //Settings dan Profile
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::put('/settings', [ProfileController::class, 'settingsUpdate'])->name('settings.update');
    Route::delete('/settings', [ProfileController::class, 'delete'])->name('settings.delete');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password/edit', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Bookmark actions
    Route::post('/competitions/{competition}/save', [CompetitionController::class, 'save'])->name('competitions.save');
    Route::delete('/competitions/{competition}/unsave', [CompetitionController::class, 'unsave'])->name('competitions.unsave');

    // 🔥 Tambahkan ini untuk halaman list bookmark
    Route::get('/saved-competitions', [CompetitionController::class, 'saved'])->name('competitions.saved');

    // Untuk lihat detail kompetisi
    Route::get('/competitions/{competition}', [CompetitionController::class, 'show'])->name('competitions.show');

    // Untuk cari anggota tim random
    Route::get('/competitions/{competition}/random-members', [CompetitionController::class, 'randomMembers'])->name('competitions.random-members');

    // Assessment Routes
    Route::get('/assessment', [AssessmentController::class, 'index'])->name('assessment.index');
    Route::post('/assessment', [AssessmentController::class, 'store'])->name('assessment.store');

    Route::get('/assessment/internal', [AssessmentController::class, 'showTestForm'])->name('assessment.form');
    Route::post('/assessment/internal', [AssessmentController::class, 'submitTest'])->name('assessment.submit');

    // Team Recommendation Route
    Route::get('/team-recommendation', [TeamRecommendationController::class, 'generateRecommendation'])
        ->name('team.recommendation');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])
     ->name('notifications.index');

    Route::get('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.markAsRead');
    Route::get('/notifications/{notification}/read', [NotificationController::class, 'readAndRedirect'])
        ->name('notifications.read');
    
    // Invitations
    Route::prefix('invitation')->group(function () {
    Route::resource('invitation', InvitationController::class);
    Route::post('invitation/{invitation}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('invitation/{invitation}/decline', [InvitationController::class, 'decline'])->name('invitations.decline');
    Route::delete('invitation/{invitation}', [InvitationController::class, 'cancel'])->name('invitations.cancel');
    Route::get('invitation/team/{team}', [InvitationController::class, 'trackTeamInvitations'])->name('invitations.team');
    Route::post('/invitations/{invitation}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/invitations/{invitation}/decline', [InvitationController::class, 'decline'])->name('invitations.decline');
    Route::get('/invitations/{invitation}', [InvitationController::class, 'show'])->name('invitations.show');
    Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');

    });

    Route::resource('invitations', \App\Http\Controllers\invitationController::class);
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');

    // Messages
    Route::prefix('messages')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/user/{user}', [MessageController::class, 'conversation'])->name('messages.conversation');
        Route::post('/send', [MessageController::class, 'send'])->name('messages.send');
        Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
        Route::get('/invitation/{invitation}', [MessageController::class, 'invitationMessages'])->name('messages.invitation');
    });

    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');

    Route::get('/teams/create-from-competition/{competition}', [TeamController::class, 'createFromCompetition'])->name('teams.create-from-competition');
    Route::get('/teams/create-from-recommendation/{userId}', [TeamController::class, 'createFromRecommendation'])->name('teams.createFromRecommendation');


    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/teams/{id}', [TeamController::class, 'show'])->name('teams.show');
    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');
    Route::patch('/teams/{team}/status', [TeamController::class, 'updateStatus'])->name('teams.updateStatus');


    // Posts
    Route::get('/stories', [PostController::class, 'index'])->name('posts.index');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    
    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/posts/{post}/comments', [CommentController::class, 'fetch'])->name('comments.fetch');

    //Likes
    Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
    Route::delete('/posts/{post}/unlike', [PostController::class, 'unlike'])->name('posts.unlike');

    //delete post
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // API untuk ambil comment list (optional kalau mau ajax beneran)
    Route::get('/stories/{post}/comments', function ($postId) {
        $post = \App\Models\Post::with('comments.user')->findOrFail($postId);
        return response()->json(
            $post->comments->map(fn($comment) => [
                'user_name' => $comment->user->name,
                'comment' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),
            ])
        );
    });

    //Task management
    Route::resource('tasks', TaskController::class);
    Route::get('/teams/{team}/tasks', [TaskController::class, 'forTeam'])->name('tasks.team');



    // Dashboard redirect sesuai role
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        if ($role === 'admin') return redirect()->route('admin.dashboard');
        if ($role === 'organizer') return redirect()->route('organizer.dashboard');
    
        $competitions = Competition::latest()->take(6)->get();
        $user = auth()->user(); // ambil user sekarang
    
        // Tambahan menghitung saved
        $savedCompetitions = $user->savedCompetitions()->count(); 
    
        // Tambahan menghitung active dan completed competitions (dummy dulu 0)
        $activeCompetitions = 0; // kalau belum ada fitur lomba aktif
        $completedCompetitions = 0; // kalau belum ada fitur lomba selesai
    
        return view('dashboard', compact('competitions', 'savedCompetitions', 'activeCompetitions', 'completedCompetitions', 'user'));
    })->name('dashboard');

    Route::get('/dashboard', [\App\Http\Controllers\UserDashboardController::class, 'index'])->name('dashboard');
    
    // Admin
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');

    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/feedbacks', [FeedbackController::class, 'receivedForAdmin'])->name('feedbacks.index');

        Route::resource('assessment-questions', \App\Http\Controllers\Admin\AssessmentQuestionController::class);
        Route::resource('assessment-questions', AssessmentQuestionController::class);
});
    
    // Organizer
    Route::get('/organizer/dashboard', [OrganizerCompetitionController::class, 'index'])->name('organizer.dashboard');
    
    Route::middleware(['auth'])->prefix('organizer')->name('organizer.')->group(function () {
        Route::resource('competitions', OrganizerCompetitionController::class);

        Route::resource('competitions', \App\Http\Controllers\Organizer\CompetitionController::class);

        Route::get('/feedbacks', [FeedbackController::class, 'receivedForOrganizer'])->name('feedbacks.index');
    });

    // Milestone 


    Route::prefix('competitions/{competition}/milestones')->group(function () {
        Route::get('/', [CompetitionMilestoneController::class, 'index'])->name('milestones.index');
        Route::get('/create', [CompetitionMilestoneController::class, 'create'])->name('milestones.create');
        Route::post('/', [CompetitionMilestoneController::class, 'store'])->name('milestones.store');

        Route::get('/{milestone}/edit', [CompetitionMilestoneController::class, 'edit'])->name('milestones.edit');
        Route::put('/{milestone}', [CompetitionMilestoneController::class, 'update'])->name('milestones.update');
        Route::delete('/{milestone}', [CompetitionMilestoneController::class, 'destroy'])->name('milestones.destroy');

    });


});