namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Competition;
use Illuminate\Support\Facades\Auth;

class CompetitionController extends Controller
{
    public function index()
    {
        $competitions = Competition::where('organizer_id', Auth::id())->get();
        return view('organizer.competitions.index', compact('competitions'));
    }

    public function create()
    {
        return view('organizer.competitions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category' => 'required',
            'deadline' => 'required|date',
            'prize' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('images', 'public');
        }

        $data['organizer_id'] = Auth::id();

        Competition::create($data);

        return redirect()->route('organizer.competitions.index')->with('success', 'Lomba berhasil ditambahkan!');
    }

    public function show(Competition $competition)
    {
        $this->authorizeAccess($competition);
        return view('organizer.competitions.show', compact('competition'));
    }

    public function edit(Competition $competition)
    {
        $this->authorizeAccess($competition);
        return view('organizer.competitions.edit', compact('competition'));
    }

    public function update(Request $request, Competition $competition)
    {
        $this->authorizeAccess($competition);

        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category' => 'required',
            'deadline' => 'required|date',
            'prize' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('images', 'public');
        }

        $competition->update($data);

        return redirect()->route('organizer.competitions.index')->with('success', 'Lomba berhasil diperbarui!');
    }

    public function destroy(Competition $competition)
    {
        $this->authorizeAccess($competition);
        $competition->delete();

        return back()->with('success', 'Lomba berhasil dihapus.');
    }

    protected function authorizeAccess(Competition $competition)
    {
        if ($competition->organizer_id !== Auth::id()) {
            abort(403, 'Akses ditolak');
        }
    }
}
