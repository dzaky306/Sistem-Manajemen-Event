<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    protected function authorizeAdmin()
    {
        abort_unless(auth()->user()?->is_admin, 403, 'Only admin can access this.');
    }

    // ============ ADMIN ROUTES ============

    public function index()
    {
        $this->authorizeAdmin();
        $events = Event::withCount('registrations')->latest()->paginate(10);
        return view('events.index', compact('events'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('events.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => 'required|max:200',
            'description' => 'nullable',
            'category' => 'nullable|max:50',
            'event_date' => 'required|date',
            'event_time' => 'nullable',
            'venue' => 'required|max:200',
            'capacity' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'organizer' => 'nullable|max:100',
            'contact' => 'nullable|max:100',
            'poster' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,ongoing,done,cancelled'
        ]);

        // Upload poster
        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public');
            $validated['poster'] = $path;
        }

        // Simpan event
        $event = Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully!');
    }

    public function show(Event $event)
    {
        $event->loadCount('registrations');
        $registrations = $event->registrations()->latest()->paginate(10);
        return view('events.show', compact('event', 'registrations'));
    }

    public function edit(Event $event)
    {
        $this->authorizeAdmin();
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'title' => 'required|max:200',
            'description' => 'nullable',
            'category' => 'nullable|max:50',
            'event_date' => 'required|date',
            'event_time' => 'nullable',
            'venue' => 'required|max:200',
            'capacity' => 'required|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'organizer' => 'nullable|max:100',
            'contact' => 'nullable|max:100',
            'poster' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,ongoing,done,cancelled'
        ]);

        // Upload poster baru kalo ada
        if ($request->hasFile('poster')) {
            // Hapus poster lama
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $path = $request->file('poster')->store('posters', 'public');
            $validated['poster'] = $path;
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        $this->authorizeAdmin();

        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully!');
    }

    // ============ PUBLIC ROUTES ============

    public function publicIndex()
    {
        $events = Event::withCount('registrations')
            ->where('status', 'published')
            ->latest('event_date')
            ->paginate(12);

        return view('events.public-index', compact('events'));
    }

    public function publicShow(Event $event)
    {
        if ($event->status !== 'published' && !auth()->user()?->is_admin) {
            abort(404);
        }

        $event->loadCount('registrations');
        return view('events.public-show', compact('event'));
    }
}