<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 leading-tight">
                    {{ __('Parent Accounts') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Monitor parent login credentials and linked student profiles</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-widest">Access Code</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-widest">Phone Contact</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase tracking-widest">Credentials</th>
                        <th class="px-6 py-4 text-xs font-black text-slate-500 uppercase">Linked Students</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($parents as $parent)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 border border-slate-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    </div>
                                    <span class="text-sm font-black text-slate-900 font-mono tracking-tight">{{ $parent->code }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-sm font-bold text-slate-600">
                                {{ $parent->phone_number }}
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded text-[10px] font-black uppercase tracking-tighter">PASS:</span>
                                    <span class="text-xs font-bold text-slate-700 font-mono">{{ $parent->plain_password }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @php
                                    $sons = is_array($parent->sons) ? $parent->sons : [];
                                @endphp
                                @if(empty($sons))
                                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">No Linked Sons</span>
                                @else
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($sons as $code)
                                            <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 border border-indigo-100 rounded-lg">
                                                <span class="text-[10px] font-black text-indigo-400 font-mono">{{ $code }}</span>
                                                @if(isset($studentNamesByCode[$code]))
                                                    <span class="text-xs font-bold text-indigo-700">{{ $studentNamesByCode[$code]->name }}</span>
                                                    <span class="text-[9px] font-medium text-indigo-300 uppercase italic">({{ $studentNamesByCode[$code]->academicYear }})</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-slate-400 italic">No parent accounts registered in the system.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
