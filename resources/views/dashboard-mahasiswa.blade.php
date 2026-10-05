<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mahasiswa Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('status'))
                <div class="bg-green-100 text-green-800 p-4 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Mata Kuliah Anda</h3>
                
                @if($courses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($courses as $course)
                            <div class="border p-4 rounded shadow-sm">
                                <h4 class="font-bold text-xl">{{ $course->name }} ({{ $course->code }})</h4>
                                <p class="text-gray-600 mb-4">Dosen: {{ $course->dosen->name ?? '-' }}</p>
                                
                                @php
                                    $hasAttended = \App\Models\Attendance::where('course_id', $course->id)
                                        ->where('student_id', Auth::id())
                                        ->where('date', now()->toDateString())
                                        ->exists();
                                @endphp

                                @if($hasAttended)
                                    <span class="bg-green-500 text-white px-3 py-1 rounded text-sm">Sudah Absen Hari Ini</span>
                                @else
                                    <a href="{{ route('attendance.take', $course->id) }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded text-sm">Ambil Absensi</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>Anda belum terdaftar di mata kuliah apapun.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
