@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Edit Event</h2>
        <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-gray-800">← Back to Events</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-4">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium mb-1">Title *</label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                           required>
                    @error('title') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="4" 
                              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $event->description) }}</textarea>
                    @error('description') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Category & Status -->
                <div class="grid grid-cols-2 gap-4">
                   <div>
    <label class="block text-sm font-medium mb-1">Category</label>
    <select name="category_id" class="w-full border rounded px-3 py-2">
        <option value="">Select Category</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('category_id', $event->category_id) == $cat->id ? 'selected' : '' }}>
                {{ $cat->icon ?? '📁' }} {{ $cat->name }}
            </option>
        @endforeach
    </select>
    @error('category_id') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
</div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Status *</label>
                        <select name="status" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status') border-red-500 @enderror" 
                                required>
                            <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="ongoing" {{ old('status', $event->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="done" {{ old('status', $event->status) == 'done' ? 'selected' : '' }}>Done</option>
                            <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>

                <!-- Event Date & Time -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Event Date *</label>
                        <input type="date" name="event_date" value="{{ old('event_date', $event->event_date->format('Y-m-d')) }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('event_date') border-red-500 @enderror"
                               required>
                        @error('event_date') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Event Time</label>
                        <input type="time" name="event_time" value="{{ old('event_time', $event->event_time ? date('H:i', strtotime($event->event_time)) : '') }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('event_time') border-red-500 @enderror">
                        @error('event_time') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>

                <!-- Venue -->
                <div>
                    <label class="block text-sm font-medium mb-1">Venue *</label>
                    <input type="text" name="venue" value="{{ old('venue', $event->venue) }}" 
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('venue') border-red-500 @enderror"
                           required>
                    @error('venue') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>

                <!-- Capacity & Price -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Capacity *</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $event->capacity) }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('capacity') border-red-500 @enderror"
                               min="1" required>
                        @error('capacity') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Price (IDR)</label>
                        <input type="number" name="price" value="{{ old('price', $event->price) }}" step="0.01" min="0"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                        @error('price') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>

                <!-- Organizer & Contact -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Organizer</label>
                        <input type="text" name="organizer" value="{{ old('organizer', $event->organizer) }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('organizer') border-red-500 @enderror">
                        @error('organizer') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Contact</label>
                        <input type="text" name="contact" value="{{ old('contact', $event->contact) }}" 
                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('contact') border-red-500 @enderror">
                        @error('contact') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>
                </div>

                <!-- Poster -->
                <div>
                    <label class="block text-sm font-medium mb-1">Poster</label>
                    
                    @if($event->poster)
                        <div class="mb-2">
                            <p class="text-sm text-gray-600">Current poster:</p>
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}" 
                                 class="mt-1 h-32 w-auto object-cover rounded border">
                        </div>
                    @endif
                    
                    <input type="file" name="poster" accept="image/*"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('poster') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Max 2MB. JPG, PNG, or JPEG. Leave empty to keep current poster.</p>
                    @error('poster') 
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-6 flex gap-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Update Event
                </button>
                <a href="{{ route('admin.events.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection