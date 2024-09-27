<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function index()
    {
        $topics = Topic::all(); // Fetch all topics
        return view('topics.index', compact('topics'));
    }

    public function create()
    {
        return view('topics.create'); // Show form to create a new topic
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255'
        ]);

        Topic::create($request->only('title')); // Store the new topic
        return redirect()->route('topics.index')->with('success', 'Topic created successfully');
    }

    public function edit(Topic $topic)
    {
        return view('topics.edit', compact('topic')); // Show form to edit an existing topic
    }

    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'title' => 'required|max:255'
        ]);

        $topic->update($request->only('title')); // Update the topic
        return redirect()->route('topics.index')->with('success', 'Topic updated successfully');
    }

    public function destroy(Topic $topic)
    {
        $topic->delete(); // Delete the topic
        return redirect()->route('topics.index')->with('success', 'Topic deleted successfully');
    }
}
