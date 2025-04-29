namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::latest()->get();
        return view('stories.index', compact('stories'));
    }

    public function create()
    {
        return view('stories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'type' => 'required|in:story,prestasi',
        ]);

        Story::create($request->all());
        return redirect()->route('stories.index')->with('success', 'Story created successfully.');
    }

    public function show(Story $story)
    {
        return view('stories.show', compact('story'));
    }

    public function edit(Story $story)
    {
        return view('stories.edit', compact('story'));
    }

    public function update(Request $request, Story $story)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'type' => 'required|in:story,prestasi',
        ]);

        $story->update($request->all());
        return redirect()->route('stories.index')->with('success', 'Story updated successfully.');
    }

    public function destroy(Story $story)
    {
        $story->delete();
        return redirect()->route('stories.index')->with('success', 'Story deleted successfully.');
    }
}
