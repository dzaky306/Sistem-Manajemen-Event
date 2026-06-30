@extends('layouts.app')

@section('title', 'Register for ' . $event->title)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Register for {{ $event->title }}</h1>
            <a href="{{ route('events.public.show', $event) }}" class="text-gray-600 hover:text-gray-800">← Back</a>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <div class="mb-4 p-4 bg-blue-50 rounded">
                <p class="text-sm text-gray-600">
                    📅 {{ $event->event_date->format('d M Y') }}
                    @if($event->event_time) • {{ date('H:i', strtotime($event->event_time)) }} @endif
                </p>
                <p class="text-sm text-gray-600">📍 {{ $event->venue }}</p>
                <p class="text-sm text-gray-600">
                    💰 @if($event->price > 0) Rp {{ number_format($event->price, 0, ',', '.') }} @else <span class="text-green-600 font-medium">FREE</span> @endif
                </p>
                <p class="text-sm text-gray-600">👥 Available: {{ $event->available_slots }} slots</p>
            </div>

            <form action="{{ route('registrations.store', $event) }}" method="POST">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Full Name *</label>
                        <input type="text" name="participant_name" value="{{ old('participant_name') }}" 
                               class="w-full border rounded px-3 py-2" required>
                        @error('participant_name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               class="w-full border rounded px-3 py-2" required>
                        @error('email') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" 
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Institution</label>
                        <input type="text" name="institution" value="{{ old('institution') }}" 
                               class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-black rounded">
                        ✅ Register Now
                    </button>
                    <a href="{{ route('events.public.show', $event) }}" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 rounded">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection