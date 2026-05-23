<?php

namespace App\Http\Controllers;

use App\Models\UnknownWord;
use Illuminate\Http\Request;

class UnknownWordController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => UnknownWord::latest()->get(['id', 'word', 'meaning', 'sentence', 'np_word', 'enabled']),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'word'     => 'required|string|max:255',
            'meaning'  => 'required|string',
            'sentence' => 'required|string',
            'np_word'  => 'nullable|string|max:255',
        ]);

        $word = UnknownWord::create($validated);

        return response()->json([
            'data' => ['word' => $word->fresh()],
        ]);
    }

    public function show(UnknownWord $unknownWord)
    {
        return response()->json([
            'data' => ['word' => $unknownWord],
        ]);
    }

    public function update(Request $request, UnknownWord $unknownWord)
    {
        $validated = $request->validate([
            'word'     => 'required|string|max:255',
            'meaning'  => 'required|string',
            'sentence' => 'required|string',
            'np_word'  => 'nullable|string|max:255',
        ]);

        $unknownWord->update($validated);

        return response()->json([
            'data' => ['word' => $unknownWord->fresh()],
        ]);
    }

    public function random()
    {
        $words = UnknownWord::inRandomOrder()->limit(4)->get()->map(fn ($w) => [
            'id'      => $w->id,
            'word'    => $w->word,
            'meaning' => $w->meaning,
            'sentence'=> $w->sentence,
            'nepali'  => $w->np_word,
        ]);

        return response()->json(['data' => $words]);
    }

    public function toggle(UnknownWord $unknownWord)
    {
        $unknownWord->update(['enabled' => !$unknownWord->enabled]);

        return response()->json(['data' => ['id' => $unknownWord->id, 'enabled' => $unknownWord->enabled]]);
    }

    public function wallpaper()
    {
        $words = UnknownWord::inRandomOrder()
            ->limit(4)
            ->where('enabled', true)
            ->orderBy('word')
            ->get();

        return view('vocab-wallpaper', ['words' => $words]);
    }

    public function destroy(UnknownWord $unknownWord)
    {
        $unknownWord->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    public function managePage()
    {
        $isTokenValid = request('tkn') === 'gbwhbajwynxaoybndghamcxbghnbsawildjijnsiuhaidoiawdjiawdnawidnaklwdawd';
        
        
        abort_if(!$isTokenValid, 404); // tkn=9856
   

        return view('unknown-words');

    }
}
