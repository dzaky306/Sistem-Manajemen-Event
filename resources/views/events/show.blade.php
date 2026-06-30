@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $event->title }}</h1>
        <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-gray-800">← Back to Events</a>
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
                        No Poster
                    </div>
                @endif
            </div>

            <!-- Detail Event -->
            <div class="md:col-span-2 space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-sm text-gray-500">Category</p>
                        <p class="font-medium">{{ $event->category ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="px-2 py-1 text-xs rounded 
                            @if($event->status == 'published') bg-green-100 text-green-800
                            @elseif($event->status == 'draft') bg-gray-100 text-gray-800
                            @elseif($event->status == 'ongoing') bg-blue-100 text-blue-800
                            @elseif($event->status == 'done') bg-purple-100 text-purple-800
                            @else bg-red-100 text-red-800 @endif">
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
                                <span class="text-green-600">FREE</span>
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

                <div class="pt-4 border-t flex gap-3">
                    <a href="{{ route('admin.events.edit', $event) }}" 
                       class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-black rounded">
                        ✏️ Edit Event
                    </a>
                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this event?')" 
                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-black rounded">
                            🗑️ Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Registrasi -->
    <div class="mt-6">
        <h3 class="text-lg font-semibold mb-4">Registrations ({{ $event->registrations_count }})</h3>
        
        @if($registrations->isEmpty())
            <div class="bg-gray-50 rounded-lg p-6 text-center text-gray-500">
                No registrations yet.
            </div>
        @else
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ticket Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Attended</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($registrations as $reg)
                        <tr>
                            <td class="px-6 py-4">{{ $reg->participant_name }}</td>
                            <td class="px-6 py-4">{{ $reg->email }}</td>
                            <td class="px-6 py-4 font-mono text-sm">{{ $reg->ticket_code }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded
                                    @if($reg->payment_status == 'paid') bg-green-100 text-green-800
                                    @elseif($reg->payment_status == 'free') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($reg->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($reg->attended)
                                    <span class="text-green-600">✅ Yes</span>
                                @else
                                    <span class="text-gray-400">❌ No</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t">
                    {{ $registrations->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection