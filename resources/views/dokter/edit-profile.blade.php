<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Edit Profil Dokter</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-indigo-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-xl font-bold text-white">Edit Profil Dokter</h1>
                            <p class="text-indigo-100 text-sm">Perbaiki informasi sesuai alasan penolakan</p>
                        </div>
                        <a href="{{ route('dokter.pending') }}" class="text-indigo-100 hover:text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('dokter.update-profile') }}" enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Alasan Penolakan -->
                    @if(auth()->user()->rejection_reason)
                        <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Alasan Penolakan</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>{{ auth()->user()->rejection_reason }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', auth()->user()->name) }}" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', auth()->user()->email) }}" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto Profil -->
                        <div class="md:col-span-2">
                            <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto Profil
                            </label>
                            @if(auth()->user()->foto)
                                <div class="mb-3">
                                    <img src="{{ Storage::url(auth()->user()->foto) }}" alt="Current Photo" class="h-20 w-20 rounded-full object-cover">
                                    <p class="text-xs text-gray-500 mt-1">Foto saat ini</p>
                                </div>
                            @endif
                            <input type="file" 
                                   id="foto" 
                                   name="foto" 
                                   accept="image/jpeg,image/png,image/jpg"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('foto') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Format: JPEG, PNG, JPG. Maksimal 10MB</p>
                            @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keahlian/Spesialisasi -->
                        <div>
                            <label for="keahlian" class="block text-sm font-medium text-gray-700 mb-2">
                                Keahlian/Spesialisasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="keahlian" 
                                   name="keahlian" 
                                   value="{{ old('keahlian', auth()->user()->keahlian) }}" 
                                   required
                                   placeholder="Contoh: Dokter Umum, Spesialis Jantung"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('keahlian') border-red-500 @enderror">
                            @error('keahlian')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lulusan Universitas -->
                        <div>
                            <label for="lulusan_universitas" class="block text-sm font-medium text-gray-700 mb-2">
                                Lulusan Universitas <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="lulusan_universitas" 
                                   name="lulusan_universitas" 
                                   value="{{ old('lulusan_universitas', auth()->user()->lulusan_universitas) }}" 
                                   required
                                   placeholder="Contoh: Universitas Indonesia"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('lulusan_universitas') border-red-500 @enderror">
                            @error('lulusan_universitas')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pengalaman Tahun -->
                        <div>
                            <label for="pengalaman_tahun" class="block text-sm font-medium text-gray-700 mb-2">
                                Pengalaman (Tahun) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="pengalaman_tahun" 
                                   name="pengalaman_tahun" 
                                   value="{{ old('pengalaman_tahun', auth()->user()->pengalaman_tahun) }}" 
                                   required
                                   min="0"
                                   max="50"
                                   placeholder="Contoh: 5"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('pengalaman_tahun') border-red-500 @enderror">
                            @error('pengalaman_tahun')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pengalaman Deskripsi -->
                        <div class="md:col-span-2">
                            <label for="pengalaman_deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Pengalaman Kerja <span class="text-red-500">*</span>
                            </label>
                            <textarea id="pengalaman_deskripsi" 
                                      name="pengalaman_deskripsi" 
                                      rows="4" 
                                      required
                                      placeholder="Deskripsikan pengalaman kerja Anda sebagai dokter..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('pengalaman_deskripsi') border-red-500 @enderror">{{ old('pengalaman_deskripsi', auth()->user()->pengalaman_deskripsi) }}</textarea>
                            @error('pengalaman_deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat Praktek -->
                        <div class="md:col-span-2">
                            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Praktek <span class="text-red-500">*</span>
                            </label>
                            <textarea id="alamat" 
                                      name="alamat" 
                                      rows="3" 
                                      required
                                      placeholder="Alamat lengkap tempat praktek Anda..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('alamat') border-red-500 @enderror">{{ old('alamat', auth()->user()->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tarif Konsultasi -->
                        <div class="md:col-span-2">
                            <label for="tarif_konsultasi" class="block text-sm font-medium text-gray-700 mb-2">
                                Tarif Konsultasi <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                <input type="number" 
                                       id="tarif_konsultasi" 
                                       name="tarif_konsultasi" 
                                       value="{{ old('tarif_konsultasi', auth()->user()->tarif_konsultasi) }}" 
                                       required
                                       min="0"
                                       placeholder="50000"
                                       class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('tarif_konsultasi') border-red-500 @enderror">
                            </div>
                            <p class="text-xs text-yellow-600 mt-1 font-medium">💡 Sesuaikan harga konsultasi dengan keahlian dan pengalaman Anda</p>
                            @error('tarif_konsultasi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jadwal Praktek -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jadwal Praktek <span class="text-red-500">*</span>
                            </label>
                            <p class="text-xs text-yellow-600 mb-3 font-medium">💡 Sesuaikan jadwal praktek dengan ketersediaan waktu Anda</p>
                            <div class="space-y-3">
                                <!-- Hari Praktek -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label for="hari_mulai" class="block text-xs font-medium text-gray-600 mb-1">Hari Mulai</label>
                                        <select id="hari_mulai" 
                                                name="hari_mulai" 
                                                required
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('hari_mulai') border-red-500 @enderror">
                                            <option value="">Pilih Hari</option>
                                            @php
                                                $hari_options = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                                $current_jadwal = auth()->user()->jadwal_kerja ?? '';
                                                $jadwal_parts = explode(' ', $current_jadwal);
                                                $hari_part = $jadwal_parts[0] ?? '';
                                                $current_hari_mulai = '';
                                                $current_hari_selesai = '';
                                                
                                                if (strpos($hari_part, '-') !== false) {
                                                    $hari_range = explode('-', $hari_part);
                                                    $current_hari_mulai = $hari_range[0] ?? '';
                                                    $current_hari_selesai = $hari_range[1] ?? '';
                                                } else {
                                                    $current_hari_mulai = $hari_part;
                                                }
                                            @endphp
                                            @foreach($hari_options as $hari)
                                                <option value="{{ $hari }}" {{ old('hari_mulai', $current_hari_mulai) == $hari ? 'selected' : '' }}>
                                                    {{ $hari }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('hari_mulai')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="hari_selesai" class="block text-xs font-medium text-gray-600 mb-1">Hari Selesai (Opsional)</label>
                                        <select id="hari_selesai" 
                                                name="hari_selesai"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('hari_selesai') border-red-500 @enderror">
                                            <option value="">Sama dengan hari mulai</option>
                                            @foreach($hari_options as $hari)
                                                <option value="{{ $hari }}" {{ old('hari_selesai', $current_hari_selesai) == $hari ? 'selected' : '' }}>
                                                    {{ $hari }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('hari_selesai')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Jam Praktek -->
                                <div class="grid grid-cols-2 gap-3">
                                    @php
                                        $jam_part = $jadwal_parts[1] ?? '';
                                        $current_jam_mulai = '';
                                        $current_jam_selesai = '';
                                        
                                        if (strpos($jam_part, '-') !== false) {
                                            $jam_range = explode('-', $jam_part);
                                            $current_jam_mulai = $jam_range[0] ?? '';
                                            $current_jam_selesai = $jam_range[1] ?? '';
                                        }
                                    @endphp
                                    <div>
                                        <label for="jam_mulai" class="block text-xs font-medium text-gray-600 mb-1">Jam Mulai</label>
                                        <input type="time" 
                                               id="jam_mulai" 
                                               name="jam_mulai" 
                                               value="{{ old('jam_mulai', $current_jam_mulai) }}" 
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('jam_mulai') border-red-500 @enderror">
                                        @error('jam_mulai')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="jam_selesai" class="block text-xs font-medium text-gray-600 mb-1">Jam Selesai</label>
                                        <input type="time" 
                                               id="jam_selesai" 
                                               name="jam_selesai" 
                                               value="{{ old('jam_selesai', $current_jam_selesai) }}" 
                                               required
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('jam_selesai') border-red-500 @enderror">
                                        @error('jam_selesai')
                                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sertifikat (Opsional) -->
                        <div class="md:col-span-2">
                            <label for="sertifikat" class="block text-sm font-medium text-gray-700 mb-2">
                                Sertifikat/Dokumen Pendukung
                            </label>
                            @if(auth()->user()->sertifikat)
                                <div class="mb-3">
                                    <a href="{{ Storage::url(auth()->user()->sertifikat) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-sm">
                                        📄 Lihat sertifikat saat ini
                                    </a>
                                </div>
                            @endif
                            <input type="file" 
                                   id="sertifikat" 
                                   name="sertifikat" 
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('sertifikat') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, JPEG, PNG, JPG. Maksimal 10MB (Opsional)</p>
                            @error('sertifikat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="{{ route('dokter.pending') }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-4 w-4 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Simpan & Kirim Ulang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Preview foto yang diupload
        document.getElementById('foto').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create or update preview image
                    let previewContainer = document.getElementById('foto-preview');
                    if (!previewContainer) {
                        previewContainer = document.createElement('div');
                        previewContainer.id = 'foto-preview';
                        previewContainer.className = 'mt-3';
                        document.getElementById('foto').parentNode.insertBefore(previewContainer, document.getElementById('foto').nextSibling);
                    }
                    previewContainer.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" class="h-20 w-20 rounded-full object-cover">
                        <p class="text-xs text-gray-500 mt-1">Preview foto baru</p>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });

        // Auto-set hari selesai jika tidak dipilih
        document.getElementById('hari_mulai').addEventListener('change', function() {
            const hariSelesai = document.getElementById('hari_selesai');
            if (!hariSelesai.value) {
                hariSelesai.value = this.value;
            }
        });

        // Validasi jam praktek
        document.getElementById('jam_selesai').addEventListener('change', function() {
            const jamMulai = document.getElementById('jam_mulai').value;
            const jamSelesai = this.value;
            
            if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
                alert('Jam selesai harus lebih besar dari jam mulai!');
                this.value = '';
            }
        });
    </script>
</body>
</html>