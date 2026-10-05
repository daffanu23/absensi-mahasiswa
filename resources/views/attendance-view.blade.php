<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Absensi: {{ $course->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <a href="{{ route('dashboard') }}" class="text-blue-500 mb-4 inline-block">&larr; Kembali ke Dashboard</a>
                
                <h3 class="text-lg font-bold mb-4">Daftar Absensi Mahasiswa</h3>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="border-b p-2">Tanggal</th>
                            <th class="border-b p-2">Mahasiswa</th>
                            <th class="border-b p-2">Status</th>
                            <th class="border-b p-2">Lokasi (GPS)</th>
                            <th class="border-b p-2">Bukti Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $att)
                            <tr>
                                <td class="border-b p-2">{{ $att->date }}</td>
                                <td class="border-b p-2">{{ $att->student->name ?? '-' }}</td>
                                <td class="border-b p-2 uppercase">{{ $att->status }}</td>
                                <td class="border-b p-2">
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $att->location_lat }},{{ $att->location_lng }}" target="_blank" class="text-blue-500 underline">Lihat Peta</a>
                                </td>
                                <td class="border-b p-2">
                                    @if($att->photo_path)
                                        <a href="{{ asset('storage/' . $att->photo_path) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $att->photo_path) }}" class="h-16 w-16 object-cover rounded" alt="Bukti Foto">
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-2 text-center text-gray-500">Belum ada data absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
