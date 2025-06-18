@php
    use Carbon\Carbon;
@endphp
@extends('layouts.main')

@section('container')
    <div class="max-w-8xl w-full rounded-xl bg-white p-6 shadow-md">
        <div class="flex items-center justify-between w-full">
            <form action="" class="flex w-auto flex-row justify-between gap-3">
                <input class="rounded-sm px-2 py-1 ring-2 ring-gray-500" type="date" name="start"
                    value="{{ $_GET['start'] ?? '' }}" />
                <h1 class="text-lg font-inter text-gray-800">sampai</h1>
                <input class="rounded-sm px-2 py-1 ring-2 ring-gray-500" type="date" name="end"
                    value="{{ $_GET['end'] ?? '' }}" />
                <button class="rounded-2xl bg-blue-500 px-3 font-bold text-sm font-inter text-white hover:bg-blue-600"
                    type="submit">
                    TERAPKAN
                </button>
            </form>
            <form action="" class="flex">
                <input type="text" name="bill-search" id="bill-search" placeholder="Search..."
                    class="rounded-full px-6 py-2 ring-2 ring-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </form>
        </div>
        <div class="overflow-hidden rounded-lg bg-white shadow-md mt-6">
            <table class="min-w-full text-sm text-center">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 w-1">No</th>
                        <th class="px-4">Kode LPB</th>
                        <th class="px-4">Tanggal Datang</th>
                        <th class="px-4">Jatuh Tempo</th>
                        <th class="px-4">Tanggal Pembayaran</th>
                        <th class="px-4">Subtotal</th>
                        <th class="px-4">Status</th>
                        <th class="px-4 w-1">Action</th>
                    </tr>
                </thead>
                <tbody id="bill-data">
                    @foreach ($bills as $number => $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3">{{ $number + 1 + (($bills->currentPage() - 1) * $bills->perPage()) }}</td>
                            <td>{{ $item->transaction()->code }}</td>
                            <td>{{ Carbon::parse($item->created_at)->translatedFormat('j F Y') }}</td>
                            <td>{{ Carbon::parse($item->due)->translatedFormat('j F Y') }}</td>
                            <td>{{ $item->pay ? Carbon::parse($item->pay)->translatedFormat('j F Y') : '-' }}</td>
                            <td>{{ 'Rp ' . number_format($item->total, 0, ',', '.') }}</td>
                            @if ($item->status == 'Belum Bayar')
                                <td>
                                    <span class="bg-orange-500 text-white py-1 px-3 text-left rounded-full">Belum Bayar</span>
                                </td>
                            @else
                                <td>
                                    <span class="bg-green-500 text-white py-1 px-3 text-left rounded-full">Done</span>
                                </td>
                            @endif
                            <td class="flex justify-center items-center py-3">
                                <a href="{{ route('management.bill.show', $item->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 p-2 rounded-md flex justify-center items-center">
                                    @include('icons.mata')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Updated pagination container -->
        <div class="flex items-center justify-between p-4">
            <div>
                <p class="text-gray-700 text-sm">
                    Showing {{ $bills->firstItem() }} to {{ $bills->lastItem() }} of {{ $bills->total() }} results
                </p>
            </div>
            <div class="pagination">
                {{ $bills->onEachSide(1)->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const token = window.API_TOKEN;
            const searchInput = document.getElementById("bill-search");

            if (!token) {
                console.error('API token not found');
                window.location.href = '/login';
                return;
            }

            // Event listeners
            searchInput.addEventListener('input', handleSearchInput);
            document.querySelector('form[action=""]')?.addEventListener('submit', handleDateFilter);

            function handleSearchInput(e) {
                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    window.location.href = `?search=${e.target.value}`;
                }, 400);
            }

            function handleDateFilter(e) {
                e.preventDefault();
                const startDate = e.target.querySelector('input[name="start"]').value;
                const endDate = e.target.querySelector('input[name="end"]').value;
                window.location.href = `?start=${startDate}&end=${endDate}`;
            }
        });
    </script>
@endsection
