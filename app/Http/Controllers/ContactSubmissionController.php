<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:30',
            'message' => 'required|string|max:5000',
        ]);

        $submission = ContactSubmission::create([
            ...$validated,
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'data' => $submission->fresh(),
        ], 201);
    }
}
