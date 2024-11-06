@extends('layouts.main')
@section('container')
    <div class="rounded-lg bg-white p-6 shadow-lg">
        <div class="mb-4 flex items-center">
            <div class="flex-1">
                <h2 class="text-2xl font-bold">NAMA KLINIK</h2>
                <p class="text-gray-600">Tanggal : 19 September 2024</p>
            </div>
            <div class="flex flex-1 items-center justify-center">
                <label for="lpb" class="mr-2 text-lg font-normal text-black">No. Transaksi :</label>
                <input
                    type="text"
                    id="lpb"
                    class="mr-2 border-b border-gray-300 focus:border-gray-500 focus:outline-none"
                />
            </div>
            <div class="flex flex-1 justify-end">
                <a href="#" id="printButton" class="rounded-lg bg-yellow-400 px-4 py-2 font-bold text-black">CETAK</a>
            </div>
        </div>
        <div id="printOptions" class="mb-4 hidden">
            <label for="format" class="text-lg font-semibold">Pilih format cetak:</label>
            <select id="format" class="ml-2 rounded-md border">
                <option value="pdf">PDF</option>
                <option value="excel">Excel</option>
            </select>
            <button id="confirmPrint" class="ml-2 rounded-lg bg-green-500 px-4 py-2 font-bold text-white">
                Download
            </button>
        </div>

        <h1 class="text-center text-3xl font-bold">INVOICE CHECKOUT</h1>
        <!-- Table -->
        <div class="overflow-hidden rounded-lg bg-white p-6 shadow-md">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-200 text-sm uppercase leading-normal text-black">
                        <th class="border p-2">No</th>
                        <th class="border p-2">Nama Obat</th>
                        <th class="border p-2">Jumlah</th>
                        <th class="border p-2">Harga Satuan</th>
                        <th class="border p-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-light text-gray-700">
                    @for ($i = 1; $i < 8; $i++)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-6 py-3 text-center">{{ $i }}</td>
                            <td class="px-6 py-3 text-center">Obat {{ $i }}</td>
                            <td class="px-6 py-3 text-center">10</td>
                            <td class="px-6 py-3 text-center">Rp 10.000</td>
                            <td class="px-6 py-3 text-center">Rp 100.000</td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex items-center justify-end">
            <p class="mr-2 font-semibold">Grand total :</p>
            <input
                type="text"
                value="Rp 750.000"
                class="w-48 border-b border-gray-400 text-center focus:border-black focus:outline-none"
                readonly
            />
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Event listener untuk tombol CETAK
            document.getElementById('printButton').addEventListener('click', function () {
                const printOptions = document.getElementById('printOptions');
                // Toggle opsi cetak: sembunyikan atau tampilkan
                if (printOptions.classList.contains('hidden')) {
                    printOptions.classList.remove('hidden');
                } else {
                    printOptions.classList.add('hidden');
                }
            });

            // Event listener untuk tombol konfirmasi cetak
            document.getElementById('confirmPrint').addEventListener('click', function () {
                const format = document.getElementById('format').value;
                if (format === 'pdf') {
                    alert('Mencetak dalam format PDF...');
                } else if (format === 'excel') {
                    alert('Mencetak dalam format Excel...');
                }
                document.getElementById('printOptions').classList.add('hidden');
            });
        });
    </script>
@endsection
