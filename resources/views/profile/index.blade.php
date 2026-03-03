<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- Page Header -->
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="font-cinzel text-3xl font-bold text-amber-400 tracking-widest">
                    Your Characters
                </h1>
                <p class="mt-1 text-stone-500 text-sm tracking-wide">
                    Choose your champion or forge a new legend
                </p>
            </div>
            <a href="#"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-700 hover:bg-amber-600 text-stone-100 font-cinzel text-sm tracking-wider rounded border border-amber-500/40 shadow-lg shadow-amber-900/40 transition-colors duration-150">
                <span>✦</span> New Character
            </a>
        </div>

        @if($characters->isEmpty())
            <!-- Empty State -->
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <div class="text-6xl mb-6 opacity-30">⚔</div>
                <h2 class="font-cinzel text-xl text-amber-600/70 mb-2">No Characters Yet</h2>
                <p class="text-stone-600 text-sm max-w-xs">
                    Your story has not begun. Create your first character and enter the realm.
                </p>
                <a href="#"
                   class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-amber-700 hover:bg-amber-600 text-stone-100 font-cinzel text-sm tracking-wider rounded border border-amber-500/40 shadow-lg shadow-amber-900/40 transition-colors duration-150">
                    <span>✦</span> Create Your First Character
                </a>
            </div>
        @else
            <!-- Characters Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($characters as $character)
                    <a href="#" class="group block">
                        <div class="relative bg-stone-900 border border-amber-800/40 rounded-lg overflow-hidden
                                    shadow-lg shadow-black/50 transition-all duration-200
                                    group-hover:border-amber-600/70 group-hover:shadow-amber-900/40 group-hover:-translate-y-0.5">

                            <!-- Card top ornament -->
                            <div class="h-1 bg-gradient-to-r from-transparent via-amber-700 to-transparent opacity-60"></div>

                            <!-- Card body -->
                            <div class="p-6">
                                <!-- Class icon / badge -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="w-10 h-10 rounded-full bg-stone-800 border border-amber-700/40 flex items-center justify-center text-amber-600 text-lg shadow-inner">
                                        ⚜
                                    </div>
                                    <span class="text-stone-600 text-xs font-cinzel tracking-widest uppercase">
                                        {{ $character->alignment?->name ?? '—' }}
                                    </span>
                                </div>

                                <!-- Character Name -->
                                <h3 class="font-cinzel text-lg font-semibold text-amber-300 group-hover:text-amber-200 leading-snug mb-1 transition-colors duration-150">
                                    {{ $character->name }}
                                </h3>

                                <!-- Class Name -->
                                <p class="text-stone-500 text-sm tracking-wide">
                                    {{ $character->characterClass?->name ?? 'Unknown Class' }}
                                </p>
                            </div>

                            <!-- Card bottom ornament -->
                            <div class="h-px bg-gradient-to-r from-transparent via-amber-800/40 to-transparent mx-4 mb-3"></div>

                            <!-- Footer -->
                            <div class="px-6 pb-4 flex items-center justify-between">
                                <span class="text-xs text-stone-600 tracking-wider">
                                    {{ $character->background ?? 'No background' }}
                                </span>
                                <span class="text-amber-700 text-xs group-hover:text-amber-500 transition-colors duration-150">→</span>
                            </div>
                        </div>
                    </a>
                @endforeach

                <!-- Create New Character Card -->
                <a href="#" class="group block">
                    <div class="relative bg-stone-900/50 border border-dashed border-stone-700 rounded-lg overflow-hidden
                                shadow-lg shadow-black/30 transition-all duration-200 h-full min-h-[180px]
                                group-hover:border-amber-700/50 group-hover:bg-stone-900 flex flex-col items-center justify-center">
                        <div class="text-3xl text-stone-700 group-hover:text-amber-700 transition-colors duration-200 mb-2">+</div>
                        <span class="font-cinzel text-xs tracking-widest text-stone-600 group-hover:text-amber-600 transition-colors duration-200 uppercase">
                            New Character
                        </span>
                    </div>
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
