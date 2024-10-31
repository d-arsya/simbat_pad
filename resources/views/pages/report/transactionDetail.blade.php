@extends('layouts.main')
@section('container')
<div class="p-6 bg-white rounded-lg shadow-lg">
    <div class="flex items-center mb-4">
        <div class="flex-1">
            <h2 class="text-2xl font-bold">NAMA KLINIK</h2>
            <p class="text-gray-600">Tanggal : 19 September 2024</p>
        </div>
        <div class="flex items-center justify-center flex-1">
            <label for="lpb" class="text-black text-lg font-normal mr-2">No. LPB :</label>
            <input type="text" id="lpb" class="border-b border-gray-300 focus:outline-none focus:border-gray-500 mr-2">
        </div>
        <div class="flex-1 justify-end flex">
            <button id="printButton" class="bg-yellow-400 text-black font-bold py-2 px-4 rounded-lg">CETAK</button>
        </div>
    </div>
    <div id="printOptions" class="hidden mb-4">
        <label for="format" class="text-lg font-semibold">Pilih format cetak:</label>
        <select id="format" class="ml-2 border rounded-md">
            <option value="pdf">PDF</option>
            <option value="excel">Excel</option>
        </select>
        <button id="confirmPrint" class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg ml-2">Download</button>
    </div>

    <h1 class="text-center text-3xl font-bold">LAPORAN PENERIMAAN BARANG</h1>
    <p class="font-semibold mb-2">Diterima</p>
     <!-- Table -->
     <div class="bg-white shadow-md rounded-lg p-6 overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                    <tr class="bg-gray-200 text-black uppercase text-sm leading-normal">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Kode Obat</th>
                        <th class="border p-2">Nama Obat</th>
                        <th class="border p-2">Jumlah</th>
                        <th class="border p-2">Harga Satuan</th>
                        <th class="border p-2">Subtotal</th>
                    </tr>
            </thead>
            <tbody class="text-gray-700 text-sm font-light">
                @for ($i = 1; $i < 8; $i++)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-center">{{ $i }}</td>
                    <td class="py-3 px-6 text-center">#AAA111</td>
                    <td class="py-3 px-6 text-center">Obat 1</td>
                    <td class="py-3 px-6 text-center">10</td>
                    <td class="py-3 px-6 text-center">Rp 10.000</td>
                    <td class="py-3 px-6 text-center">Rp 100.000</td>
                </tr>

                @endfor
            </tbody>
        </table>
    </div>
        <div class="flex justify-end items-center mt-4">
            <p class="font-semibold mr-2">Grand total :</p>
            <input type="text" value="Rp 750.000" class="border-b border-gray-400 focus:outline-none focus:border-black text-center w-48" readonly>
        </div>
    </div>
<script>
    document.getElementById('printButton').onclick = function() {
        document.getElementById('printOptions').classList.toggle('hidden');
    };
    document.getElementById('confirmPrint').onclick = function() {
        const format = document.getElementById('format').value;
        if (format === 'pdf') {
            alert("Mencetak dalam format PDF...");
        } else if (format === 'excel') {
            alert("Mencetak dalam format Excel...");
        }
        document.getElementById('printOptions').classList.add('hidden');
    };
</script>
@endsection
