<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dosen Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Mata Kuliah Anda</h3>
                
                @if($courses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($courses as $course)
                            <div class="border p-4 rounded shadow-sm">
                                <h4 class="font-bold text-xl">{{ $course->name }} ({{ $course->code }})</h4>
                                <p class="text-gray-600 mt-2">Total Mahasiswa: {{ $course->students()->count() }}</p>
                                <a href="{{ route('dosen.attendances', $course->id) }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded text-sm">Lihat Absensi</a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>Anda belum memiliki mata kuliah yang diajar.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
