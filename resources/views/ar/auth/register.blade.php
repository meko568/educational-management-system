<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    إنشاء حساب جديد
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    يرجى ملء التفاصيل لإنشاء حسابك
                </p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">الاسم الكامل</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            autocomplete="name"
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="أدخل اسمك الكامل"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">الصف الدراسي</label>
                        <select
                            name="academic_year"
                            required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 bg-white text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        >
                            <option value="">-- اختر الصف الدراسي --</option>
                            <optgroup label="المرحلة الابتدائية">
                                <option value="primary_1" {{ old('academic_year') == 'primary_1' ? 'selected' : '' }}>الصف الأول الابتدائي</option>
                                <option value="primary_2" {{ old('academic_year') == 'primary_2' ? 'selected' : '' }}>الصف الثاني الابتدائي</option>
                                <option value="primary_3" {{ old('academic_year') == 'primary_3' ? 'selected' : '' }}>الصف الثالث الابتدائي</option>
                                <option value="primary_4" {{ old('academic_year') == 'primary_4' ? 'selected' : '' }}>الصف الرابع الابتدائي</option>
                                <option value="primary_5" {{ old('academic_year') == 'primary_5' ? 'selected' : '' }}>الصف الخامس الابتدائي</option>
                                <option value="primary_6" {{ old('academic_year') == 'primary_6' ? 'selected' : '' }}>الصف السادس الابتدائي</option>
                            </optgroup>
                            <optgroup label="المرحلة الإعدادية">
                                <option value="prep_1" {{ old('academic_year') == 'prep_1' ? 'selected' : '' }}>الصف الأول الإعدادي</option>
                                <option value="prep_2" {{ old('academic_year') == 'prep_2' ? 'selected' : '' }}>الصف الثاني الإعدادي</option>
                                <option value="prep_3" {{ old('academic_year') == 'prep_3' ? 'selected' : '' }}>الصف الثالث الإعدادي</option>
                            </optgroup>
                            <optgroup label="المرحلة الثانوية">
                                <option value="sec_1" {{ old('academic_year') == 'sec_1' ? 'selected' : '' }}>الصف الأول الثانوي</option>
                                <option value="sec_2" {{ old('academic_year') == 'sec_2' ? 'selected' : '' }}>الصف الثاني الثانوي</option>
                                <option value="sec_3" {{ old('academic_year') == 'sec_3' ? 'selected' : '' }}>الصف الثالث الثانوي</option>
                            </optgroup>
                        </select>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="أدخل بريدك الإلكتروني"
                        >
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="new-password"
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="إنشاء كلمة مرور"
                        >
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">تأكيد كلمة المرور</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="تأكيد كلمة المرور"
                        >
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        إنشاء حساب
                    </button>
                </div>
            </form>

            <div class="text-center text-sm">
                <p class="text-gray-600">
                    هل لديك حساب بالفعل؟
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        سجل الدخول هنا
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
