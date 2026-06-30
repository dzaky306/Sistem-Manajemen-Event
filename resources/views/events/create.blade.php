@extends('layouts.app')

@section('title', 'Create Event')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">✨ Create New Event</h1>
        <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-gray-800">← Back</a>
    </div>

    <div class="bg-white shadow-md rounded p-6">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Title -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" 
                       class="w-full border rounded px-3 py-2" required>
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" rows="4" 
                          class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
    <label class="block text-sm font-medium mb-1">Category</label>
    <select name="category_id" class="w-full border rounded px-3 py-2">
        <option value="">Select Category</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                {{ $cat->icon ?? '📁' }} {{ $cat->name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
</div>
                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="status" class="w-full border rounded px-3 py-2">
                        <option value="draft">Draft</option>
                        <option value="published" selected>Published</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="done">Done</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Event Date *</label>
                    <input type="date" name="event_date" value="{{ old('event_date') }}" 
                           class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Event Time</label>
                    <input type="time" name="event_time" value="{{ old('event_time') }}" 
                           class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium mb-1">Venue *</label>
                <input type="text" name="venue" value="{{ old('venue') }}" 
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Capacity *</label>
                    <input type="number" name="capacity" value="{{ old('capacity') }}" 
                           class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Price (IDR)</label>
                    <input type="number" name="price" value="{{ old('price', 0) }}" step="0.01" min="0"
                           class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Organizer</label>
                    <input type="text" name="organizer" value="{{ old('organizer') }}" 
                           class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Contact</label>
                    <input type="text" name="contact" value="{{ old('contact') }}" 
                           class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium mb-1">Poster</label>
                <input type="file" name="poster" accept="image/*"
                       class="w-full border rounded px-3 py-2">
                <p class="text-xs text-gray-500 mt-1">Max 2MB</p>
            </div>

            <!-- ========================================== -->
            <!-- INI DIA TOMBOLNYA! WARNA HIJAU BIAR KELIATAN -->
            <!-- ========================================== -->
            <div class="mt-6 flex gap-3 border-t pt-6">
                <button type="submit" 
                        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-black font-bold rounded-lg shadow-lg transition-all duration-200">
                    💾 Save Event
                </button>
                <a href="{{ route('admin.events.index') }}" 
                   class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-lg">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>
@endsection