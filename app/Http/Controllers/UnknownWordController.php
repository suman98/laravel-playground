<?php

namespace App\Http\Controllers;

use App\Models\UnknownWord;
use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;

class UnknownWordController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => UnknownWord::latest()->get(['id', 'word', 'meaning', 'sentence', 'np_word', 'enabled', 'is_familiar']),
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
        $words = UnknownWord::select(
            'id',
            'word',
            'meaning',
            'sentence',
            'np_word as nepali'
        )
        ->orderBy('updated_at', 'asc')
        ->limit(10)
        ->get()
        ->random(4);
    
        UnknownWord::whereIn('id', $words->pluck('id'))
            ->update(['updated_at' => now()]);

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
            ->where('is_familiar', false)
            ->orderBy('word')
            ->get();
        $quote = Inspiring::quote();
  
        return view('vocab-wallpaper', compact('words', 'quote'));
    }

    public function all(Request $request)
    {
        $column = $request->input('column');
        if ($column && \Schema::hasColumn('unknown_words', $column)) {
            $words = UnknownWord::pluck($column)->toArray();
            return response()->json(['data' => $words]);
        } else {
            $words = UnknownWord::select('word', 'meaning', 'sentence', 'np_word')->enabled()->get();
       
            return response()->json(['data' => $words]);
        }
    }

    public function destroy(UnknownWord $unknownWord)
    {
        $unknownWord->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }

    public function slides()
    {
        return view('vocab-slides');
    }

    public function markFamiliar(Request $request)
    {
        $request->validate(['id' => 'required|integer|exists:unknown_words,id']);
        $word = UnknownWord::findOrFail($request->id);
        $word->update(['is_familiar' => true]);

        return response()->json(['data' => $word->fresh()]);
    }

    public function markUnfamiliar(Request $request)
    {
        $request->validate(['id' => 'required|integer|exists:unknown_words,id']);
        $word = UnknownWord::findOrFail($request->id);
        $word->update(['is_familiar' => false]);

        return response()->json(['data' => $word->fresh()]);
    }

    public function resetFamiliar()
    {
        UnknownWord::query()->update(['is_familiar' => false]);

        return response()->json(['message' => 'All words reset successfully.']);
    }

    public function managePage()
    {
        $isTokenValid = request('tkn') === 'gbwhbajwynxaoybndghamcxbghnbsawildjijnsiuhaidoiawdjiawdnawidnaklwdawd';
        
        
        abort_if(!$isTokenValid, 404); // tkn=9856
   

        return view('unknown-words');

    }
}
