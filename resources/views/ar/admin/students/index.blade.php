@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">إدارة الطلاب</h2>
                    <a href="{{ route('admin.students.create', ['academicYear' => isset($academicYear) ? $academicYear : 'primary1']) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        إضافة طالب جديد
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">تم بنجاح</p>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">الاسم</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">كود الطالب</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">كلمة المرور</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">الصف الدراسي</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($students as $student)
                @if($student->role != 'admin')
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $student->name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $student->code }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            <span class="font-mono bg-gray-100 px-2 py-1 rounded">{{ $student->plain_password ?? 'غير متوفر' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ ucfirst(str_replace('_', ' ', $student->academicYear)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex gap-4 items-center space-x-2">
                            <!-- Show Button -->
                            <a href="{{ route('admin.students.show', $student->code) }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                عرض
                            </a>

                            <!-- Edit Button -->
                            <a href="{{ route('admin.students.edit', $student->code) }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                تعديل
                            </a>
                            
                            <!-- Payment Button -->
                            <a href="{{ route('admin.students.payment', $student) }}" 
                               class="inline-flex items-center px-4 py-2 mx-4 border border-transparent text-sm font-medium rounded-md shadow-sm {{ $student->paid_at && now()->diffInDays($student->paid_at) <= 30 ? 'bg-green-100 hover:bg-green-200 text-green-900 focus:ring-green-500' : 'bg-yellow-100 hover:bg-yellow-200 text-yellow-900 focus:ring-yellow-500' }} focus:outline-none focus:ring-2 focus:ring-offset-2 bg-green-100">
                                <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 3v2m3-2v2m3-2v2m3-2v2m3 13h1a2 2 0 002-2V9.5a2 2 0 00-2-2H5.5a2 2 0 00-2 2v10a2 2 0 002 2h1m6-13h2m-6 5h8m-8 3h8m-8 3h6" />
                                </svg>
                                <span class="text-black">الدفع</span>
                            </a>
                            
                            <!-- Delete Button with Modal -->
                            <div x-data="{ showModal: false }">
                                <!-- Delete Button -->
                                <button type="button" 
                                        @click="showModal = true"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    حذف
                                </button>

                                <!-- Modal -->
                                <div x-show="showModal" 
                                     class="fixed inset-0 z-50 overflow-y-auto" 
                                     aria-labelledby="modal-title" 
                                     role="dialog" 
                                     aria-modal="true"
                                     style="display: none;"
                                     x-transition:opacity="300ms ease-out"
                                     x-show.transition.opacity.duration.300ms="showModal"
                                     x-cloak>
                                    <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                                        <!-- Background overlay -->
                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                                             aria-hidden="true"
                                             x-show="showModal"
                                             x-transition:opacity.duration.300
                                             @click="showModal = false"></div>

                                        <!-- Modal panel -->
                                        <div class="relative w-full max-w-xl mx-auto my-8 bg-white rounded-lg shadow-xl transform transition-all"
                                             x-show="showModal"
                                             x-transition:opacity.duration.300
                                             @click.away="showModal = false"
                                             style="min-width: 300px;">
                                            <div class="p-6">
                                                <div class="flex flex-col sm:flex-row">
                                                    <div class="flex-shrink-0 mx-auto sm:mx-0 sm:mr-4 mb-4 sm:mb-0">
                                                        <div class="h-12 w-12 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="text-center sm:text-left">
                                                        <h3 class="text-lg font-medium text-gray-900 mb-2" id="modal-title">
                                                            حذف الطالب
                                                        </h3>
                                                        <p class="text-sm text-gray-600">هل أنت متأكد أنك تريد حذف هذا الطالب؟</p>
                                                    </div>
                                                </div>
                                                <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                                                    <button type="button"
                                                            @click="showModal = false"
                                                            class="w-full sm:w-auto justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                        إلغاء
                                                    </button>
                                                    <form action="{{ route('admin.students.destroy', $student->code) }}" method="POST" class="w-full sm:w-auto">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="w-full justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                            حذف
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endif
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                        لا توجد بيانات للطلاب.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($students->hasPages())
    <div class="mt-4">
        {{ $students->links() }}
    </div>
@endif

                @if($students->hasPages())
                    <div class="mt-4">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
@endsection