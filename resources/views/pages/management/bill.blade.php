@extends('layouts.main')
@section('container')
<div class="bg-white shadow-md rounded-xl p-6 w-full max-w-8xl">
    <div class="mb-4">
        <input type="text" placeholder="Masukkan nama vendor" class="w-1/3 p-2 border border-gray-300 rounded">
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="w-full bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">NO</th>
                    <th class="py-3 px-6 text-left">KODE LPB</th>
                    <th class="py-3 px-6 text-left">TANGGAL DATANG</th>
                    <th class="py-3 px-6 text-left">JATUH TEMPO</th>
                    <th class="py-3 px-6 text-left">SUBTOTAL</th>
                    <th class="py-3 px-6 text-left">STATUS</th>
                    <th class="py-3 px-6 text-left">ACTION</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">1</td>
                    <td class="py-3 px-6 text-left">#AAA111</td>
                    <td class="py-3 px-6 text-left">01-02-2024</td>
                    <td class="py-3 px-6 text-left">14-02-2024</td>
                    <td class="py-3 px-6 text-left">RP1.000.000</td>
                    <td class="py-3 px-6 text-left">
                        <span class="bg-orange-500 text-white py-1 px-3 rounded-full text-xs">BELUM BAYAR</span>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <a href="{{ route('management.bill.show',1) }}">
                            <button class="bg-blue-100 text-blue-500 p-2 rounded-full">
                                <i class="fas fa-eye"></i>
                                <img src="{{ asset('assets/Vector Eyes.png') }}" alt="Lihat" class="w-6 h-6">
                            </button>
                        </a>
                    </td>
                </tr>
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left">2</td>
                    <td class="py-3 px-6 text-left">#AAA222</td>
                    <td class="py-3 px-6 text-left">01-02-2024</td>
                    <td class="py-3 px-6 text-left">14-02-2024</td>
                    <td class="py-3 px-6 text-left">RP1.000.000</td>
                    <td class="py-3 px-6 text-left">
                        <span class="text-green-500 font-bold">D O N E</span>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <a href="{{ route('management.bill.show',2) }}">
                            <button class="bg-blue-100 text-blue-500 p-2 rounded-full">
                                <i class="fas fa-eye"></i>
                                <img src="{{ asset('assets/Vector Eyes.png') }}" alt="Lihat" class="w-6 h-6">
                            </button>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="flex justify-end items-center mt-4">
        <div class="flex items-center">
            <button class="bg-gray-200 text-gray-600 py-1 px-3 rounded-l">‹</button>
            <button class="bg-blue-500 text-white py-1 px-3">1</button>
            <button class="bg-gray-200 text-gray-600 py-1 px-3">2</button>
            <button class="bg-gray-200 text-gray-600 py-1 px-3">...</button>
            <button class="bg-gray-200 text-gray-600 py-1 px-3">9</button>
            <button class="bg-gray-200 text-gray-600 py-1 px-3">10</button>
            <button class="bg-gray-200 text-gray-600 py-1 px-3 rounded-r">›</button>
        </div>
    </div>
</div>
@endsection
