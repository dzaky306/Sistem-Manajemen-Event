@extends('layouts.app')

@section('title', 'Manage Events')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold">Manage Events</h2>
        <a href="{{ route('admin.events.create') }}" 
   class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-bold shadow">
    + Create Event
</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left">
                        <th class="px-6 py-3">Title</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Price</th>
                        <th class="px-6 py-3">Registrations</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($events as $event)
                    <tr>
                        <td class="px-6 py-4">{{ $event->title }}</td>
                        <td class="px-6 py-4">{{ $event->category ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $event->event_date->format('d M Y') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($event->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            {{ $event->registrations_count }} / {{ $event->capacity }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded 
                                @if($event->status == 'published') bg-green-100 text-green-800
                                @elseif($event->status == 'draft') bg-gray-100 text-gray-800
                                @elseif($event->status == 'ongoing') bg-blue-100 text-blue-800
                                @elseif($event->status == 'done') bg-purple-100 text-purple-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $event->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('admin.events.show', $event) }}" 
                               class="text-blue-600 hover:text-blue-800">View</a>
                            <a href="{{ route('admin.events.edit', $event) }}" 
                               class="text-yellow-600 hover:text-yellow-800">Edit</a>
                            <form action="{{ route('admin.events.destroy', $event) }}" 
                                  method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this event?')" 
                                        class="text-red-600 hover:text-red-800">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No events found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection