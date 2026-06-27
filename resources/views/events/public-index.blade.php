@extends('layouts.app')

@section('title', 'All Events')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Upcoming Events</h2>
        
        @auth
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.events.create') }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Create Event
                </a>
            @endif
        @endauth
    </div>
    
    @if($events->isEmpty())
        <div class="bg-white rounded-lg shadow p-12 text-center text-gray-500">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <p class="mt-4 text-lg">No events available at the moment.</p>
            <p class="text-sm">Check back later for upcoming events!</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- Poster -->
                    @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                            <span class="text-white text-xl font-bold">{{ $event->title }}</span>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $event->title }}</h3>
                            <span class="px-2 py-1 text-xs rounded 
                                @if($event->status == 'published') bg-green-100 text-green-800
                                @elseif($event->status == 'draft') bg-gray-100 text-gray-800
                                @elseif($event->status == 'ongoing') bg-blue-100 text-blue-800
                                @elseif($event->status == 'done') bg-purple-100 text-purple-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>
                        
                        @if($event->category)
                            <p class="text-sm text-blue-600 mt-1">#{{ $event->category }}</p>
                        @endif
                        
                        <div class="mt-3 space-y-2 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $event->event_date->format('d M Y') }} @if($event->event_time) • {{ date('H:i', strtotime($event->event_time)) }} @endif
                            </div>
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $event->venue }}
                            </div>
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $event->registrations_count }} / {{ $event->capacity }} registered
                            </div>
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @if($event->price > 0)
                                    Rp {{ number_format($event->price, 0, ',', '.') }}
                                @else
                                    <span class="text-green-600 font-medium">FREE</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            @if($event->isFull())
                                <button disabled class="w-full px-4 py-2 bg-gray-300 text-gray-500 rounded cursor-not-allowed">
                                    Fully Booked
                                </button>
                            @elseif($event->status != 'published')
                                <button disabled class="w-full px-4 py-2 bg-gray-300 text-gray-500 rounded cursor-not-allowed">
                                    Not Available
                                </button>
                            @else
                                <a href="{{ route('registrations.create', $event) }}" 
                                   class="block w-full text-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                    Register Now
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