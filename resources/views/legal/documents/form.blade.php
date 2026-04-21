<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Nama Dokumen --}}
    <div>
        <label class="block text-sm font-medium">Nama Dokumen *</label>
        <input type="text" 
               name="nama_dokumen"
               value="{{ old('nama_dokumen', $document->nama_dokumen ?? '') }}"
               class="mt-1 w-full px-4 py-2 border rounded-lg">
        @error('nama_dokumen')
            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Kategori --}}
    <div>
        <label class="block text-sm font-medium">Kategori *</label>
        <input type="text" 
               name="kategori"
               value="{{ old('kategori', $document->kategori ?? '') }}"
               class="mt-1 w-full px-4 py-2 border rounded-lg">
        @error('kategori')
            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Nomor Dokumen --}}
    <div>
        <label class="block text-sm font-medium">Nomor Dokumen</label>
        <input type="text" 
               name="nomor_dokumen"
               value="{{ old('nomor_dokumen', $document->nomor_dokumen ?? '') }}"
               class="mt-1 w-full px-4 py-2 border rounded-lg">
    </div>

    {{-- Vendor --}}
    <div>
        <label class="block text-sm font-medium">Vendor</label>
        <select name="vendor_id"
                class="mt-1 w-full px-4 py-2 border rounded-lg">
            <option value="">-- Pilih Vendor --</option>
            @foreach($vendors as $vendor)
                <option value="{{ $vendor->id }}"
                    {{ (old('vendor_id', $document->vendor_id ?? '') == $vendor->id) ? 'selected' : '' }}>
                    {{ $vendor->nama_vendor }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Tanggal Terbit --}}
    <div>
        <label class="block text-sm font-medium">Tanggal Terbit</label>
        <input type="date" 
               name="tanggal_terbit"
               value="{{ old('tanggal_terbit', $document->tanggal_terbit ?? '') }}"
               class="mt-1 w-full px-4 py-2 border rounded-lg">
    </div>

    {{-- Tanggal Berakhir --}}
    <div>
        <label class="block text-sm font-medium">Tanggal Berakhir</label>
        <input type="date" 
               name="tanggal_berakhir"
               value="{{ old('tanggal_berakhir', $document->tanggal_berakhir ?? '') }}"
               class="mt-1 w-full px-4 py-2 border rounded-lg">
    </div>
{{-- Upload File --}}
<div class="md:col-span-2">
    <label class="block text-sm font-medium">Upload File (PDF/DOC)</label>

    <input type="file" 
           name="file_path"
           class="mt-1 w-full">

    <small class="text-gray-500">
        Maksimal ukuran file 2MB (PDF, DOC, DOCX)
    </small>

    @if(isset($document) && $document->file_path)
        <div class="text-sm text-gray-500 mt-2">
            File saat ini:
            <a href="{{ asset('storage/'.$document->file_path) }}"
               target="_blank"
               class="text-blue-600 underline">
                Lihat File
            </a>
        </div>
    @endif
</div>

</div>