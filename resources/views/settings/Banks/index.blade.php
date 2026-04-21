@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-3">
    <h1 class="text-lg font-semibold">Bank</h1>
    <a href="{{ route('settings.banks.create') }}"
       class="px-3 py-1.5 text-sm bg-green-600 text-white rounded hover:bg-green-700">
        + Tambah Bank
    </a>
</div>

<div class="overflow-x-auto bg-white shadow rounded">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-3 py-2 text-left font-medium text-gray-500 w-12">No</th>
                <th class="px-3 py-2 text-left font-medium text-gray-500">Nama Bank</th>
                <th class="px-3 py-2 text-left font-medium text-gray-500">Kode Bank</th>
                <th class="px-3 py-2 text-left font-medium text-gray-500 w-32">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200">
            @forelse($banks as $index => $bank)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-1.5">{{ $index + 1 }}</td>
                    <td class="px-3 py-1.5">{{ $bank->bank_name }}</td>
                    <td class="px-3 py-1.5">{{ $bank->bank_code ?? '-' }}</td>
                    <td class="px-3 py-1.5">
                        <form action="{{ route('settings.banks.destroy', $bank) }}"
                              method="POST"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button
                                onclick="return confirm('Yakin mau hapus?')"
                                class="px-2 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-3 py-3 text-center text-gray-500">
                        Belum ada data bank
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
