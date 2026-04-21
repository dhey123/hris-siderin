<div class="space-y-8">

    {{-- ================= HEADER SECTION ================= --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            {{-- LEFT : BUTTON --}}
            <div class="flex justify-start">
                <a href="{{ route('she.risk.identifikasi.create') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white
                          px-5 py-2.5 rounded-lg text-sm font-medium shadow-sm transition">
                    + Tambah Risiko
                </a>
            </div>

            {{-- CENTER : TITLE --}}
            <div class="text-center flex-1">
                <h2 class="text-xl font-semibold text-gray-800">
                    Daftar Risiko
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Monitoring dan pengendalian risiko secara terstruktur dan profesional.
                </p>
            </div>

            {{-- RIGHT : SEARCH --}}
            <div class="flex justify-end">
                <form method="GET"
                      action="{{ route('she.risk.identifikasi.index') }}"
                      class="relative w-72">

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari risiko..."
                           class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-sm
                                  focus:ring-2 focus:ring-indigo-500 focus:outline-none
                                  shadow-sm bg-white">

                    <svg class="w-4 h-4 absolute left-3 top-3.5 text-gray-400"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </form>
            </div>

        </div>
    </div>


    {{-- ================= TABLE ================= --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm text-gray-700">

                {{-- HEADER --}}
                <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-600">
                    <tr>
                        <th class="px-5 py-4 text-left">Risiko</th>
                        <th class="px-5 py-4 text-left whitespace-nowrap">Tanggal</th>
                        <th class="px-5 py-4 text-left">Kategori</th>
                        <th class="px-4 py-4 text-center whitespace-nowrap">Skor (K×D)</th>
                        <th class="px-5 py-4 text-left whitespace-nowrap">Level</th>
                        <th class="px-5 py-4 text-left whitespace-nowrap">Status</th>
                        <th class="px-5 py-4 text-left whitespace-nowrap">Owner</th>
                        <th class="px-5 py-4 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>

                {{-- BODY --}}
                <tbody class="divide-y divide-gray-100">

                    @forelse($data as $risk)

                    @php
                        $assessment = $risk->assessments->last();
                        $hasAssessment = $assessment ? true : false;
                        $level = $assessment->risk_level ?? null;
                    @endphp

                    <tr class="hover:bg-gray-50 transition">

                        {{-- RISIKO --}}
                        <td class="px-5 py-4 font-medium text-gray-900 max-w-xs truncate">
                            {{ $risk->nama_risiko }}
                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-5 py-4 text-gray-600 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($risk->tanggal_identifikasi)->format('d M Y') }}
                        </td>

                        {{-- KATEGORI --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                {{ $risk->kategori }}
                            </span>
                        </td>

                        {{-- LIKELIHOOD dan impact--}}
                       <td class="px-4 py-4 text-center whitespace-nowrap text-xs font-semibold">
                        @if($hasAssessment)
                            {{ $assessment->likelihood }} × {{ $assessment->impact }}
                        @else
                            -
                        @endif
                    </td>

                        {{-- LEVEL --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if(!$level)
                                <span class="text-gray-400 text-xs">-</span>
                            @elseif($level === 'High')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-50 text-red-700">
                                    High
                                </span>
                            @elseif($level === 'Medium')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-50 text-yellow-700">
                                    Medium
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-50 text-green-700">
                                    Low
                                </span>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if(!$hasAssessment)
                                <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-600 font-medium">
                                    Belum Dinilai
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs rounded-full bg-emerald-50 text-emerald-700 font-medium">
                                    Sudah Dinilai
                                </span>
                            @endif
                        </td>

                        {{-- OWNER --}}
                        <td class="px-5 py-4 text-gray-600 whitespace-nowrap">
                            {{ $risk->owner ?? '-' }}
                        </td>

                        {{-- AKSI --}}
                        <td class="px-5 py-4 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-3 text-xs font-medium">

                                <a href="{{ route('she.risk.identifikasi.edit', $risk->id) }}"
                                   class="text-indigo-600 hover:text-indigo-800">
                                    Edit
                                </a>

                                <a href="{{ route('she.risk.penilaian.index', $risk->id) }}"
                                   class="text-purple-600 hover:text-purple-800">
                                    Nilai
                                </a>
                                     <a href="{{ route('she.risk.tanggap-darurat.index', $risk->id) }}"
                                    class="text-indigo-600 hover:text-indigo-800">
                                    Tanggap Darurat
                                    </a>

                                <form action="{{ route('she.risk.identifikasi.destroy', $risk->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus risiko ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-800">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-12 text-gray-400">
                            Tidak ada data risiko ditemukan.
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>
    </div>
</div>