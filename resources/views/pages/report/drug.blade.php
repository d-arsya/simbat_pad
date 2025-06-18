@php
use Carbon\Carbon;
@endphp
@extends('layouts.main')
@section('container')
<div class="rounded-lg bg-white p-6 shadow-lg">
    <div class="flex flex-1 justify-end mb-5">
        <button id="printButton" onclick="printModal()" class="rounded-lg bg-yellow-500 hover:bg-yellow-600 px-4 py-1 text-white">Cetak</button>
    </div>
    <div class="flex items-center justify-between w-full">
        <form action="" class="flex w-auto flex-row justify-between gap-3 ">
            <input class="rounded-sm px-2 py-1 ring-2 ring-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500" type="date" name="" id="" />
            <h1 class="text-lg font-inter text-gray-800">sampai</h1>
            <input class="rounded-sm px-2 py-1 ring-2 ring-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500" type="date" name="" id="" />
            <button class="rounded-2xl bg-blue-500 px-3 font-bold text-sm font-inter text-white hover:bg-blue-600"
                type="submit">
                TERAPKAN
            </button>
        </form>
        <form action="" class="flex">
            <input type="text" name="" id="bill-search" placeholder="Search..."
                class="rounded-full px-6 py-2 ring-2 ring-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </form>
    </div>

    <div class="overflow-hidden rounded-lg bg-white shadow-md mt-6">
        <table class="min-w-full text-sm text-center">
            <thead class="bg-gray-200">
                <th class="py-4">No</th>
                <th class="py-4">Kode Obat</th>
                <th class="py-4">Nama Obat</th>
                <th class="py-4">Stok</th>
                <th class="py-4">Expired Terdekat</th>
                <th class="py-4">Expired Terbaru</th>
                <th class="py-4">Action</th>
            </thead>
            <tbody id="tbody">

            </tbody>
        </table>
    </div>
     <!-- Pagination and Showing Info Section -->
        <div class="flex items-center justify-between p-4">
            <div>
                <p class="text-gray-700 text-sm" id="pagination-info">
                    Showing 0 to 0 of 0 results
                </p>
            </div>
            <div id="pagination-div">
                {{-- Pagination will be populated by JavaScript --}}
            </div>
        </div>
</div>
<div id="printModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96 relative">
        <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600"
            onclick="closePrintModal()">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
            </svg>
            <span class="sr-only">Close modal</span>
        </button>
        <div class="text-center">
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Apa format file yang ingin Anda simpan?</h3>
            <p class="text-sm text-gray-500 mb-5">Pilihlah salah satu format file!</p>
        </div>
        <div class="flex justify-center space-x-4">
            <button onclick="exportToExcel()"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white focus:outline-none">
                Excel
            </button>
            <button onclick="submitModal()" type="button"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white focus:outline-none">
                PDF
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const token = window.API_TOKEN;
        const per_page = 5;
        let currentPage = 1;
        let searchQuery = '';
        let dateFrom = '';
        let dateTo = '';
        let drugId = null

        if (token) {
            console.log('Token found:', token);
            fetchStocks();
        } else {
            console.error('API token not found');
        }

        // Event listeners
        document.getElementById('bill-search').addEventListener('input', handleSearchInput);
        document.querySelector('form').addEventListener('submit', handleDateFilter);

        function fetchStocks(page = 1) {
            currentPage = page;

            const params = new URLSearchParams({
                per_page: per_page,
                page: page,
                search: searchQuery
            });

            if (dateFrom) params.append('date_from', dateFrom);
            if (dateTo) params.append('date_to', dateTo);

            axios.get(`/api/v1/reports/drugs?${params.toString()}`, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                if (!response.data) {
                    throw new Error('Empty response from server');
                }
                console.log('Stocks data:', response.data);
                renderStockTable(response.data);
                updatePaginationInfo(response.data);
            })
            .catch(error => {
                console.error('Failed to fetch stocks:', error);
                showErrorMessage('Gagal memuat data stok');
                document.querySelector('tbody').innerHTML = '<tr><td colspan="7" class="py-4 text-center text-gray-500">Gagal memuat data</td></tr>';
                document.getElementById('pagination-info').textContent = 'Showing 0 to 0 of 0 results';
                document.getElementById('pagination-div').innerHTML = '';
            });
        }

        window.fetchStocks = fetchStocks;

        function handleSearchInput(e) {
            searchQuery = e.target.value;
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                fetchStocks(1);
            }, 400);
        }

        function handleDateFilter(e) {
            e.preventDefault();
            dateFrom = e.target.querySelector('input[type="date"]:first-of-type').value;
            dateTo = e.target.querySelector('input[type="date"]:last-of-type').value;

            if (dateFrom && dateTo && dateFrom > dateTo) {
                showErrorMessage('Tanggal awal tidak boleh lebih besar dari tanggal akhir');
                return;
            }

            fetchStocks(1);
        }

        function renderStockTable(responseData) {
            const tbody = document.querySelector('tbody');
            tbody.innerHTML = '';

            if (!responseData || !responseData.data) {
                console.error('Invalid response data:', responseData);
                showErrorMessage('Data tidak valid diterima dari server');
                return;
            }

            const dataItems = responseData.data;
            const totalItems = dataItems.length;
            const startIndex = (currentPage - 1) * per_page;

            if (!Array.isArray(dataItems)) {
                console.error('Expected array of items in response.data:', dataItems);
                showErrorMessage('Format data tidak valid');
                return;
            }

            dataItems.forEach((item, index) => {
                const rowNumber = startIndex + index + 1;

                const row = document.createElement('tr');
                row.className = 'border-b border-gray-200 hover:bg-gray-100';

                // Menjadi:
row.innerHTML = `
    <td class="py-3">${rowNumber}</td>
    <td class="py-3">${item.drug_code || '-'}</td>
    <td class="py-3">${item.drug_name || '-'}</td>
    <td class="py-3">${item.quantity || 0} pcs</td>
    <td class="py-3">${item.oldest_expired || '-'}</td>
    <td class="py-3">${item.latest_expired || '-'}</td>
    <td class="flex justify-center py-3">
        <a href="/report/drug/${item.id}"
           class="rounded-md bg-blue-500 p-2 hover:bg-blue-600 transition-colors duration-200 inline-block">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.99972 2.5C14.4931 2.5 18.2314 5.73333 19.0156 10C18.2322 14.2667 14.4931 17.5 9.99972 17.5C5.50639 17.5 1.76805 14.2667 0.983887 10C1.76722 5.73333 5.50639 2.5 9.99972 2.5ZM9.99972 15.8333C11.6993 15.833 13.3484 15.2557 14.6771 14.196C16.0058 13.1363 16.9355 11.6569 17.3139 10C16.9341 8.34442 16.0038 6.86667 14.6752 5.80835C13.3466 4.75004 11.6983 4.17377 9.99972 4.17377C8.30113 4.17377 6.65279 4.75004 5.3242 5.80835C3.9956 6.86667 3.06536 8.34442 2.68555 10C3.06397 11.6569 3.99361 13.1363 5.32234 14.196C6.65106 15.2557 8.30016 15.833 9.99972 15.8333V15.8333ZM9.99972 13.75C9.00516 13.75 8.05133 13.3549 7.34807 12.6516C6.64481 11.9484 6.24972 10.9946 6.24972 10C6.24972 9.00544 6.64481 8.05161 7.34807 7.34835C8.05133 6.64509 9.00516 6.25 9.99972 6.25C10.9943 6.25 11.9481 6.64509 12.6514 7.34835C13.3546 8.05161 13.7497 9.00544 13.7497 10C13.7497 10.9946 13.3546 11.9484 12.6514 12.6516C11.9481 13.3549 10.9943 13.75 9.99972 13.75ZM9.99972 12.0833C10.5523 12.0833 11.0822 11.8638 11.4729 11.4731C11.8636 11.0824 12.0831 10.5525 12.0831 10C12.0831 9.44747 11.8636 8.91756 11.4729 8.52686C11.0822 8.13616 10.5523 7.91667 9.99972 7.91667C9.44719 7.91667 8.91728 8.13616 8.52658 8.52686C8.13588 8.91756 7.91639 9.44747 7.91639 10C7.91639 10.5525 8.13588 11.0824 8.52658 11.4731C8.91728 11.8638 9.44719 12.0833 9.99972 12.0833Z" fill="white"/>
            </svg>
        </a>
    </td>
`;
                tbody.appendChild(row);
            });

            renderPagination(responseData);
        }

        function updatePaginationInfo(responseData) {
            if (!responseData) {
                console.error('Invalid response data for pagination:', responseData);
                return;
            }

            const start = ((currentPage - 1) * per_page) + 1;
            const end = Math.min(currentPage * per_page, responseData.data.length);
            const total = responseData.data.length;

            document.getElementById('pagination-info').textContent =
                `Showing ${start} to ${end} of ${total} results`;
        }

        function renderPagination(responseData) {
            if (!responseData) return;

            const totalItems = responseData.data.length;
            const totalPages = Math.ceil(totalItems / per_page);

            let paginationHTML = '<nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">';

            // Previous button
            paginationHTML += `
                <span onclick="${currentPage === 1 ? '' : `fetchStocks(${currentPage - 1})`}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium
                    ${currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                    bg-white border border-gray-300 rounded-l-md leading-5">
                    &lsaquo;
                </span>
            `;

            // Page buttons
            for (let i = 1; i <= totalPages; i++) {
                paginationHTML += `
                    <span onclick="fetchStocks(${i})"
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                        ${i === currentPage ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}
                        border border-gray-300 leading-5">
                        ${i}
                    </span>
                `;
            }

            // Next button
            paginationHTML += `
                <span onclick="${currentPage === totalPages ? '' : `fetchStocks(${currentPage + 1})`}"
                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                    ${currentPage === totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                    bg-white border border-gray-300 rounded-r-md leading-5">
                    &rsaquo;
                </span>
            `;

            paginationHTML += '</nav>';
            document.getElementById("pagination-div").innerHTML = paginationHTML;
        }

        function showErrorMessage(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded shadow-lg z-50';
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        function showSuccessMessage(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50';
            toast.textContent = message;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        function printModal() {
            document.getElementById('printModal').classList.remove('hidden');
        }

        function closePrintModal() {
            document.getElementById('printModal').classList.add('hidden');
        }

        function exportToExcel() {
            closePrintModal();
            let exportUrl = '/export-excel';
            const params = new URLSearchParams();

            if (searchQuery) params.append('search', searchQuery);
            if (dateFrom) params.append('date_from', dateFrom);
            if (dateTo) params.append('date_to', dateTo);

            if (params.toString()) {
                exportUrl += '?' + params.toString();
            }

            window.location.href = exportUrl;
            showSuccessMessage('Mengunduh file Excel...');
        }

        function exportToPDF() {
            closePrintModal();
            let exportUrl = '/export-pdf';
            const params = new URLSearchParams();

            if (searchQuery) params.append('search', searchQuery);
            if (dateFrom) params.append('date_from', dateFrom);
            if (dateTo) params.append('date_to', dateTo);

            if (params.toString()) {
                exportUrl += '?' + params.toString();
            }

            window.location.href = exportUrl;
            showSuccessMessage('Mengunduh file PDF...');
        }

        function submitModal() {
            exportToPDF();
        }

        // Fixed viewStockDetail function
       // Hapus ini:
window.viewStockDetail = function(id) {
    window.drugId = id;
    if (!drugId || drugId === 'undefined') {
        console.error('Invalid drug ID:', drugId);
        showErrorMessage('ID obat tidak valid');
        return;
    }
    console.log('Navigating to drug detail with ID:', drugId);
    window.location.href = `/report/drug/${id}`;
};
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.getElementById('printModal').classList.add('hidden');
        }
        if (event.ctrlKey && event.key === 'p') {
            event.preventDefault();
            document.getElementById('printModal').classList.remove('hidden');
        }
    });

    document.getElementById('printModal')?.addEventListener('click', function(event) {
        if (event.target === this) {
            this.classList.add('hidden');
        }
    });
</script>
@endsection
