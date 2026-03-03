<nav x-data="{ open: false }" class="bg-stone-900 border-b border-amber-800/50 shadow-lg shadow-black/40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo / Brand -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('profile') }}" class="flex items-center gap-2">
                        <span class="text-amber-500 text-xl">⚔</span>
                        <span class="font-cinzel font-bold text-amber-400 text-lg tracking-widest hidden sm:block">DnD Minecraft</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:ms-10 space-x-1">
                    <a href="{{ route('profile') }}"
                       class="flex items-center gap-1.5 px-4 py-2 rounded text-sm font-cinzel tracking-wider transition-colors duration-150
                              {{ request()->routeIs('profile') ? 'text-amber-400 bg-amber-900/30 border border-amber-700/40' : 'text-stone-400 hover:text-amber-400 hover:bg-stone-800' }}">
                        <span class="text-xs">⚜</span> My Characters
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48" contentClasses="py-1 bg-stone-800 border border-amber-800/40">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 border border-amber-800/40 rounded text-sm font-cinzel text-amber-400/80 bg-stone-800 hover:text-amber-300 hover:border-amber-600/60 focus:outline-none transition ease-in-out duration-150">
                            <span class="text-xs text-amber-600">◈</span>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="fill-current h-4 w-4 text-amber-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.settings')">
                            {{ __('Account Settings') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-stone-400 hover:text-amber-400 hover:bg-stone-800 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-amber-800/30">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <a href="{{ route('profile') }}"
               class="block px-4 py-2 rounded font-cinzel text-sm tracking-wider
                      {{ request()->routeIs('profile') ? 'text-amber-400 bg-amber-900/30' : 'text-stone-400 hover:text-amber-400 hover:bg-stone-800' }}">
                ⚜ My Characters
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-amber-800/30">
            <div class="px-4 mb-3">
                <div class="font-cinzel text-sm text-amber-400">{{ Auth::user()->name }}</div>
                <div class="text-xs text-stone-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-2 space-y-1 px-2">
                <a href="{{ route('profile.settings') }}"
                   class="block px-4 py-2 rounded text-sm text-stone-400 hover:text-amber-400 hover:bg-stone-800">
                    Account Settings
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 rounded text-sm text-stone-400 hover:text-amber-400 hover:bg-stone-800">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
