@extends('base')
@section('title','Pegawai')
@section('menupegawai', 'underline decoration-4 underline-offset-7')
@section('content')
    <section class="p-4 bg-white rounded-lg min-h-[50vh]">
        <h1 class="text-3xl font-bold text-[#C0392B] mb-6 text-center">Daftar Pegawai</h1>
        <div class="mx-auto max-w-screen-xl">
            @if(session('success'))
                <div id="alert-success" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 border border-green-200" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div class="ms-3 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-success" aria-label="Close" onclick="this.parentElement.style.display='none'">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endif
            <div class="mb-4">
                <a href="{{ route('pegawai.add') }}" class="rounded-md bg-green-600 px-4 py-2 text-sm text-white hover:bg-green-700">
                    Tambah Pegawai
                </a>
            </div>
            
            {{-- Tabel Data --}}
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-x divide-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">No</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Nama</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Pekerjaan</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Email</th>
                            <th class="px-4 py-3 text-left font-semibold text-gray-700">Gender</th>
                            <th class="px-4 py-3 text-center font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($data as $k => $d)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $d->nama }}</td>
                            {{-- Relasi Pekerjaan muncul disini --}}
                            <td class="px-4 py-3 text-blue-600 font-medium">
                                {{ $d->pekerjaan ? $d->pekerjaan->nama : 'Tidak ada' }}
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $d->email }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $d->gender }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('pegawai.edit', $d->id) }}" class="text-blue-600 hover:underline">Edit</a> | 
                                <form action="{{ route('pegawai.destroy', ['id'=>$d->id]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 flex justify-between items-center">
                    {{-- Tombol Previous --}}
                    @if ($data->onFirstPage())
                        <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                            &laquo; Previous
                        </span>
                    @else
                        <a href="{{ $data->previousPageUrl() }}" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            &laquo; Previous
                        </a>
                    @endif

                    {{-- Info Halaman --}}
                    <span class="text-sm text-gray-600">
                        Halaman {{ $data->currentPage() }}
                    </span>

                    {{-- Tombol Next --}}
                    @if ($data->hasMorePages())
                        <a href="{{ $data->nextPageUrl() }}" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Next &raquo;
                        </a>
                    @else
                        <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-md cursor-not-allowed">
                            Next &raquo;
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection