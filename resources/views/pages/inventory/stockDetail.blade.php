@extends('layouts.main')

@section('container')
<div class="p-6 bg-white rounded-lg shadow-lg">
    <!-- Drug Details Section -->
    <div class="bg-white shadow-md rounded-lg mb-6">
        <div class="bg-gray-200 p-4 rounded-t-lg">
            <h2 class="font-semibold">Detail Obat</h2>
        </div>
        <div class="p-4">
            <table class="w-full">
                <tbody id="drug-details-body" class="text-sm">
                    <!-- Will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Drug Repacks Section -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">STOK OBAT</h2>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full text-sm text-center">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-3 px-6 text-center w-1">No</th>
                        <th class="py-3 px-6 text-center">Nama Packaging Obat</th>
                        <th class="py-3 px-6 text-center">Margin</th>
                        <th class="py-3 px-6 text-center">Stok konversi</th>
                        <th class="py-3 px-6 text-center">Harga Jual</th>
                    </tr>
                </thead>
                <tbody id="repacks-data" class="text-gray-700">
                    <!-- Will be populated by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Expiry Details Section -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">KATEGORI BERDASARKAN EXP DATE</h2>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full text-sm text-center">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-3 px-6 text-center w-1">No</th>
                        <th class="py-3 px-6 text-center">Waktu Expired Obat</th>
                        <th class="py-3 px-6 text-center">Jumlah</th>
                        <th class="py-3 px-6 text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="expiry-data" class="text-gray-700">
                    <!-- Will be populated by JavaScript -->
                </tbody>
            </table>
            <div id="expiry-pagination" class="p-4">
                <!-- Pagination will be added here -->
            </div>
        </div>
    </div>

    <!-- Transactions History Section -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">HISTORI TRANSAKSI</h2>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-center">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="py-3 px-6 text-center w-1">No</th>
                            <th class="py-3 px-6 text-center">Jenis Packaging Obat</th>
                            <th class="py-3 px-6 text-center">Margin</th>
                            <th class="py-3 px-6 text-center">Harga</th>
                            <th class="py-3 px-6 text-center">Jumlah</th>
                            <th class="py-3 px-6 text-center">Status</th>
                            <th class="py-3 px-6 text-center">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="transactions-data" class="text-gray-700 font-light">
                        <!-- Will be populated by JavaScript -->
                    </tbody>
                </table>
                <div id="transactions-pagination" class="p-4">
                    <!-- Pagination will be added here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Status translation function
    function getStatus(variant) {
        if (!variant) return '-';

        switch(variant) {
            case 'LPB': return 'Masuk';
            case 'LPK': return 'Klinik';
            case 'Checkout': return 'Keluar';
            case 'Trash': return 'Buang';
            case 'Retur': return 'Retur';
            default: return variant;
        }
    }

    // Make available globally for pagination
    window.getStatus = getStatus;

    document.addEventListener('DOMContentLoaded', function() {
        const token = window.API_TOKEN;
        const API_BASE_URL = '/api/v1';
        const drugId = window.location.pathname.split('/').pop();

        if (!token) {
            console.error('API token not found');
            return;
        }

        // Fetch all drug data
        fetchDrugData(drugId);

        function fetchDrugData(id) {
            axios.get(`${API_BASE_URL}/inventory/stocks/${id}`, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                console.log('Full API response:', response);
                if (!response.data || !response.data.data) {
                    throw new Error('Invalid API response structure');
                }

                const data = response.data.data;
                console.log('Drug data:', data);

                // Check if required data exists before populating
                if (data.drug) {
                    populateDrugDetails(data.drug, data.stock || { quantity: 0 });
                } else {
                    console.error('Drug data not found in response');
                }

                if (data.repacks && data.stock) {
                    populateRepacksData(data.repacks, data.stock);
                }

                if (data.expiry_details) {
                    populateExpiryData(
                        data.expiry_details.data || [],
                        data.expiry_details.links || {},
                        data.drug || { piece_netto: 1 }
                    );
                }

                if (data.transactions) {
                    populateTransactionsData(
                        data.transactions.data || [],
                        data.transactions.links || {}
                    );
                }
            })
            .catch(error => {
                console.error('Failed to fetch drug data:', error);
                alert('Gagal memuat data obat. Silakan coba lagi atau hubungi administrator.');
            });
        }

        function populateDrugDetails(drug, stock) {
            const detailsBody = document.getElementById('drug-details-body');
            if (!detailsBody || !drug) return;

            detailsBody.innerHTML = `
                <tr class="border-b">
                    <td class="py-2 px-4 font-medium">Nama</td>
                    <td class="py-2 px-4">${drug.name || '-'}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 font-medium">Kode Obat</td>
                    <td class="py-2 px-4">${drug.code || '-'}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 font-medium">Jenis</td>
                    <td class="py-2 px-4">${drug.variant?.name || '-'}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 font-medium">Kategori</td>
                    <td class="py-2 px-4">${drug.category?.name || '-'}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 px-4 font-medium">Produsen</td>
                    <td class="py-2 px-4">${drug.manufacture?.name || '-'}</td>
                </tr>
                <tr>
                    <td class="py-2 px-4 font-medium">Sisa</td>
                    <td class="py-2 px-4">${drug.piece_netto ? Math.floor((stock?.quantity || 0) / drug.piece_netto) : 0} pcs</td>
                </tr>
            `;
        }

        function populateRepacksData(repacks, stock) {
            const repacksBody = document.getElementById('repacks-data');
            if (!repacksBody) return;

            repacksBody.innerHTML = '';

            repacks.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = 'border-b border-gray-200 hover:bg-gray-100';
                row.innerHTML = `
                    <td class="py-3 px-6">${index + 1}</td>
                    <td class="py-3 px-6 text-left">${item.name || '-'}</td>
                    <td class="py-3 px-6">${item.margin || '-'}%</td>
                    <td class="py-3 px-6">${item.quantity && stock?.quantity ? Math.floor(stock.quantity / item.quantity) : '-'}</td>
                    <td class="py-3 px-6">${formatCurrency(item.price || 0)}</td>
                `;
                repacksBody.appendChild(row);
            });
        }

        function populateExpiryData(expiryDetails, paginationLinks, drug) {
            const expiryBody = document.getElementById('expiry-data');
            if (!expiryBody) return;

            expiryBody.innerHTML = '';

            expiryDetails.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = 'border-b border-gray-200 hover:bg-gray-100';
                row.innerHTML = `
                    <td class="py-3 px-6">${index + 1}</td>
                    <td class="py-3 px-6">${formatDate(item.expired)}</td>
                    <td class="py-3 px-6">${item.stock && drug.piece_netto ? Math.floor(item.stock / drug.piece_netto) : '-'}</td>
                    <td class="py-3 px-6">
                        <div class="flex space-x-2 justify-center items-center">
                            <a href="/inventory/retur/${item.id}"
                                class="p-2 rounded-lg shadow bg-yellow-300 hover:bg-yellow-500 flex items-center justify-center">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M13.414 6.00002L15.243 7.82802L13.828 9.24302L9.586 5.00002L13.828 0.757019L15.243 2.17202L13.414 4.00002H16C17.3261 4.00002 18.5979 4.5268 19.5355 5.46449C20.4732 6.40217 21 7.67394 21 9.00002V13H19V9.00002C19 8.20437 18.6839 7.44131 18.1213 6.8787C17.5587 6.31609 16.7956 6.00002 16 6.00002H13.414ZM15 11V21C15 21.2652 14.8946 21.5196 14.7071 21.7071C14.5196 21.8947 14.2652 22 14 22H4C3.73478 22 3.48043 21.8947 3.29289 21.7071C3.10536 21.5196 3 21.2652 3 21V11C3 10.7348 3.10536 10.4804 3.29289 10.2929C3.48043 10.1054 3.73478 10 4 10H14C14.2652 10 14.5196 10.1054 14.7071 10.2929C14.8946 10.4804 15 10.7348 15 11ZM13 12H5V20H13V12Z"
                                        fill="white" />
                                </svg>
                            </a>
                            <a href="/inventory/trash/${item.id}"
                                class="p-2 rounded-lg shadow bg-red-600 hover:bg-red-800 flex items-center justify-center">
                                <svg width="20" height="20" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.167 5.50002H18.3337V7.16669H16.667V18C16.667 18.221 16.5792 18.433 16.4229 18.5893C16.2666 18.7456 16.0547 18.8334 15.8337 18.8334H4.16699C3.94598 18.8334 3.73402 18.7456 3.57774 18.5893C3.42146 18.433 3.33366 18.221 3.33366 18V7.16669H1.66699V5.50002H5.83366V3.00002C5.83366 2.77901 5.92146 2.56704 6.07774 2.41076C6.23402 2.25448 6.44598 2.16669 6.66699 2.16669H13.3337C13.5547 2.16669 13.7666 2.25448 13.9229 2.41076C14.0792 2.56704 14.167 2.77901 14.167 3.00002V5.50002ZM15.0003 7.16669H5.0003V17.1667H15.0003V7.16669ZM7.5003 3.83335V5.50002H12.5003V3.83335H7.5003Z"
                                        fill="white" />
                                </svg>
                            </a>
                        </div>
                    </td>
                `;
                expiryBody.appendChild(row);
            });

            renderPagination('expiry-pagination', paginationLinks);
        }

        function populateTransactionsData(transactions, paginationLinks) {
            const transactionsBody = document.getElementById('transactions-data');
            if (!transactionsBody) return;

            transactionsBody.innerHTML = '';

            transactions.forEach((item, index) => {
                const row = document.createElement('tr');
                row.className = 'border-b border-gray-200 hover:bg-gray-100';
                row.innerHTML = `
                    <td class="py-3 px-6">${index + 1}</td>
                    <td class="py-3 px-6">${item.name || '-'}</td>
                    <td class="py-3 px-6">${item.margin || '-'}%</td>
                    <td class="py-3 px-6">${formatCurrency(item.piece_price || 0)}</td>
                    <td class="py-3 px-6">${item.quantity || '-'}</td>
                    <td class="py-3 px-6">${item.transaction?.variant ? getStatus(item.transaction.variant) : '-'}</td>
                    <td class="py-3 px-6">${formatCurrency(item.total_price || 0)}</td>
                `;
                transactionsBody.appendChild(row);
            });

            renderPagination('transactions-pagination', paginationLinks);
        }

        function renderPagination(elementId, links) {
        const paginationDiv = document.getElementById(elementId);
        if (!paginationDiv || !links) return;

        const currentPage = parseInt(links.current_page) || 1;
        const lastPage = parseInt(links.last_page) || 1;

        // Create pagination info text
        const perPage = parseInt(links.per_page) || 10;
        const total = parseInt(links.total) || 0;
        const start = ((currentPage - 1) * perPage) + 1;
        const end = Math.min(currentPage * perPage, total);

        // Create pagination container
        let paginationHTML = `
            <div class="flex items-center justify-between p-4">
                <div>
                    <p class="text-gray-700 text-sm">
                        Showing ${start} to ${end} of ${total} results
                    </p>
                </div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">
        `;

        // Previous button
        paginationHTML += `
            <span onclick="${currentPage === 1 ? '' : `fetchPage('${links.prev}', '${elementId.replace('-pagination', '-data')}')`}"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium
                ${currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                bg-white border border-gray-300 rounded-l-md leading-5">
                &lsaquo;
            </span>
        `;

        // Page numbers
        if (links.links && links.links.length > 0) {
            // Use API-provided links if available
            links.links.forEach((link, index) => {
                if (index === 0 || index === links.links.length - 1) return;
                const pageNum = link.label;
                paginationHTML += `
                    <span onclick="fetchPage('${link.url}', '${elementId.replace('-pagination', '-data')}')"
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                        ${link.active ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}
                        border border-gray-300 leading-5">
                        ${pageNum}
                    </span>
                `;
            });
        } else {
            // Create simple pagination if no links provided
            const startPage = Math.max(1, currentPage - 2);
            const endPage = Math.min(lastPage, currentPage + 2);

            for (let i = startPage; i <= endPage; i++) {
                const pageUrl = links.path ? `${links.path}?page=${i}` : `?page=${i}`;
                paginationHTML += `
                    <span onclick="fetchPage('${pageUrl}', '${elementId.replace('-pagination', '-data')}')"
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
            <span onclick="${currentPage === lastPage ? '' : `fetchPage('${links.next}', '${elementId.replace('-pagination', '-data')}')`}"
                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                ${currentPage === lastPage ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                bg-white border border-gray-300 rounded-r-md leading-5">
                &rsaquo;
            </span>
        `;

        paginationHTML += `
                </nav>
            </div>
        `;

        paginationDiv.innerHTML = paginationHTML;
    }


        function formatDate(dateString) {
            if (!dateString) return '-';
            try {
                const date = new Date(dateString);
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                return new Intl.DateTimeFormat('id-ID', options).format(date);
            } catch (e) {
                console.error('Error formatting date:', e);
                return dateString;
            }
        }

        function formatCurrency(amount) {
            if (isNaN(amount)) return 'Rp 0';
            return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        window.fetchPage = function(url, targetElementId) {
            axios.get(url, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                console.log('Pagination response:', response.data);
                const data = response.data.data;

                if (targetElementId === 'expiry-data') {
                    populateExpiryData(data.data, data.links, data.drug);
                } else if (targetElementId === 'transactions-data') {
                    populateTransactionsData(data.data, data.links);
                }
            })
            .catch(error => {
                console.error('Failed to fetch paginated data:', error);
            });
        };
    });
</script>
@endsection
