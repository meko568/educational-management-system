<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\AdminExamController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Parent\AuthController as ParentAuthController;
use App\Http\Controllers\Parent\DashboardController as ParentDashboardController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'timestamp' => time()]);
})->withoutMiddleware([
    \App\Http\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \App\Http\Middleware\VerifyCsrfToken::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class
])->name('health');

Route::get('/db-check', function () {
    $config = [
        'driver' => config('database.default'),
        'host' => config('database.connections.mysql.host'),
        'port' => config('database.connections.mysql.port'),
        'database' => config('database.connections.mysql.database'),
        'username' => config('database.connections.mysql.username'),
    ];

    try {
        // Use a very short timeout (3 seconds) to prevent 524 error
        $pdo = new \PDO(
            "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']}",
            $config['username'],
            config('database.connections.mysql.password'),
            [\PDO::ATTR_TIMEOUT => 3, \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]
        );

        return response()->json([
            'status' => 'connected',
            'details' => $config
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'hint' => 'Check if DB_HOST is reachable from this container. If using PandaStack Managed DB, do not use 127.0.0.1.',
            'debug_info' => $config
        ], 500);
    }
})->withoutMiddleware([
    \App\Http\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \App\Http\Middleware\VerifyCsrfToken::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class
])->name('db-check');

Route::get('/', function () {
    return view('home');
});

Route::get('/lang/{locale}', function (string $locale) {
    if (!in_array($locale, ['en', 'ar'], true)) {
        abort(404);
    }

    session(['locale' => $locale]);
    return redirect()->back();
})->name('lang.switch');

use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\StudentExamController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AcademicYearController;

// Redirect /dashboard based on user role
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'student') {
        return redirect()->route('student.dashboard');
    }

    auth()->logout();
    return redirect()->route('login')->with('error', 'Unauthorized access.');
})->middleware(['redirect_if_parent', 'auth', 'verified'])->name('dashboard');

// Student dashboard route - shows student's own academic year
Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
    ->middleware(['redirect_if_parent', 'auth', 'verified', 'is_student'])
    ->name('student.dashboard');

// Student courses and lessons routes
Route::middleware(['redirect_if_parent', 'auth', 'verified', 'is_student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/courses', [StudentCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [StudentCourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/lessons/{lesson}', [StudentCourseController::class, 'showLesson'])->name('lessons.show');
    
    // Student exam routes
    Route::prefix('exams')->name('exams.')->group(function () {
        Route::get('/', [StudentExamController::class, 'index'])->name('index');
        Route::post('/{exam}/start', [StudentExamController::class, 'start'])->name('start');
        Route::get('/take/{attempt}', [StudentExamController::class, 'take'])->name('take');
        Route::post('/save-answer/{attempt}', [StudentExamController::class, 'saveAnswer'])->name('save-answer');
        Route::post('/submit/{attempt}', [StudentExamController::class, 'submit'])->name('submit');
        Route::get('/result/{attempt}', [StudentExamController::class, 'result'])->name('result');
    });
});

// Parent auth + dashboard
Route::middleware('guest')->prefix('parent')->name('parent.')->group(function () {
    Route::get('/login', [ParentAuthController::class, 'create'])->name('login');
    Route::post('/login', [ParentAuthController::class, 'store'])->name('login.store');
});

Route::middleware('is_parent')->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/sons/{student}', [ParentDashboardController::class, 'showSon'])->name('sons.show');
    Route::post('/logout', [ParentAuthController::class, 'destroy'])->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['redirect_if_parent', 'auth', 'is_admin'])->group(function () {
    // Admin dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/dashboard/{academicYear}', [DashboardController::class, 'showByYear'])
        ->name('admin.dashboard.year');

    // Students resource
    Route::resource('students', StudentController::class)
        ->names('admin.students');

    Route::get('/admin/parents', [ParentController::class, 'index'])->name('admin.parents.index');

    // Student payment routes
    Route::get('students/{student}/payment', [StudentController::class, 'showPayment'])
        ->name('admin.students.payment');
    Route::post('students/{student}/process-payment', [StudentController::class, 'processPayment'])
        ->name('admin.students.process-payment');

    // Attendance resource
    Route::resource('attendances', AttendanceController::class)
        ->names('admin.attendances')
        ->except(['show']);

    // Admin Exams resource (new auto-revision system)
    Route::prefix('admin-exams')->name('admin.exams.')->group(function () {
        Route::get('/', [AdminExamController::class, 'index'])->name('index');
        Route::get('/create', [AdminExamController::class, 'create'])->name('create');
        Route::post('/', [AdminExamController::class, 'store'])->name('store');
        Route::get('/{exam}', [AdminExamController::class, 'show'])->name('show');
        Route::get('/{exam}/edit', [AdminExamController::class, 'edit'])->name('edit');
        Route::put('/{exam}', [AdminExamController::class, 'update'])->name('update');
        Route::delete('/{exam}', [AdminExamController::class, 'destroy'])->name('destroy');
        Route::get('/{exam}/questions/create', [AdminExamController::class, 'createQuestions'])->name('questions.create');
        Route::post('/{exam}/questions', [AdminExamController::class, 'storeQuestions'])->name('questions.store');
    });

    // Auto-Revision Quizzes resource
    Route::prefix('admin-quizzes')->name('admin.quizzes.')->group(function () {
        Route::get('/', [AdminQuizController::class, 'index'])->name('index');
        Route::get('/create', [AdminQuizController::class, 'create'])->name('create');
        Route::post('/', [AdminQuizController::class, 'store'])->name('store');
        Route::get('/{quiz}', [AdminQuizController::class, 'show'])->name('show');
        Route::get('/{quiz}/edit', [AdminQuizController::class, 'edit'])->name('edit');
        Route::put('/{quiz}', [AdminQuizController::class, 'update'])->name('update');
        Route::delete('/{quiz}', [AdminQuizController::class, 'destroy'])->name('destroy');
        Route::get('/{quiz}/questions/create', [AdminQuizController::class, 'createQuestions'])->name('questions.create');
        Route::post('/{quiz}/questions', [AdminQuizController::class, 'storeQuestions'])->name('questions.store');
    });

    // Exams resource (manual result recording)
    Route::resource('exams', ExamController::class)
        ->names('admin.manual-exams');
    Route::get('exams/{exam}/results', [ExamController::class, 'results'])
        ->name('admin.manual-exams.results');
    Route::post('exams/{exam}/results', [ExamController::class, 'storeResult'])
        ->name('admin.manual-exams.storeResult');
    Route::delete('exams/{exam}/results/{result}', [ExamController::class, 'deleteResult'])
        ->name('admin.manual-exams.deleteResult');

    // Quizzes resource
    Route::resource('quizzes', QuizController::class)
        ->names('admin.quizzes');
    Route::get('quizzes/{quiz}/results', [QuizController::class, 'results'])
        ->name('admin.quizzes.results');
    Route::post('quizzes/{quiz}/results', [QuizController::class, 'storeResult'])
        ->name('admin.quizzes.storeResult');
    Route::delete('quizzes/{quiz}/results/{result}', [QuizController::class, 'deleteResult'])
        ->name('admin.quizzes.deleteResult');

    // Courses resource with academic year
    Route::prefix('{academicYear}')->group(function () {
        Route::resource('courses', CourseController::class)
            ->names('admin.courses');

        // Lessons resource (nested under courses)
        Route::prefix('courses/{course}')->name('admin.courses.')->group(function () {
            Route::resource('lessons', LessonController::class)
                ->names('lessons');
        });
    });

    // Remove duplicate dashboard route
    // Route::get('/Admindashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

require __DIR__ . '/auth.php';
