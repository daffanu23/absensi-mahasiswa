<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    
    // Dashboard Route - dynamically loads view based on role
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $courses = Course::with('dosen')->get();
            $dosens = User::where('role', 'dosen')->get();
            $mahasiswas = User::where('role', 'mahasiswa')->get();
            return view('dashboard-admin', compact('courses', 'dosens', 'mahasiswas'));
        } elseif ($user->role === 'dosen') {
            $courses = $user->coursesTaught;
            return view('dashboard-dosen', compact('courses'));
        } else {
            $courses = $user->coursesTaken;
            return view('dashboard-mahasiswa', compact('courses'));
        }
    })->name('dashboard');

    // Admin Routes
    Route::post('/admin/courses', function(Request $request) {
        $request->validate(['name' => 'required', 'code' => 'required|unique:courses', 'dosen_id' => 'required']);
        Course::create($request->all());
        return redirect()->back()->with('status', 'Course created!');
    })->name('admin.courses.store');

    Route::post('/admin/enroll', function(Request $request) {
        $request->validate(['course_id' => 'required', 'student_id' => 'required']);
        $course = Course::findOrFail($request->course_id);
        $course->students()->syncWithoutDetaching([$request->student_id]);
        return redirect()->back()->with('status', 'Student enrolled!');
    })->name('admin.enroll');

    // Mahasiswa Routes
    Route::get('/attendance/{course}', function(Course $course) {
        return view('attendance-take', compact('course'));
    })->name('attendance.take');

    Route::post('/attendance/{course}', function(Request $request, Course $course) {
        $request->validate([
            'location_lat' => 'required',
            'location_lng' => 'required',
            'photo' => 'required|image'
        ]);

        $path = $request->file('photo')->store('attendances', 'public');

        Attendance::create([
            'course_id' => $course->id,
            'student_id' => Auth::id(),
            'date' => now()->toDateString(),
            'status' => 'hadir',
            'location_lat' => $request->location_lat,
            'location_lng' => $request->location_lng,
            'photo_path' => $path
        ]);

        return redirect()->route('dashboard')->with('status', 'Attendance submitted!');
    })->name('attendance.store');

    // Dosen Routes
    Route::get('/dosen/course/{course}/attendances', function(Course $course) {
        $attendances = $course->attendances()->with('student')->get();
        return view('attendance-view', compact('course', 'attendances'));
    })->name('dosen.attendances');
});

require __DIR__.'/auth.php';
