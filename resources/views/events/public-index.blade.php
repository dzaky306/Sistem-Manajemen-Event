@extends('layouts.app')

@section('title', 'All Events')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">🎫 All Events</h1>
    </div>

    @if($events->isEmpty())
        <div class="bg-white rounded-lg shadow p-12 text-center text-gray-500">
            <p class="text-lg">No events available at the moment.</p>
            <p class="text-sm">Check back later for upcoming events!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                    <!-- Poster -->
                    @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white text-xl font-bold">
                            {{ $event->title }}
                        </div>
                    @endif

                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-bold">{{ $event->title }}</h3>
                            <div class="flex flex-col items-end gap-1">
                                <!-- Status Event -->
                                <span class="px-2 py-1 text-xs rounded 
                                    @if($event->status == 'published') bg-green-100 text-green-800
                                    @elseif($event->status == 'ongoing') bg-blue-100 text-blue-800
                                    @elseif($event->status == 'done') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($event->status) }}
                                </span>
                                
                                <!-- Label Event Lewat -->
                                @if($event->event_date->isPast())
                                    <span class="px-2 py-1 text-xs rounded bg-red-200 text-red-800 font-bold">
                                        ⛔ Telah Lewat
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($event->category)
                            <span class="text-sm text-blue-600">{{ $event->category->icon ?? '📁' }} {{ $event->category->name }}</span>
                        @endif

                        <div class="mt-2 space-y-1 text-sm text-gray-600">
                            <p>📅 {{ $event->event_date->format('d M Y') }}</p>
                            <p>📍 {{ $event->venue }}</p>
                            <p>👥 {{ $event->registrations_count }} / {{ $event->capacity }}</p>
                            <p>💰 @if($event->price > 0) Rp {{ number_format($event->price, 0, ',', '.') }} @else <span class="text-green-600 font-bold">FREE</span> @endif</p>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-4 space-y-2">
                            <a href="{{ route('events.public.show', $event) }}" 
                               class="block w-full text-center px-4 py-2 bg-gray-400 hover:bg-gray-500 text-black font-bold rounded-lg shadow transition">
                                👁️ View Detail
                            </a>

                            @if($event->event_date->isPast())
                                <button disabled class="w-full px-4 py-2 bg-red-300 text-black rounded cursor-not-allowed">
                                    ⛔ Event Telah Lewat
                                </button>
                            @elseif($event->isFull())
                                <button disabled class="w-full px-4 py-2 bg-gray-300 text-black rounded cursor-not-allowed">
                                    ❌ Fully Booked
                                </button>
                            @elseif($event->status != 'published')
                                <button disabled class="w-full px-4 py-2 bg-gray-300 text-black rounded cursor-not-allowed">
                                    ⏳ Not Available
                                </button>
                            @else
                                <a href="{{ route('registrations.create', $event) }}" 
                                   class="block w-full text-center px-4 py-2 bg-blue-400 hover:bg-blue-500 text-black font-bold rounded-lg shadow transition">
                                    ✅ Register Now
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection