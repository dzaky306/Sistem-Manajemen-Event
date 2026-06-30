@extends('layouts.app')

@section('title', 'All Events')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">🎫 Upcoming Events</h1>
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
                        <h3 class="text-lg font-bold">{{ $event->title }}</h3>
                        
                        @if($event->category)
                            <span class="text-sm text-blue-600">#{{ $event->category }}</span>
                        @endif

                        <div class="mt-2 space-y-1 text-sm text-gray-600">
                            <p>📅 {{ $event->event_date->format('d M Y') }}</p>
                            <p>📍 {{ $event->venue }}</p>
                            <p>👥 {{ $event->registrations_count }} / {{ $event->capacity }} registered</p>
                            <p>💰 @if($event->price > 0) Rp {{ number_format($event->price, 0, ',', '.') }} @else <span class="text-green-600 font-bold">FREE</span> @endif</p>
                        </div>

                        <!-- ===================================== -->
                        <!-- TOMBOL REGISTER - INI YANG PENTING! -->
                        <!-- ===================================== -->
                        <div class="mt-4">
                            @if($event->isFull())
                                <button disabled class="w-full px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed">
                                    ❌ Fully Booked
                                </button>
                            @elseif($event->status != 'published')
                                <button disabled class="w-full px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed">
                                    ⏳ Not Available
                                </button>
                            @else
                                <a href="{{ route('registrations.create', $event) }}" 
                                   class="block w-full text-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-black font-bold rounded-lg shadow transition">
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