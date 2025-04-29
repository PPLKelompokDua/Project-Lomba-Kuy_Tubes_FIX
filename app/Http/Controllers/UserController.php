<?php

namespace App\Http\Controllers;

use App\Models\EventModel;
use App\Models\TimModel;
use Illuminate\Http\Request;
use App\Models\PostCompetitionModel;
use App\Models\CommentCompetition;
class UserController extends Controller
{
    public function CompetitionUser(){
        $data = PostCompetitionModel::where('user_id', auth()->user()->id)->get();
        return view('user.competition.list-competition-user', compact('data'));
    }

    public function CompetitionAll(){
        $data = PostCompetitionModel::with('user','comments','comments.user')->get();
        return view('user.competition.list-competition-all', compact('data'));
    }

    public function CompetitionForm(int $id = null){
        if($id){
            $data = PostCompetitionModel::findOrFail($id);
            return view('user.competition.competition-form', compact('data','id'));
        }
        return view('user.competition.competition-form');
    }

    public function CompetitionStore(Request $request){
        $data = $request->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:3',
        ]);
        $data['user_id'] = auth()->user()->id;
        PostCompetitionModel::create($data);
        return redirect()->route('list-competition-user')->with('success', 'Data berhasil ditambahkan');
    }

    public function CompetitionUpdate(Request $request, int $id){
        $data = $request->validate([
            'title' =>'required|min:3',
            'description' =>'required|min:3',
        ]);
        $data['user_id'] = auth()->user()->id;
        PostCompetitionModel::findOrFail($id)->update($data);
        return redirect()->route('list-competition-user')->with('success', 'Data berhasil diupdate');
    }

    public function CompetitionDelete(int $id){
        PostCompetitionModel::findOrFail($id)->delete();
        return redirect()->route('list-competition-user')->with('success', 'Data berhasil dihapus');
    }

    public function CommentCompetitionStore(int $id, Request $request){
        $data = $request->validate([
            'comment' =>'required|min:3',
        ]);

        $data['post_competition_id'] = $id;
        $data['user_id'] = auth()->user()->id;
        // return dd($data);
        CommentCompetition::create($data);
        return redirect()->route('list-competition-all')->with('success', 'Data berhasil ditambahkan');
    }

    public function ListTim(){
        $data = TimModel::with('feedback','feedback.user')->get();
        return view('user.tim.list-my-tim', compact('data'));
    }

    public function TimFeedbackStore(Request $request){
        $data = $request->validate([
            'tim_id' =>'required',
            'feedback' =>'required|min:3',
        ]);

        $data['user_id'] = auth()->user()->id;
        TimModel::findOrFail($data['tim_id'])->feedback()->create($data);
        return redirect()->route('list-tim')->with('success', 'Data berhasil ditambahkan');
    }

    public function TimFeedbackUpdate($id, Request $request){
        $data = $request->validate([
            'tim_id' =>'required',
            'feedback' =>'required|min:3',
        ]);
        $data['user_id'] = auth()->user()->id;
        TimModel::findOrFail($data['tim_id'])->feedback()->findOrFail($id)->update($data);
        return redirect()->route('list-tim')->with('success', 'Data berhasil diupdate');
    }

    public function TimFeedbackDelete($id,Request $request){
        $data = $request->validate([
            'tim_id' =>'required'
        ]);
        TimModel::findOrFail($data['tim_id'])->feedback()->findOrFail($id)->delete();
        return redirect()->route('list-tim')->with('success', 'Data berhasil dihapus');
    }

    public function ListEvent(){
        $data = EventModel::with('feedbackEvent','feedbackEvent.user')->get();
        return view('user.event.list-my-event', compact('data'));
    }

    public function EventFeedbackStore(Request $request){
        $data = $request->validate([
            'event_id' =>'required',
            'feedback' =>'required|min:3',
        ]);
        $data['user_id'] = auth()->user()->id;
        EventModel::findOrFail($data['event_id'])->feedbackEvent()->create($data);
        return redirect()->route('list-event')->with('success', 'Data berhasil ditambahkan');
    }

    public function EventFeedbackUpdate($id, Request $request){
        $data = $request->validate([
            'event_id' =>'required',
            'feedback' =>'required|min:3',
        ]);
        $data['user_id'] = auth()->user()->id;
        EventModel::findOrFail($data['event_id'])->feedbackEvent()->findOrFail($id)->update($data);
        return redirect()->route('list-event')->with('success', 'Data berhasil diupdate');
    }

    public function EventFeedbackDelete($id,Request $request){
        $data = $request->validate([
            'event_id' =>'required'
        ]);
        EventModel::findOrFail($data['event_id'])->feedbackEvent()->findOrFail($id)->delete();
        return redirect()->route('list-event')->with('success', 'Data berhasil dihapus');
    }

}
