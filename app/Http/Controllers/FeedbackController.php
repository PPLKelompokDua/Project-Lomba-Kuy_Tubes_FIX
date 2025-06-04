<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Competition; // Pastikan ini diimpor jika belum ada

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil tim yang user ikuti (sebagai leader/member)
        $ledTeams = $user->ledTeams()->get();
        $memberTeams = $user->memberTeams()->get();

        // Gabung tim dan hilangkan duplikat
        $allTeams = $ledTeams->merge($memberTeams)->unique('id');

        // Ambil feedback yang sudah diberikan user
        $givenFeedback = Feedback::where('sender_id', $user->id)->pluck('team_id')->toArray();

        return view('feedbacks.index', compact('allTeams', 'givenFeedback'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Kode asli kamu, Team::with('acceptedMembers', 'leader', 'competition')
        $team = Team::with('acceptedMembers', 'leader', 'competition')->findOrFail($request->team_id);

        if ($team->status_team !== 'finished') {
            abort(403, 'Tim belum selesai mengikuti lomba.');
        }

        $competition = $team->competition;

        return view('feedbacks.create', compact('team', 'competition'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'feedback_member.*' => 'nullable|string|max:1000',
            'feedback_platform' => 'nullable|string|max:1000',
            'feedback_organizer' => 'nullable|string|max:1000',
        ], [
            'feedback_member.*.max' => 'Member feedback must not exceed 1000 characters.',
            'feedback_platform.max' => 'Platform feedback must not exceed 1000 characters.',
            'feedback_organizer.max' => 'Organizer feedback must not exceed 1000 characters.',
        ]);

        $hasFeedback = collect($request->input('feedback_member', []))->filter()->isNotEmpty() ||
                        $request->filled('feedback_platform') ||
                        $request->filled('feedback_organizer');

        if (!$hasFeedback) {
            return redirect()->back()->withErrors(['feedback' => 'Please provide at least one feedback for a member, platform, or organizer.'])->withInput();
        }

        $team = Team::with('acceptedMembers', 'competition')->findOrFail($request->team_id);
        $senderId = auth()->id();

        foreach ($request->input('feedback_member', []) as $userId => $content) {
            if ($content) {
                Feedback::updateOrCreate([
                    'team_id' => $team->id,
                    'sender_id' => $senderId,
                    'target_user_id' => $userId,
                    'type' => 'member',
                ], [
                    'content' => $content,
                ]);
            }
        }

        if ($request->filled('feedback_platform')) {
            Feedback::updateOrCreate([
                'team_id' => $team->id,
                'sender_id' => $senderId,
                'type' => 'platform',
                'target_user_id' => null,
            ], [
                'content' => $request->feedback_platform,
            ]);
        }

        if ($team->competition_id && $request->filled('feedback_organizer')) {
            $competition = $team->competition;
            if ($competition && $competition->organizer_id) {
                Feedback::updateOrCreate([
                    'team_id' => $team->id,
                    'sender_id' => $senderId,
                    'type' => 'organizer',
                    'target_user_id' => $competition->organizer_id,
                ], [
                    'content' => $request->feedback_organizer,
                ]);
            }
        }

        return redirect()->route('feedbacks.index')->with('success', 'Feedback successfully submitted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($team_id)
    {
        $team = Team::with('acceptedMembers', 'leader', 'competition')->findOrFail($team_id);
        $senderId = auth()->id();

        $memberFeedback = Feedback::where('team_id', $team->id)
            ->where('sender_id', $senderId)
            ->where('type', 'member')
            ->get()
            ->keyBy('target_user_id');

        $platformFeedback = Feedback::where('team_id', $team->id)
            ->where('sender_id', $senderId)
            ->where('type', 'platform')
            ->first();

        $organizerFeedback = Feedback::where('team_id', $team->id)
            ->where('sender_id', $senderId)
            ->where('type', 'organizer')
            ->first();

        return view('feedbacks.edit', compact('team', 'memberFeedback', 'platformFeedback', 'organizerFeedback'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feedback $feedback)
    {

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $feedback->update([
            'content' => $request->input('content'),
        ]);

        return redirect()->route('feedbacks.index')->with('success', 'Feedback berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyByTeam($team_id)
    {
        $senderId = auth()->id();

        Feedback::where('team_id', $team_id)
            ->where('sender_id', $senderId)
            ->delete();

        return redirect()->route('feedbacks.index')->with('success', 'Feedback berhasil dihapus.');
    }
    
    public function received()
    {
        $feedbacksForMe = Feedback::where('target_user_id', auth()->id())
            ->with('sender')
            ->latest()
            ->get();

        return view('feedbacks.received', compact('feedbacksForMe'));
    }

    public function updateByTeam(Request $request, $team_id)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'feedback_member.*' => 'nullable|string|max:1000',
            'feedback_platform' => 'nullable|string|max:1000',
            'feedback_organizer' => 'nullable|string|max:1000',
        ], [
            'feedback_member.*.max' => 'Member feedback must not exceed 1000 characters.',
            'feedback_platform.max' => 'Platform feedback must not exceed 1000 characters.',
            'feedback_organizer.max' => 'Organizer feedback must not exceed 1000 characters.',
        ]);

        $hasFeedback = collect($request->input('feedback_member', []))->filter()->isNotEmpty() ||
                        $request->filled('feedback_platform') ||
                        $request->filled('feedback_organizer');

        if (!$hasFeedback) {
            return redirect()->back()->withErrors(['feedback' => 'Please provide at least one feedback for a member, platform, or organizer.'])->withInput();
        }

        $team = Team::with('acceptedMembers', 'competition')->findOrFail($team_id);
        $senderId = auth()->id();

        foreach ($request->input('feedback_member', []) as $userId => $content) {
            if ($content) {
                Feedback::updateOrCreate([
                    'team_id' => $team->id,
                    'sender_id' => $senderId,
                    'target_user_id' => $userId,
                    'type' => 'member',
                ], [
                    'content' => $content,
                ]);
            } else {
                Feedback::where([
                    'team_id' => $team->id,
                    'sender_id' => $senderId,
                    'target_user_id' => $userId,
                    'type' => 'member',
                ])->delete();
            }
        }

        if ($request->filled('feedback_platform')) {
            Feedback::updateOrCreate([
                'team_id' => $team->id,
                'sender_id' => $senderId,
                'type' => 'platform',
                'target_user_id' => null,
            ], [
                'content' => $request->feedback_platform,
            ]);
        } else {
            Feedback::where([
                'team_id' => $team->id,
                'sender_id' => $senderId,
                'type' => 'platform',
                'target_user_id' => null,
            ])->delete();
        }

        if ($team->competition_id && $request->filled('feedback_organizer')) {
            $competition = $team->competition;
            if ($competition && $competition->organizer_id) {
                Feedback::updateOrCreate([
                    'team_id' => $team->id,
                    'sender_id' => $senderId,
                    'type' => 'organizer',
                    'target_user_id' => $competition->organizer_id,
                ], [
                    'content' => $request->feedback_organizer,
                ]);
            }
        } else {
            Feedback::where([
                'team_id' => $team->id,
                'sender_id' => $senderId,
                'type' => 'organizer',
            ])->delete();
        }

        return redirect()->route('feedbacks.index')->with('success', 'Feedback successfully updated!');
    }

    public function receivedForOrganizer()
    {
        $user = Auth::user();

        if ($user->role !== 'organizer') {
            abort(403);
        }

        $organizerFeedbacks = Feedback::where('type', 'organizer')
            ->where('target_user_id', $user->id)
            ->with(['sender', 'team.competition'])
            ->latest()
            ->get();

        return view('organizer.feedbacks.index', compact('organizerFeedbacks'));
    }

    public function receivedForAdmin()
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            abort(403);
        }

        $platformFeedbacks = Feedback::where('type', 'platform')
            ->with(['sender', 'team'])
            ->latest()
            ->get();

        return view('admin.feedbacks.index', compact('platformFeedbacks'));
    }

}