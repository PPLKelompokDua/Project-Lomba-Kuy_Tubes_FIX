namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->get();
        return view('feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        return view('feedback.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peserta' => 'required',
            'lomba' => 'required',
            'umpan_balik' => 'required',
            'evaluasi' => 'required',
        ]);

        Feedback::create($request->all());

        return redirect()->route('feedback.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit(Feedback $feedback)
    {
        return view('feedback.edit', compact('feedback'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        $request->validate([
            'nama_peserta' => 'required',
            'lomba' => 'required',
            'umpan_balik' => 'required',
            'evaluasi' => 'required',
        ]);

        $feedback->update($request->all());

        return redirect()->route('feedback.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('feedback.index')->with('success', 'Data berhasil dihapus!');
    }
}
