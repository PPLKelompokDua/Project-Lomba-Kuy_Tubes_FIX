<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $team = Team::with('acceptedMembers', 'leader')->findOrFail($request->team_id);

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
        ]);

        $team = Team::with('acceptedMembers', 'competition')->findOrFail($request->team_id);

        $senderId = auth()->id();

        $feedbacksForMe = Feedback::where('target_user_id', Auth::id())->get();

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

        return redirect()->route('feedbacks.index')->with('success', 'Feedback berhasil dikirim!');
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
    public function edit(Feedback $feedback)
    {
        $team = $feedback->team;

        $memberFeedback = Feedback::where('team_id', $team->id)
            ->where('sender_id', auth()->id())
            ->where('type', 'member')
            ->get()
            ->keyBy('target_user_id');

        $platformFeedback = Feedback::where('team_id', $team->id)
            ->where('sender_id', auth()->id())
            ->where('type', 'platform')
            ->first();

        $organizerFeedback = Feedback::where('team_id', $team->id)
            ->where('sender_id', auth()->id())
            ->where('type', 'organizer')
            ->first();

        return view('feedbacks.edit', compact('feedback', 'team', 'memberFeedback', 'platformFeedback', 'organizerFeedback'));
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

        // Hapus semua feedback dari user ini untuk tim tersebut
        Feedback::where('team_id', $team_id)
            ->where('sender_id', $senderId)
            ->delete();

        return redirect()->route('feedbacks.index')->with('success', 'Feedback berhasil dihapus.');
    }
    
    public function received()
    {
        $feedbacksForMe = Feedback::where('target_user_id', auth()->id())->latest()->get();

        return view('feedbacks.received', compact('feedbacksForMe'));
    }

    public function updateByTeam(Request $request, $team_id)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id',
        ]);

        $team = Team::with('acceptedMembers', 'competition')->findOrFail($team_id);
        $senderId = auth()->id();

        // Update feedback untuk anggota
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

        // Update feedback platform
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

        // Update feedback organizer jika ada
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

        return redirect()->route('feedbacks.index')->with('success', 'Feedback berhasil diperbarui!');
    }


}
