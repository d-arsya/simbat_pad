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
                <input type="text" name="" id="retur-search" placeholder="Search..."
                    class="rounded-full px-6 py-2 ring-2 ring-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </form>
        </div>
        <div class="overflow-hidden rounded-lg bg-white shadow-md mt-6">
            <table class="min-w-full text-sm text-center">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Kode Retur</th>
                        <th class="px-6 py-3">Nama Obat</th>
                        <th class="px-6 py-3">Jumlah</th>
                        <th class="px-6 py-3">Tanggal Retur</th>
                        <th class="px-6 py-3">Tanggal Kembali</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody id="drug-data">
                    {{-- Data will be populated by JavaScript --}}
                </tbody>
            </table>
        </div>
        <!-- Updated pagination container to match the example -->
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

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const token = window.API_TOKEN;
            const per_page = 5;
            let currentPage = 1;
            let searchQuery = '';
            let startDate = '';
            let endDate = '';

            if (!token) {
                console.error('API token not found');
                window.location.href = '/login';
                return;
            }

            // DOM Elements
            const paginationInfo = document.getElementById('pagination-info');
            const paginationDiv = document.getElementById('pagination-div');
            const tbody = document.getElementById("drug-data");

            if (!paginationInfo || !paginationDiv || !tbody) {
                console.error('Required elements not found');
                return;
            }

            // Event listeners
            document.getElementById('retur-search')?.addEventListener('input', handleSearchInput);
            document.querySelector('form[action=""]')?.addEventListener('submit', handleDateFilter);

            // Initial load
            fetchReturs();

            function fetchReturs(page = 1) {
                currentPage = page;
                let url = `/api/v1/management/returns?per_page=${per_page}&page=${page}&search=${searchQuery}`;

                if (startDate && endDate) {
                    url += `&start=${startDate}&end=${endDate}`;
                }

                axios.get(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => {
                    console.log('Retur data:', response.data);
                    if (response.data?.data?.returns) {
                        renderReturTable(response.data.data);
                        updatePaginationInfo(response.data.data.pagination);
                    } else {
                        console.error('Invalid data structure:', response.data);
                        tbody.innerHTML = '<tr><td colspan="7" class="px-6 py-3">No data found</td></tr>';
                    }
                })
                .catch(error => {
                    console.error('Failed to fetch returs:', error);
                    tbody.innerHTML = '<tr><td colspan="7" class="px-6 py-3">Error loading data</td></tr>';
                    if (error.response?.status === 401) {
                        window.location.href = '/login';
                    }
                });
            }

            function handleSearchInput(e) {
                searchQuery = e.target.value;
                clearTimeout(this.timeout);
                this.timeout = setTimeout(() => {
                    fetchReturs(1);
                }, 400);
            }

            function handleDateFilter(e) {
                e.preventDefault();
                startDate = e.target.querySelector('input[name="start"]').value;
                endDate = e.target.querySelector('input[name="end"]').value;
                fetchReturs(1);
            }

            function formatDate(dateString) {
                if (!dateString) return '-';
                try {
                    const options = { day: 'numeric', month: 'long', year: 'numeric' };
                    return new Date(dateString).toLocaleDateString('id-ID', options);
                } catch (e) {
                    console.error('Invalid date:', dateString);
                    return '-';
                }
            }

            function renderReturTable(data) {
                tbody.innerHTML = "";

                if (!data.returns || data.returns.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="7" class="px-6 py-3">No returns found</td></tr>';
                    return;
                }

                data.returns.forEach((item, index) => {
                    const row = document.createElement("tr");
                    row.className = "border-b border-gray-200 hover:bg-gray-100";

                    const rowNumber = index + 1 + ((data.pagination.current_page - 1) * per_page);

                    row.innerHTML = `
                        <td class="px-6 py-3">${rowNumber}</td>
                        <td class="px-6 py-3">${item.code || '-'}</td>
                        <td class="px-6 py-3 text-left">${item.drug_name || '-'}</td>
                        <td class="px-6 py-3">${item.quantity || '-'}</td>
                        <td class="px-6 py-3">${formatDate(item.return_date)}</td>
                        <td class="px-6 py-3">${formatDate(item.arrive_date)}</td>
                        <td class="flex justify-center py-3">
                            <a href="/management/retur/${item.id}" class="rounded-md bg-blue-500 p-2 hover:bg-blue-600">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.99972 2.5C14.4931 2.5 18.2314 5.73333 19.0156 10C18.2322 14.2667 14.4931 17.5 9.99972 17.5C5.50639 17.5 1.76805 14.2667 0.983887 10C1.76722 5.73333 5.50639 2.5 9.99972 2.5ZM9.99972 15.8333C11.6993 15.833 13.3484 15.2557 14.6771 14.196C16.0058 13.1363 16.9355 11.6569 17.3139 10C16.9341 8.34442 16.0038 6.86667 14.6752 5.80835C13.3466 4.75004 11.6983 4.17377 9.99972 4.17377C8.30113 4.17377 6.65279 4.75004 5.3242 5.80835C3.9956 6.86667 3.06536 8.34442 2.68555 10C3.06397 11.6569 3.99361 13.1363 5.32234 14.196C6.65106 15.2557 8.30016 15.833 9.99972 15.8333V15.8333ZM9.99972 13.75C9.00516 13.75 8.05133 13.3549 7.34807 12.6516C6.64481 11.9484 6.24972 10.9946 6.24972 10C6.24972 9.00544 6.64481 8.05161 7.34807 7.34835C8.05133 6.64509 9.00516 6.25 9.99972 6.25C10.9943 6.25 11.9481 6.64509 12.6514 7.34835C13.3546 8.05161 13.7497 9.00544 13.7497 10C13.7497 10.9946 13.3546 11.9484 12.6514 12.6516C11.9481 13.3549 10.9943 13.75 9.99972 13.75ZM9.99972 12.0833C10.5523 12.0833 11.0822 11.8638 11.4729 11.4731C11.8636 11.0824 12.0831 10.5525 12.0831 10C12.0831 9.44747 11.8636 8.91756 11.4729 8.52686C11.0822 8.13616 10.5523 7.91667 9.99972 7.91667C9.44719 7.91667 8.91728 8.13616 8.52658 8.52686C8.13588 8.91756 7.91639 9.44747 7.91639 10C7.91639 10.5525 8.13588 11.0824 8.52658 11.4731C8.91728 11.8638 9.44719 12.0833 9.99972 12.0833Z" fill="white" />
                                </svg>
                            </a>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }

            function updatePaginationInfo(pagination) {
                if (!pagination) {
                    console.error('No pagination data found');
                    return;
                }

                const start = ((pagination.current_page - 1) * pagination.per_page) + 1;
                const end = Math.min(pagination.current_page * pagination.per_page, pagination.total);

                if (paginationInfo) {
                    paginationInfo.textContent = `Showing ${start} to ${end} of ${pagination.total} results`;
                }

                renderPagination(pagination);
            }

            function renderPagination(pagination) {
                if (!paginationDiv) return;

                const currentPage = pagination.current_page;
                const lastPage = pagination.last_page;
                const links = pagination.links || [];

                let paginationHTML = '<nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">';

                // Previous button
                paginationHTML += `
                    <span onclick="${currentPage === 1 ? '' : `fetchReturs(${currentPage - 1})`}"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium
                        ${currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                        bg-white border border-gray-300 rounded-l-md leading-5">
                        &lsaquo;
                    </span>
                `;

                // Page numbers
                if (links.length > 0) {
                    // Use links from API if available
                    links.forEach((link, index) => {
                        if (index === 0 || index === links.length - 1) return;
                        paginationHTML += `
                            <span onclick="fetchReturs(${link.label})"
                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                                ${link.active ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}
                                border border-gray-300 leading-5">
                                ${link.label}
                            </span>
                        `;
                    });
                } else {
                    // Create manual pagination if no links
                    const startPage = Math.max(1, currentPage - 2);
                    const endPage = Math.min(lastPage, currentPage + 2);

                    for (let i = startPage; i <= endPage; i++) {
                        paginationHTML += `
                            <span onclick="fetchReturs(${i})"
                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                                ${i === currentPage ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}
                                border border-gray-300 leading-5">
                                ${i}
                            </span>
                        `;
                    }
                }

                // Next button
                paginationHTML += `
                    <span onclick="${currentPage === lastPage ? '' : `fetchReturs(${currentPage + 1})`}"
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                        ${currentPage === lastPage ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                        bg-white border border-gray-300 rounded-r-md leading-5">
                        &rsaquo;
                    </span>
                `;

                paginationHTML += '</nav>';
                paginationDiv.innerHTML = paginationHTML;
            }

            // Make fetchReturs available globally
            window.fetchReturs = fetchReturs;
        });
    </script>
@endsection
