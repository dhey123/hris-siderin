@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto space-y-6">

    <h1 class="text-2xl font-bold">Edit Dokumen Legal</h1>

    <div class="bg-white p-6 rounded-xl shadow">
        <form action="{{ route('legal.documents.update',$document->id) }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf
            @method('PUT')

            @include('legal.documents.form')

            <div class="flex justify-end gap-3">
                <a href="{{ route('legal.documents.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded">Batal</a>

                <button class="px-6 py-2 bg-blue-600 text-white rounded">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection