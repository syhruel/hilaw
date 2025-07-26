<!-- Profile Form Partial -->
<form method="POST" action="{{ route('dokter.update-profile') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <!-- Nama Lengkap -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
        <input id="name" type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
               placeholder="Masukkan nama lengkap Anda" required>
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
               placeholder="Masukkan alamat email Anda" required>
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Foto Profil -->
    <div>
        <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">Foto Profil</label>
        <div class="flex items-center space-x-4">
            @if(auth()->user()->foto)
                <img class="h-16 w-16 rounded-full object-cover border-2 border-gray-200" src="{{ Storage::url(auth()->user()->foto) }}" alt="Current Photo">
            @else
                <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            @endif
            <div class="flex-1">
                <input id="foto" type="file" name="foto" accept="image/*" 
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                       {{ !auth()->user()->foto ? 'required' : '' }}>
                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, JPEG. Maksimal 10MB</p>
            </div>
        </div>
        @error('foto')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Keahlian -->
    <div>
        <label for="keahlian" class="block text-sm font-medium text-gray-700 mb-2">Spesialisasi/Keahlian</label>
        <input id="keahlian" type="text" name="keahlian" value="{{ old('keahlian', auth()->user()->keahlian) }}" 
               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
               placeholder="Contoh: Dokter Umum, Spesialis Anak, dll" required>
        @error('keahlian')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Pengalaman Tahun -->
    <div>
        <label for="pengalaman_tahun" class="block text-sm font-medium text-gray-700 mb-2">Pengalaman (Tahun)</label>
        <input id="pengalaman_tahun" type="number" name="pengalaman_tahun" value="{{ old('pengalaman_tahun', auth()->user()->pengalaman_tahun) }}" 
               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
               min="0" max="50" required>
        @error('pengalaman_tahun')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Pengalaman Deskripsi -->
    <div>
        <label for="pengalaman_deskripsi" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Pengalaman</label>
        <textarea id="pengalaman_deskripsi" name="pengalaman_deskripsi" rows="4" 
                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  placeholder="Jelaskan pengalaman kerja Anda sebagai dokter" required>{{ old('pengalaman_deskripsi', auth()->user()->pengalaman_deskripsi) }}</textarea>
        @error('pengalaman_deskripsi')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Lulusan Universitas -->
    <div>
        <label for="lulusan_universitas" class="block text-sm font-medium text-gray-700 mb-2">Universitas Asal</label>
        <input id="lulusan_universitas" type="text" name="lulusan_universitas" value="{{ old('lulusan_universitas', auth()->user()->lulusan_universitas) }}" 
               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
               placeholder="Nama universitas tempat Anda lulus" required>
        @error('lulusan_universitas')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Alamat -->
    <div>
        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat Praktik</label>
        <textarea id="alamat" name="alamat" rows="3" 
                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                  placeholder="Alamat lengkap tempat praktik" required>{{ old('alamat', auth()->user()->alamat) }}</textarea>
        @error('alamat')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Tarif Konsultasi -->
    <div>
        <label for="tarif_konsultasi" class="block text-sm font-medium text-gray-700 mb-2">Tarif Konsultasi (Rp)</label>
        <input id="tarif_konsultasi" type="number" name="tarif_konsultasi" value="{{ old('tarif_konsultasi', auth()->user()->tarif_konsultasi) }}" 
               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
               min="0" step="1000" placeholder="50000" required>
        @error('tarif_konsultasi')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Jadwal Praktik -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="hari_mulai" class="block text-sm font-medium text-gray-700 mb-2">Hari Mulai</label>
            <select id="hari_mulai" name="hari_mulai" 
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                <option value="">Pilih Hari</option>
                @php
                    $hari_options = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    $current_jadwal = auth()->user()->jadwal_kerja;
                    $selected_hari_mulai = '';
                    if ($current_jadwal) {
                        $parts = explode(' ', $current_jadwal);
                        if (count($parts) >= 2) {
                            $hari_part = $parts[0];
                            if (strpos($hari_part, '-') !== false) {
                                $selected_hari_mulai = explode('-', $hari_part)[0];
                            } else {
                                $selected_hari_mulai = $hari_part;
                            }
                        }
                    }
                @endphp
                @foreach($hari_options as $hari)
                    <option value="{{ $hari }}" {{ old('hari_mulai', $selected_hari_mulai) == $hari ? 'selected' : '' }}>
                        {{ $hari }}
                    </option>
                @endforeach
            </select>
            @error('hari_mulai')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="hari_selesai" class="block text-sm font-medium text-gray-700 mb-2">Hari Selesai (Opsional)</label>
            <select id="hari_selesai" name="hari_selesai" 
                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Pilih Hari (Jika Rentang)</option>
                @php
                    $selected_hari_selesai = '';
                    if ($current_jadwal && strpos($current_jadwal, '-') !== false) {
                        $parts = explode(' ', $current_jadwal);
                        if (count($parts) >= 2) {
                            $hari_part = $parts[0];
                            if (strpos($hari_part, '-') !== false) {
                                $selected_hari_selesai = explode('-', $hari_part)[1];
                            }
                        }
                    }
                @endphp
                @foreach($hari_options as $hari)
                    <option value="{{ $hari }}" {{ old('hari_selesai', $selected_hari_selesai) == $hari ? 'selected' : '' }}>
                        {{ $hari }}
                    </option>
                @endforeach
            </select>
            @error('hari_selesai')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Jam Praktik -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @php
            $selected_jam_mulai = '';
            $selected_jam_selesai = '';
            if ($current_jadwal) {
                $parts = explode(' ', $current_jadwal);
                if (count($parts) >= 2) {
                    $jam_part = $parts[1];
                    if (strpos($jam_part, '-') !== false) {
                        $jam_split = explode('-', $jam_part);
                        $selected_jam_mulai = $jam_split[0];
                        $selected_jam_selesai = $jam_split[1] ?? '';
                    }
                }
            }
        @endphp
        <div>
            <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-2">Jam Mulai</label>
            <input id="jam_mulai" type="time" name="jam_mulai" value="{{ old('jam_mulai', $selected_jam_mulai) }}" 
                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            @error('jam_mulai')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-2">Jam Selesai</label>
            <input id="jam_selesai" type="time" name="jam_selesai" value="{{ old('jam_selesai', $selected_jam_selesai) }}" 
                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
            @error('jam_selesai')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Sertifikat -->
    <div>
        <label for="sertifikat" class="block text-sm font-medium text-gray-700 mb-2">Sertifikat/Ijazah Kedokteran</label>
        <div class="space-y-2">
            @if(auth()->user()->sertifikat)
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Sertifikat sudah terupload</span>
                    <a href="{{ Storage::url(auth()->user()->sertifikat) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 underline">Lihat</a>
                </div>
            @endif
            <input id="sertifikat" type="file" name="sertifikat" accept=".pdf,.jpg,.jpeg,.png" 
                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                   {{ !auth()->user()->sertifikat ? 'required' : '' }}>
            <p class="text-xs text-gray-500">Format: PDF, JPG, PNG, JPEG. Maksimal 10MB</p>
        </div>
        @error('sertifikat')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Submit Button -->
    <div class="pt-4">
        <button type="submit" 
                class="w-full inline-flex justify-center items-center rounded-xl bg-gradient-to-r from-indigo-600 to-blue-600 px-6 py-3 text-base font-medium text-white shadow-lg hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 transform hover:scale-105">
            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
            {{ auth()->user()->approval_status == 'rejected' ? 'Kirim Ulang Data' : 'Kirim Data untuk Persetujuan' }}
        </button>
    </div>
</form>