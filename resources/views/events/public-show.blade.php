@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $event->title }}</h1>
        <a href="{{ route('events.public') }}" class="text-gray-600 hover:text-gray-800">← Back to Events</a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="grid md:grid-cols-3 gap-6 p-6">
            <!-- Poster -->
            <div class="md:col-span-1">
                @if($event->poster)
                    <img src="{{ asset('storage/' . $event->poster) }}" 
                         alt="{{ $event->title }}" 
                         class="w-full rounded-lg shadow">
                @else
                    <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-purple-500 rounded-lg flex items-center justify-center text-white font-bold">
                        {{ $event->title }}
                    </div>
                @endif
            </div>

            <!-- Detail Event -->
            <div class="md:col-span-2 space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-sm text-gray-500">Category</p>
                        <p class="font-medium">
                            @if($event->category)
                                {{ $event->category->icon ?? '📁' }} {{ $event->category->name }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="px-2 py-1 text-xs rounded 
                            @if($event->status == 'published') bg-green-100 text-green-800
                            @elseif($event->status == 'ongoing') bg-blue-100 text-blue-800
                            @elseif($event->status == 'done') bg-purple-100 text-purple-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($event->status) }}
                        </span>
                    </div>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Description</p>
                    <p class="font-medium">{{ $event->description ?? '-' }}</p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-sm text-gray-500">Date & Time</p>
                        <p class="font-medium">{{ $event->event_date->format('d M Y') }}</p>
                        @if($event->event_time)
                            <p class="text-sm">{{ date('H:i', strtotime($event->event_time)) }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Venue</p>
                        <p class="font-medium">{{ $event->venue }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-sm text-gray-500">Capacity</p>
                        <p class="font-medium">{{ $event->registrations_count }} / {{ $event->capacity }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Price</p>
                        <p class="font-medium">
                            @if($event->price > 0)
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            @else
                                <span class="text-green-600 font-bold">FREE</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-sm text-gray-500">Organizer</p>
                        <p class="font-medium">{{ $event->organizer ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contact</p>
                        <p class="font-medium">{{ $event->contact ?? '-' }}</p>
                    </div>
                </div>

                <!-- Tombol Register -->
                <div class="pt-4 border-t">
                    @if($event->event_date->isPast())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-3">
                            ⛔ This event has already passed. Registration is closed.
                        </div>
                        <button disabled class="px-6 py-2 bg-red-300 text-black rounded cursor-not-allowed">
                            ⛔ Event Telah Lewat
                        </button>
                    @elseif($event->isFull())
                        <button disabled class="px-6 py-2 bg-gray-300 text-black rounded cursor-not-allowed">
                            ❌ Fully Booked
                        </button>
                    @elseif($event->status != 'published')
                        <button disabled class="px-6 py-2 bg-gray-300 text-black rounded cursor-not-allowed">
                            ⏳ Not Available
                        </button>
                    @else
                        <a href="{{ route('registrations.create', $event) }}" 
                           class="px-6 py-2 bg-blue-400 hover:bg-blue-500 text-black rounded">
                            ✅ Register Now
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection