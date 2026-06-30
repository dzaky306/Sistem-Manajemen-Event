@extends('layouts.app')

@section('title', 'Registrations')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">📋 Event Registrations</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg overflow-hidden">
        @if($registrations->isEmpty())
            <div class="p-12 text-center text-gray-500">
                <p class="text-lg">No registrations yet.</p>
                <p class="text-sm">Wait for participants to register!</p>
            </div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Participant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ticket Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Attended</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($registrations as $reg)
                    <tr>
                        <td class="px-6 py-4">{{ $reg->event->title }}</td>
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
                        <td class="px-6 py-4 space-x-2">
                            @if(!$reg->attended)
                                <form action="{{ route('admin.registrations.attendance', $reg) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-blue-600 hover:text-blue-800">
                                        Mark Attendance
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.registrations.destroy', $reg) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this registration?')" 
                                        class="text-red-600 hover:text-red-800">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
</div>
@endsection