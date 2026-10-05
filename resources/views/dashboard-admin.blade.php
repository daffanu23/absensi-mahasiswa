<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('status'))
                <div class="bg-green-100 text-green-800 p-4 rounded">{{ session('status') }}</div>
            @endif

            <!-- Create Course -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Buat Mata Kuliah</h3>
                <form action="{{ route('admin.courses.store') }}" method="POST">
                    @csrf
                    <div class="flex flex-wrap -mx-2 mb-4">
                        <div class="w-full md:w-1/3 px-2 mb-4 md:mb-0">
                            <label class="block text-sm">Nama Matkul</label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded" required>
                        </div>
                        <div class="w-full md:w-1/3 px-2 mb-4 md:mb-0">
                            <label class="block text-sm">Kode Matkul</label>
                            <input type="text" name="code" class="w-full border-gray-300 rounded" required>
                        </div>
                        <div class="w-full md:w-1/3 px-2">
                            <label class="block text-sm">Dosen Pengampu</label>
                            <select name="dosen_id" class="w-full border-gray-300 rounded" required>
                                <option value="">Pilih Dosen</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                </form>
            </div>

            <!-- Enroll Student -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Daftarkan Mahasiswa ke Matkul</h3>
                <form action="{{ route('admin.enroll') }}" method="POST">
                    @csrf
                    <div class="flex flex-wrap -mx-2 mb-4">
                        <div class="w-full md:w-1/2 px-2 mb-4 md:mb-0">
                            <label class="block text-sm">Mahasiswa</label>
                            <select name="student_id" class="w-full border-gray-300 rounded" required>
                                <option value="">Pilih Mahasiswa</option>
                                @foreach($mahasiswas as $mhs)
                                    <option value="{{ $mhs->id }}">{{ $mhs->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-2">
                            <label class="block text-sm">Mata Kuliah</label>
                            <select name="course_id" class="w-full border-gray-300 rounded" required>
                                <option value="">Pilih Matkul</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Daftarkan</button>
                </form>
            </div>

            <!-- List Courses -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Daftar Mata Kuliah</h3>
                <ul class="list-disc pl-5">
                    @foreach($courses as $course)
                        <li>{{ $course->code }} - {{ $course->name }} (Dosen: {{ $course->dosen->name ?? '-' }})</li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>
