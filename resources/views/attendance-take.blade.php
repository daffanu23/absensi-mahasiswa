<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ambil Absensi: {{ $course->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <a href="{{ route('dashboard') }}" class="text-blue-500 mb-4 inline-block">&larr; Kembali ke Dashboard</a>

                <h3 class="text-lg font-bold mb-4">Silakan ambil foto dan dapatkan lokasi.</h3>

                <form action="{{ route('attendance.store', $course->id) }}" method="POST" enctype="multipart/form-data" id="attendanceForm">
                    @csrf
                    
                    <input type="hidden" name="location_lat" id="location_lat" required>
                    <input type="hidden" name="location_lng" id="location_lng" required>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Lokasi Anda:</label>
                        <p id="locationStatus" class="text-gray-500 text-sm">Menunggu lokasi...</p>
                        <button type="button" id="getLocationBtn" class="mt-2 bg-gray-200 px-3 py-1 rounded text-sm hover:bg-gray-300">Dapatkan Lokasi</button>
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-2">Bukti Foto:</label>
                        <input type="file" name="photo" accept="image/*" capture="environment" class="w-full border p-2 rounded" required>
                        <p class="text-sm text-gray-500 mt-1">Anda bisa langsung mengambil foto dari kamera HP jika mendukung.</p>
                    </div>

                    <button type="submit" id="submitBtn" class="bg-blue-500 text-white px-4 py-2 rounded opacity-50 cursor-not-allowed" disabled>Kirim Absensi</button>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('getLocationBtn').addEventListener('click', function() {
            let status = document.getElementById('locationStatus');
            status.textContent = 'Mendapatkan lokasi...';
            
            if (!navigator.geolocation) {
                status.textContent = 'Geolocation tidak didukung browser ini.';
            } else {
                navigator.geolocation.getCurrentPosition(success, error);
            }

            function success(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                document.getElementById('location_lat').value = lat;
                document.getElementById('location_lng').value = lng;
                status.innerHTML = `<span class="text-green-600 font-bold">Lokasi didapatkan: ${lat}, ${lng}</span>`;
                
                // Enable submit
                document.getElementById('submitBtn').classList.remove('opacity-50', 'cursor-not-allowed');
                document.getElementById('submitBtn').disabled = false;
            }

            function error() {
                status.innerHTML = `<span class="text-red-600">Gagal mendapatkan lokasi. Pastikan izin lokasi diaktifkan.</span>`;
            }
        });
    </script>
</x-app-layout>
