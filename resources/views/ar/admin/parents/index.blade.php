@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">أولياء الأمور</h2>
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        العودة إلى لوحة التحكم
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">الكود</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">رقم الهاتف</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">كلمة المرور (نص صريح)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">الأبناء</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($parents as $parent)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $parent->code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $parent->phone_number }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $parent->plain_password }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        @php
                                            $sons = is_array($parent->sons) ? $parent->sons : [];
                                        @endphp
                                        @if(empty($sons))
                                            <span class="text-gray-500">لا يوجد أبناء</span>
                                        @else
                                            <div class="space-y-1">
                                                @foreach($sons as $code)
                                                    <div>
                                                        <span class="font-semibold">{{ $code }}</span>
                                                        @if(isset($studentNamesByCode[$code]))
                                                            <span class="text-gray-600">- {{ $studentNamesByCode[$code]->name }}</span>
                                                            @if(!empty($studentNamesByCode[$code]->academicYear))
                                                                <span class="text-gray-500">({{ $studentNamesByCode[$code]->academicYear }})</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
