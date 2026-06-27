@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <h2 class="text-2xl font-bold">Dashboard</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm text-gray-500">Total Events</div>
            <div class="text-3xl font-bold">{{ $totalEvents }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm text-gray-500">Total Registrations</div>
            <div class="text-3xl font-bold">{{ $totalRegistrations }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm text-gray-500">Upcoming Events</div>
            <div class="text-3xl font-bold">{{ $upcomingEvents }}</div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-sm text-gray-500">Total Revenue</div>
            <div class="text-3xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4">Recent Registrations</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Event</th>
                        <th class="py-2">Participant</th>
                        <th class="py-2">Email</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Attended</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentRegistrations as $reg)
                    <tr class="border-b">
                        <td class="py-2">{{ $reg->event->title }}</td>
                        <td class="py-2">{{ $reg->participant_name }}</td>
                        <td class="py-2">{{ $reg->email }}</td>
                        <td class="py-2">
                            <span class="px-2 py-1 text-xs rounded 
                                @if($reg->payment_status == 'paid') bg-green-100 text-green-800
                                @elseif($reg->payment_status == 'free') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $reg->payment_status }}
                            </span>
                        </td>
                        <td class="py-2">
                            @if($reg->attended)
                                <span class="text-green-600">✓</span>
                            @else
                                <span class="text-gray-400">✗</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection