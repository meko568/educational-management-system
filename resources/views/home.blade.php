<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Management System') }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Custom Styles -->
        <style>
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            @keyframes slideInLeft {
                from {
                    opacity: 0;
                    transform: translateX(-50px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(50px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            
            @keyframes pulse {
                0%, 100% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.05);
                }
            }
            
            .hero-gradient {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            
            .card-hover {
                transition: all 0.3s ease;
            }
            
            .card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
            }
            
            .rtl .card-hover:hover {
                transform: translateY(-5px);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <!-- Navigation -->
        @include('layouts.navigation')
        
        <!-- Hero Section -->
        <section class="hero-gradient text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <!-- Teacher Photo with Animation -->
                    <div class="mb-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                        <div class="relative inline-block">
                            <div class="w-32 h-32 mx-auto rounded-full overflow-hidden border-4 border-white shadow-xl">
                                <img src="https://images.unsplash.com/photo-1507001907259?auto=format&fit=crop&w=150&h=150" 
                                     alt="Teacher" 
                                     class="w-full h-full object-cover">
                            </div>
                            <!-- Decorative Ring -->
                            <div class="absolute -bottom-2 -right-2 w-36 h-36 border-4 border-white rounded-full opacity-20"></div>
                        </div>
                        
                        <h1 class="text-4xl font-bold text-white mb-4 animate-fade-in-up" style="animation-delay: 0.4s;">
                            @if(app()->getLocale() === 'ar')
                                أهلاً بكم في نظام الإدارة التعليمي
                            @else
                                Welcome to the Educational Management System
                            @endif
                        </h1>
                        
                        <p class="text-xl text-white/90 mb-8 animate-fade-in-up" style="animation-delay: 0.6s;">
                            @if(app()->getLocale() === 'ar')
                                نظام متكامل لإدارة الطلاب والاختبارات والحضور والدورات التعليمية
                            @else
                                A complete system for student management, exams, attendance, and course administration
                            @endif
                        </p>
                        
                        <!-- Call to Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up" style="animation-delay: 0.8s;">
                            @auth
                                <a href="{{ route('dashboard') }}" 
                                   class="px-8 py-4 bg-white text-gray-800 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                    @if(app()->getLocale() === 'ar')
                                        لوحة التحكم
                                    @else
                                        Dashboard
                                    @endif
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="px-8 py-4 bg-white text-gray-800 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                    @if(app()->getLocale() === 'ar')
                                        تسجيل الدخول
                                    @else
                                        Login
                                    @endif
                                </a>
                            @endauth
                        </div>
                </div>
            </div>
        </section>
        
        <!-- Features Section -->
        <section class="py-16 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        @if(app()->getLocale() === 'ar')
                            مميزات النظام
                        @else
                            System Features
                        @endif
                    </h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Student Management -->
                    <div class="card-hover bg-white dark:bg-gray-700 p-6 rounded-xl shadow-lg">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                @if(app()->getLocale() === 'ar')
                                    إدارة الطلاب
                                @else
                                    Student Management
                                @endif
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                @if(app()->getLocale() === 'ar')
                                    إدارة شاملة للطلاب وتتبع أدائهم الأكاديمية
                                @else
                                    Complete student administration and academic progress tracking
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <!-- Exam Management -->
                    <div class="card-hover bg-white dark:bg-gray-700 p-6 rounded-xl shadow-lg">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                @if(app()->getLocale() === 'ar')
                                    إدارة الاختبارات
                                @else
                                    Exam Management
                                @endif
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                @if(app()->getLocale() === 'ar')
                                    إنشاء وإدارة الاختبارات مع نتائج فورية
                                @else
                                    Create and manage exams with instant results
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <!-- Attendance Tracking -->
                    <div class="card-hover bg-white dark:bg-gray-700 p-6 rounded-xl shadow-lg">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                @if(app()->getLocale() === 'ar')
                                    تتبع الحضور
                                @else
                                    Attendance Tracking
                                @endif
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                @if(app()->getLocale() === 'ar')
                                    نظام متقدم لتسجيل الحضور والغياب
                                @else
                                    Advanced attendance and absence tracking system
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <!-- Course Management -->
                    <div class="card-hover bg-white dark:bg-gray-700 p-6 rounded-xl shadow-lg">
                        <div class="text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-orange-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 6.253v13m0-13C6.5 6.253 2 10.998 2 17s4.5 10.747 10 10.747c5.5 0 10-4.998 10-10.747S17.5 6.253 12 6.253z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                @if(app()->getLocale() === 'ar')
                                    إدارة الدورات
                                @else
                                    Course Management
                                @endif
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                @if(app()->getLocale() === 'ar')
                                    تنظيم الدورات والدروس بالصور والفيديو
                                @else
                                    Organize courses with rich media content
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- About Section -->
        <section class="py-16 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- About Content -->
                    <div class="text-center lg:text-left">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                            @if(app()->getLocale() === 'ar')
                                عن المطور
                            @else
                                About the Developer
                            @endif
                        </h2>
                        <div class="max-w-2xl mx-auto">
                            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl">
                                <div class="flex items-center mb-6">
                                    <div class="w-24 h-24 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl animate-pulse">
                                        {{ app()->getLocale() === 'ar' ? 'أ' : 'A' }}
                                    </div>
                                    <div class="ml-6">
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                            @if(app()->getLocale() === 'ar')
                                                محمد أحمد
                                            @else
                                                Mohammed Ahmed
                                            @endif
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                                            @if(app()->getLocale() === 'ar')
                                                مطور نظام الإدارة التعليمي متخصص في Laravel
                                            @else
                                                Educational Management System Developer specializing in Laravel
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 dark:text-gray-300">
                                @if(app()->getLocale() === 'ar')
                                    هذا النظام تم تطويره لتوفير أداة متكاملة وسهلة الاستخدام لإدارة المؤسسات التعليمية الحديثة. يتميز بواجهة مستخدمية عصرية ودعم متعدد اللغات وتقارير عالية للأداء.
                                @else
                                    This system was developed to provide a comprehensive tool for modern educational institutions. It features a user-friendly interface, multi-language support, and high-performance architecture for efficient school management.
                                @endif
                            </p>
                            
                            <!-- Skills -->
                            <div class="grid grid-cols-2 gap-4 mt-8">
                                <div class="text-center">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Laravel</h4>
                                    <div class="flex justify-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Tailwind CSS</h4>
                                    <div class="flex justify-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">JavaScript</h4>
                                    <div class="flex justify-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Info -->
                    <div class="text-center lg:text-right">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">
                            @if(app()->getLocale() === 'ar')
                                تواصل معنا
                            @else
                                Contact Information
                            @endif
                        </h2>
                        <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl">
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 8l7.89 5.26a1 1 0 01.447.21.11l-4.293 4.293a1 1 0 01-.293-.707L8.586 10H4a1 1 0 110-2h4a1 1 0 00-2 2v1a1 1 0 002 2h3a1 1 0 012 2l4.293 4.293a1 1 0 01.293.707V7a1 1 0 002-2H3a1 1 0 00-2 2z"/>
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-gray-600 dark:text-gray-300">
                                            @if(app()->getLocale() === 'ar')
                                                البريد الإلكتروني
                                            @else
                                                Email
                                            @endif
                                        </p>
                                        <p class="text-gray-900 dark:text-white font-medium">teacher@school.edu</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 5a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                    </svg>
                                    <div class="ml-3">
                                        <p class="text-gray-600 dark:text-gray-300">
                                            @if(app()->getLocale() === 'ar')
                                                رقم الهاتف
                                            @else
                                                Phone
                                            @endif
                                        </p>
                                        <p class="text-gray-900 dark:text-white font-medium">+20 123 456 7890</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-gray-400">
                        &copy; {{ date('Y') }} {{ config('app.name', 'Management System') }}.
                        @if(app()->getLocale() === 'ar')
                            جميع الحقوق محفوظة © 2026 محمد أحمد.
                        @else
                            All rights reserved &copy; 2026 Mohammed Ahmed.
                        @endif
                    </p>
                </div>
            </div>
        </footer>
    </body>
</html>
