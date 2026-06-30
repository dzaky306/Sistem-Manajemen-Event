@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">➕ Add Category</h1>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-800">← Back</a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full border rounded px-3 py-2" required>
                    @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Icon (Emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon') }}" 
                           placeholder="🎓" class="w-full border rounded px-3 py-2">
                    @error('icon') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="3" 
                              class="w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    💾 Save Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 rounded">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection