@extends('layouts.app')

@section('title', 'Registration Success')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow rounded-lg p-8 text-center">
            <div class="text-green-500 text-6xl mb-4">✅</div>
            <h1 class="text-2xl font-bold mb-2">Registration Successful!</h1>
            <p class="text-gray-600 mb-6">Thank you for registering for <strong>{{ $registration->event->title }}</strong></p>

            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <p class="text-sm text-gray-500">Your Ticket Code</p>
                <p class="text-2xl font-mono font-bold text-blue-600">{{ $registration->ticket_code }}</p>
                <p class="text-xs text-gray-400 mt-1">Save this code for check-in</p>
            </div>

            <div class="text-left space-y-2 text-sm">
                <p><span class="font-medium">Name:</span> {{ $registration->participant_name }}</p>
                <p><span class="font-medium">Email:</span> {{ $registration->email }}</p>
                @if($registration->phone)
                    <p><span class="font-medium">Phone:</span> {{ $registration->phone }}</p>
                @endif
                @if($registration->institution)
                    <p><span class="font-medium">Institution:</span> {{ $registration->institution }}</p>
                @endif
                <p><span class="font-medium">Payment Status:</span> 
                    <span class="px-2 py-1 text-xs rounded
                        @if($registration->payment_status == 'paid') bg-green-100 text-green-800
                        @elseif($registration->payment_status == 'free') bg-blue-100 text-blue-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($registration->payment_status) }}
                    </span>
                </p>
            </div>

            <div class="mt-6">
                <a href="{{ route('events.public') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    ← Back to Events
                </a>
            </div>
        </div>
    </div>
</div>
@endsection