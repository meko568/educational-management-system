<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 leading-tight">
                    {{ __('messages.parent_portal') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">{{ __('messages.manage_family') }}</p>
            </div>
            <div class="bg-white px-4 py-2 rounded-xl border border-slate-100 shadow-sm flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xs uppercase">
                    ID
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase leading-none">{{ __('messages.family_code') }}</p>
                    <p class="text-sm font-bold text-slate-700 leading-none mt-1">{{ $parent->code }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Section: Sons -->
        <div>
            <div class="flex items-center gap-4 mb-6">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">{{ __('messages.linked_profiles') }}</h3>
                <div class="h-px bg-slate-100 flex-1"></div>
            </div>

            @if($sons->isEmpty())
                <div class="bg-white p-12 rounded-[2.5rem] border border-dashed border-slate-200 text-center">
                    <p class="text-slate-400 italic">{{ __('messages.no_linked_profiles') }}</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($sons as $son)
                        <a href="{{ route('parent.sons.show', $son) }}" class="group bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:border-teal-500 hover:shadow-xl transition-all duration-300">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-14 h-14 bg-slate-50 text-slate-400 group-hover:bg-teal-50 group-hover:text-teal-600 rounded-2xl flex items-center justify-center border border-slate-100 transition-colors">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ __('messages.grade') }}: {{ $son->academicYear }}</p>
                                    <h4 class="text-lg font-black text-slate-900 leading-tight group-hover:text-teal-600 transition-colors">{{ $son->name }}</h4>
                                </div>
                            </div>

                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 group-hover:bg-white transition-colors flex justify-between items-center">
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase">{{ __('messages.student_code') }}</p>
                                    <p class="text-sm font-bold text-slate-700 font-mono">{{ $son->code }}</p>
                                </div>
                                <svg class="w-5 h-5 text-slate-300 group-hover:text-teal-500 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4-4m4-4H3" /></svg>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
