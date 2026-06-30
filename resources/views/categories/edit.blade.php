@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">✏️ Edit Category</h1>
        <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-800">← Back</a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" 
                           class="w-full border rounded px-3 py-2" required>
                    @error('name') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Icon (Emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" 
                           placeholder="🎓" class="w-full border rounded px-3 py-2">
                    @error('icon') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="3" 
                              class="w-full border rounded px-3 py-2">{{ old('description', $category->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="is_active" class="w-full border rounded px-3 py-2">
                        <option value="1" {{ $category->is_active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$category->is_active ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-black rounded">
                    🔄 Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 rounded">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection