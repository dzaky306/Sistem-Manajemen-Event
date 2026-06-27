<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    protected function authorizeAdmin()
    {
        abort_unless(auth()->user()?->is_admin, 403, 'Only admin can access this.');
    }

    public function index()
    {
        $this->authorizeAdmin();
        $registrations = EventRegistration::with('event')
            ->latest()
            ->paginate(15);
        
        return view('registrations.index', compact('registrations'));
    }

    public function create(Event $event)
    {
        // Cek kuota
        if ($event->isFull()) {
            return back()->with('error', 'Sorry, this event is fully booked.');
        }

        return view('registrations.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        // Cek kuota
        if ($event->isFull()) {
            return back()->with('error', 'Sorry, this event is fully booked.');
        }

        $validated = $request->validate([
            'participant_name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|max:20',
            'institution' => 'nullable|max:100',
        ]);

        // Determine payment status
        $payment_status = $event->price > 0 ? 'pending' : 'free';

        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'participant_name' => $validated['participant_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'institution' => $validated['institution'] ?? null,
            'ticket_code' => EventRegistration::generateTicketCode(),
            'payment_status' => $payment_status,
        ]);

        return redirect()->route('registrations.success', $registration)
            ->with('success', 'Registration successful!');
    }

    public function success(EventRegistration $registration)
    {
        $registration->load('event');
        return view('registrations.success', compact('registration'));
    }

    public function markAttendance(EventRegistration $registration)
    {
        $this->authorizeAdmin();
        
        $registration->update(['attended' => true]);
        
        return back()->with('success', 'Attendance marked successfully.');
    }

    public function destroy(EventRegistration $registration)
    {
        $this->authorizeAdmin();
        $registration->delete();
        
        return back()->with('success', 'Registration deleted successfully.');
    }
}