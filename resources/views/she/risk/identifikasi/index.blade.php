@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- ================= HEADER ================= --}}
    <div class="mb-8">
        <p class="text-gray-500">
            Identifikasi Risiko
        </p>
    </div>

    {{-- ================= CARD CONTAINER ================= --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

        <div x-data="{ tab: 'she' }">

            {{-- ================= TAB BUTTON ================= --}}
            <div class="flex border-b mb-6">
                <button
                    @click="tab='she'"
                    :class="tab==='she'
                        ? 'border-indigo-600 text-indigo-600'
                        : 'border-transparent text-gray-500 hover:text-indigo-600'"
                    class="px-6 py-3 border-b-2 font-semibold transition">
                    Risiko SHE
                </button>

                <button
                    @click="tab='bencana'"
                    :class="tab==='bencana'
                        ? 'border-indigo-600 text-indigo-600'
                        : 'border-transparent text-gray-500 hover:text-indigo-600'"
                    class="px-6 py-3 border-b-2 font-semibold transition">
                    Risiko Bencana Alam
                </button>
            </div>

            {{-- ================= TAB SHE ================= --}}
            <div x-show="tab==='she'" x-transition>

                @include('she.risk.identifikasi.partials.table', [
                    'data' => $risks->whereIn('kategori', ['Safety','Health','Environment'])
                ])

            </div>

            {{-- ================= TAB BENCANA ================= --}}
            <div x-show="tab==='bencana'" x-transition>

                @include('she.risk.identifikasi.partials.table', [
                    'data' => $risks->whereIn('kategori', ['Bencana Alam','Tsunami','Gempa'])
                ])

            </div>

        </div>
    </div>
</div>
@endsection