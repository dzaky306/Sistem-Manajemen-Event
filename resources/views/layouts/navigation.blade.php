<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex space-x-8">
                <a href="{{ route('events.public') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900">
                    🎫 Events
                </a>
                
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.events.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900">
                            📋 Manage Events
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900">
                            📋 Categories
                        </a>
                        <a href="{{ route('admin.registrations.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900">
                            👥 Registrations
                        </a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-900">
                        📊 Dashboard
                    </a>

                @endauth
            </div>

            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-sm text-gray-700">{{ auth()->user()->name }}</span>
                    @if(auth()->user()->is_admin)
                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">Admin</span>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700">Login</a>
                    <a href="{{ route('register') }}" class="text-sm text-gray-500 hover:text-gray-700">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>