@extends('layouts.app')

@section('content')
<div class="p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Request Barang</h1>

        <a href="{{ route('ga.requests.create') }}"
           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            + Request
        </a>
    </div>

    @if(session('success'))
        <div class="mb-3 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE -->
    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="w-full text-sm">

            <!-- HEADER TABLE -->
            <thead class="bg-gray-300 text-gray-700 text-xs uppercase tracking-wide">
                <tr>
                    <th class="p-4 text-left">Kode</th>
                    <th class="p-4 text-left">Barang</th>
                    <th class="p-4 text-left">Qty</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Tanggal</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <!-- BODY -->
            <tbody>
                @forelse($requests as $r)
                <tr class="border-t hover:bg-gray-50">

                    <td class="p-4 font-medium text-gray-800">
                        {{ $r->request_code }}
                    </td>

                    <td class="p-4">
                        {{ $r->item_name }}
                    </td>

                    <td class="p-4">
                        {{ $r->qty }}
                    </td>

                    <!-- STATUS BADGE -->
                    <td class="p-4">
                        @if($r->status == 'pending')
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs">Pending</span>
                        @elseif($r->status == 'approved')
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">Approved</span>
                        @elseif($r->status == 'rejected')
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">Rejected</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Done</span>
                        @endif
                    </td>

                    <td class="p-4 text-gray-600">
                        {{ \Carbon\Carbon::parse($r->request_date)->format('d M Y') }}
                    </td>

                    <!-- AKSI -->
                    <td class="p-4 text-center space-x-2">
                        <a href="{{ route('ga.requests.show', $r->id) }}"
                           class="text-blue-600 hover:underline">
                            Detail
                        </a>

                        <a href="{{ route('ga.requests.edit', $r->id) }}"
                           class="text-yellow-600 hover:underline">
                            Edit
                        </a>

                        <form action="{{ route('ga.requests.destroy', $r->id) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Hapus data?')"
                                class="text-red-600 hover:underline">
                                Hapus
                            </button>
                        </form>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center p-6 text-gray-500">
                        Belum ada request barang
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $requests->links() }}
    </div>

</div>
@endsection