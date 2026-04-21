@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                ⚖️ Legal 
            </h1>
            <p class="text-sm text-gray-500">
                Monitoring dokumen, kontrak & compliance perusahaan
            </p>
        </div>

        <!-- DATE & TIME -->
        <div class="bg-white shadow-sm border rounded-2xl px-5 py-3 text-sm text-gray-600"
             x-data="{ now: new Date(), update() { this.now = new Date() } }"
             x-init="setInterval(() => update(), 1000)">
            <div class="font-medium text-gray-700"
                 x-text="now.toLocaleDateString('id-ID', { weekday:'long', year:'numeric', month:'long', day:'numeric' })">
            </div>
            <div class="text-xs text-gray-500 mt-1"
                 x-text="now.toLocaleTimeString('id-ID')">
            </div>
        </div>
    </div>

    <!-- Total Vendor -->
    <div class="flex items-center gap-3">
        <p class="text-sm text-gray-500 mt-1">Total Vendor</p>
        <div class="text-3xl font-bold text-gray-800">{{ $totalVendor }}</div>
        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-50 text-blue-600">
            👤
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Dokumen -->
        <div class="bg-white rounded-2xl shadow-sm border p-5 border-l-4 border-yellow-500 alert-card">
            <p class="text-sm text-gray-500">Total Dokumen</p>
            <div class="flex items-center justify-between mt-3">
                <h2 class="text-3xl font-bold text-gray-800">{{ $totalDokumen }}</h2>
                <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-50 text-red-600">📄</div>
            </div>
            <div class="flex gap-2 mt-4">
                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">Expired: {{ $dokumenExpired }}</span>
                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">H-30: {{ $dokumenSoon }}</span>
            </div>
        </div>

        <!-- Kontrak -->
        <div class="bg-white rounded-2xl shadow-sm border p-5 border-l-4 border-green-500 alert-card">
            <p class="text-sm text-gray-500">Total Kontrak</p>
            <div class="flex items-center justify-between mt-3">
                <h2 class="text-3xl font-bold text-gray-800">{{ $totalKontrak }}</h2>
                <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-amber-50 text-amber-600">📑</div>
            </div>
            <div class="flex gap-2 mt-4">
                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">Expired: {{ $kontrakExpired }}</span>
                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">H-30: {{ $kontrakSoon }}</span>
            </div>
        </div>

        <!-- Perizinan -->
        <div class="bg-white rounded-2xl shadow-sm border p-5 border-l-4 border-purple-500 alert-card">
            <p class="text-sm text-gray-500">Total Perizinan</p>
            <div class="flex items-center justify-between mt-3">
                <h2 class="text-3xl font-bold text-gray-800">{{ $totalPermit }}</h2>
                <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-purple-50 text-purple-600">🏛️</div>
            </div>
            <div class="flex gap-2 mt-4">
                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">Expired: {{ $permitExpired }}</span>
                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">H-30: {{ $permitSoon }}</span>
            </div>
        </div>

        <!-- Compliance -->
        <div class="bg-white rounded-2xl shadow-sm border p-5 border-l-4 border-red-500 alert-card">
            <p class="text-sm text-gray-500">Total Compliance</p>
            <div class="flex items-center justify-between mt-3">
                <h2 class="text-3xl font-bold text-gray-800">{{ $totalCompliance }}</h2>
                <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">✅</div>
            </div>
            <div class="flex gap-2 mt-4">
                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">Expired: {{ $complianceExpired }}</span>
                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">H-30: {{ $complianceSoon }}</span>
            </div>
        </div>

    </div>


@if($totalAlerts > 0)

<div class="mt-4">
    <button id="stopAlertBtn" class="px-3 py-1 rounded bg-red-500 text-white text-sm">
        Matikan Alert
    </button>
</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    let alertStopped = false;
    const cards = document.querySelectorAll('.alert-card');

    // KELAP KELIP
    let blinkInterval = setInterval(() => {

        if(alertStopped) return;

        cards.forEach(card => {
            card.classList.toggle('bg-red-50');
        });

    },800);

    // AI VOICE
    function speak(text){

        if(alertStopped) return;

        let speech = new SpeechSynthesisUtterance(text);
        speech.lang = "id-ID";
        speech.rate = 1;
        speech.pitch = 1;

        speechSynthesis.speak(speech);
    }

    let delay = 1000;

    @if($criticalDokumen > 0)
        setTimeout(()=>{
            speak("Perhatian. ada {{ $criticalDokumen }} dokumen yang akan berakhir.");
        },delay);
        delay += 4000;
    @endif

    @if($criticalKontrak > 0)
        setTimeout(()=>{
            speak("ada {{ $criticalKontrak }} kontrak yang akan segera berakhir.");
        },delay);
        delay += 4000;
    @endif

    @if($criticalPermit > 0)
        setTimeout(()=>{
            speak("ada {{ $criticalPermit }} perizinan yang akan segera berakhir.");
        },delay);
        delay += 4000;
    @endif

    @if($criticalCompliance > 0)
        setTimeout(()=>{
            speak("ada {{ $criticalCompliance }} komplaiens yang akan segera berakhir.");
        },delay);
    @endif


    // STOP BUTTON
    const stopBtn = document.getElementById('stopAlertBtn');

    if(stopBtn){

        stopBtn.addEventListener('click',function(){

            alertStopped = true;

            speechSynthesis.cancel();

            clearInterval(blinkInterval);

            cards.forEach(card=>{
                card.classList.remove('bg-red-50');
            });

        });

    }

});

</script>

@endif



    <!-- ALERT TABLE -->
    <div class="bg-white shadow-sm rounded-2xl border p-6">
        <h2 class="text-lg font-semibold text-red-600 mb-4">🚨 Legal Alert (H-30 & Expired)</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="py-2">Nama</th>
                        <th>Jenis</th>
                        <th>Tanggal Berakhir</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    {{-- DOKUMEN --}}
                    @foreach($documents as $doc)

                    @php $end = \Carbon\Carbon::parse($doc->tanggal_berakhir); @endphp

                    <tr class="hover:bg-gray-50">

                        <td class="py-3">{{ $doc->nama_dokumen }}</td>
                        <td>Dokumen</td>
                        <td>{{ $end->format('d M Y') }}</td>

                        <td>

                        @if($end->isPast())

                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">
                        Expired
                        </span>

                        @elseif($end->diffInDays(now()) <= 30)

                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                        H-30
                        </span>

                        @else

                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                        Aktif
                        </span>

                        @endif

                        </td>

                    </tr>

                    @endforeach


                    {{-- KONTRAK --}}
                    @foreach($contracts as $kontrak)

                    @php $end = \Carbon\Carbon::parse($kontrak->tanggal_berakhir); @endphp

                    <tr class="hover:bg-gray-50">

                        <td class="py-3">{{ $kontrak->nama_kontrak }}</td>
                        <td>Kontrak</td>
                        <td>{{ $end->format('d M Y') }}</td>

                        <td>

                        @if($end->isPast())

                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">
                        Expired
                        </span>

                        @elseif($end->diffInDays(now()) <= 30)

                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                        H-30
                        </span>

                        @else

                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                        Aktif
                        </span>

                        @endif

                        </td>

                    </tr>

                    @endforeach


                    {{-- PERIZINAN --}}
                    @foreach($permits as $permit)

                    @php $end = \Carbon\Carbon::parse($permit->tanggal_berakhir); @endphp

                    <tr class="hover:bg-gray-50">

                        <td class="py-3">{{ $permit->nama_izin }}</td>
                        <td>Perizinan</td>
                        <td>{{ $end->format('d M Y') }}</td>

                        <td>

                        @if($end->isPast())

                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">
                        Expired
                        </span>

                        @elseif($end->diffInDays(now()) <= 30)

                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                        H-30
                        </span>

                        @else

                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                        Aktif
                        </span>
                        @endif

 </td>
  </tr>

                    @endforeach


                    {{-- COMPLIANCE --}}
                    @foreach($compliances as $comp)
                    @php $end = \Carbon\Carbon::parse($comp->tanggal_berakhir); @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="py-3">{{ $comp->nama_compliance }}</td>
                        <td>Compliance</td>
                        <td>{{ $end->format('d M Y') }}</td>

                        <td>
                        @if($end->isPast())
                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">
                        Expired
                        </span>

                        @elseif($end->diffInDays(now()) <= 30)

                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">H-30  </span>
                        @else
                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                        Aktif
                        </span>
                        @endif
                        </td>
                    </tr>
                    @endforeach

                    {{-- EMPTY STATE --}}
                    @if($documents->isEmpty() && $contracts->isEmpty() && $permits->isEmpty() && $compliances->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-400">
                            Tidak ada dokumen yang mendekati masa berakhir 🎉
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection