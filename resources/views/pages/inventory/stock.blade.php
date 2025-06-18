@extends('layouts.main')

@section('container')
    <div class="p-6 bg-white rounded-lg shadow-lg">
        <title>List Stok Obat</title>

        <div class="flex justify-end">
            <form action="">
                <input type="text" name="inventory-stock-search" id="inventory-stock-search" placeholder="Search..."
                    class="ring-2 ring-gray-300 rounded-full px-6 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full text-sm text-center">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-3 px-6 text-center w-1">No</th>
                        <th class="py-3 px-6 text-center">Kode Obat</th>
                        <th class="py-3 px-6 text-center">Nama Obat</th>
                        <th class="py-3 px-6 text-center">Jumlah</th>
                        <th class="py-3 px-6 text-center">Expired Terdekat</th>
                        <th class="py-3 px-6 text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="stock-data"></tbody>
                <tbody id="stock-value" class="hidden"></tbody>
            </table>
        </div>

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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
   <script>
    document.addEventListener('DOMContentLoaded', function() {
        const token = window.API_TOKEN;
        const per_page = 5;
        let currentPage = 1;
        let searchQuery = '';
        let drugsData = {}; // Store drug information for reference

        if (token) {
            console.log('Token found:', token);
            // First fetch drugs to get names and codes
            fetchDrugs().then(() => fetchStocks());
        } else {
            console.error('API token not found');
        }

        // Search input handler
        document.getElementById('inventory-stock-search').addEventListener('input', function(e) {
            searchQuery = e.target.value;
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                fetchStocks(1);
            }, 400);
        });

        // Fetch drugs data for reference
        function fetchDrugs() {
            return axios.get('/api/v1/drugs', {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    },
                    params: {
                        'per_page': 1000 // Get all drugs at once
                    }
                })
                .then(response => {
                    // Check if response.data.data exists and is an array
                    const drugsArray = Array.isArray(response.data.data) ?
                        response.data.data :
                        (response.data.data?.data || []);

                    // Store drugs data with drug_id as key
                    drugsArray.forEach(drug => {
                        if (drug && drug.id) {
                            drugsData[drug.id] = drug;
                        }
                    });
                    console.log('Fetched drugs data:', drugsData);
                })
                .catch(error => {
                    console.error('Failed to fetch drugs:', error);
                    // Continue even if drugs fetch fails
                    return Promise.resolve();
                });
        }

        // Main function to fetch stocks
        function fetchStocks(page = 1) {
            currentPage = page;
            axios.get(`/api/v1/inventory/stocks`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    },
                    params: {
                        'per_page': per_page,
                        'page': page,
                        'search': searchQuery
                    }
                })
                .then(response => {
                    console.log('Stocks response:', response.data);
                    renderStockTable(response.data);
                    renderPagination(response.data);
                    updatePaginationInfo(response.data); // Add this line to update the info
                })
                .catch(error => {
                    console.error('Failed to fetch stocks:', error);
                    alert('Failed to load stock data. Please try again later.');
                });
        }

        // Make fetchStocks available globally for pagination
        window.fetchStocks = fetchStocks;

        // Render stock table
        function renderStockTable(data) {
            const tbody = document.getElementById("stock-data");
            if (!tbody) return;

            tbody.innerHTML = "";

            const stocks = data.data.data || [];
            const startCount = ((data.data.current_page || 1) - 1) * per_page + 1;

            if (stocks.length === 0) {
                tbody.innerHTML = `
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td colspan="6" class="py-3 px-6 text-center flex flex-col items-center justify-center">
                            No stock data available
                            <svg width="40" height="40" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="mt-2">
                                <path d="M9.99972 2.5C14.4931 2.5 18.2314 5.73333 19.0156 10C18.2322 14.2667 14.4931 17.5 9.99972 17.5C5.50639 17.5 1.76805 14.2667 0.983887 10C1.76722 5.73333 5.50639 2.5 9.99972 2.5ZM9.99972 15.8333C11.6993 15.833 13.3484 15.2557 14.6771 14.196C16.0058 13.1363 16.9355 11.6569 17.3139 10C16.9341 8.34442 16.0038 6.86667 14.6752 5.80835C13.3466 4.75004 11.6983 4.17377 9.99972 4.17377C8.30113 4.17377 6.65279 4.75004 5.3242 5.80835C3.9956 6.86667 3.06536 8.34442 2.68555 10C3.06397 11.6569 3.99361 13.1363 5.32234 14.196C6.65106 15.2557 8.30016 15.833 9.99972 15.8333V15.8333ZM9.99972 13.75C9.00516 13.75 8.05133 13.3549 7.34807 12.6516C6.64481 11.9484 6.24972 10.9946 6.24972 10C6.24972 9.00544 6.64481 8.05161 7.34807 7.34835C8.05133 6.64509 9.00516 6.25 9.99972 6.25C10.9943 6.25 11.9481 6.64509 12.6514 7.34835C13.3546 8.05161 13.7497 9.00544 13.7497 10C13.7497 10.9946 13.3546 11.9484 12.6514 12.6516C11.9481 13.3549 10.9943 13.75 9.99972 13.75ZM9.99972 12.0833C10.5523 12.0833 11.0822 11.8638 11.4729 11.4731C11.8636 11.0824 12.0831 10.5525 12.0831 10C12.0831 9.44747 11.8636 8.91756 11.4729 8.52686C11.0822 8.13616 10.5523 7.91667 9.99972 7.91667C9.44719 7.91667 8.91728 8.13616 8.52658 8.52686C8.13588 8.91756 7.91639 9.44747 7.91639 10C7.91639 10.5525 8.13588 11.0824 8.52658 11.4731C8.91728 11.8638 9.44719 12.0833 9.99972 12.0833Z" fill="gray"/>
                            </svg>
                        </td>
                    </tr>
                `;
                return;
            }

            stocks.forEach((stock, index) => {
                const drug = drugsData[stock.drug_id] || {};
                const rowNumber = startCount + index;
                const quantity = stock.quantity || 0;
                const expiredDate = stock.oldest ? formatDate(stock.oldest) : 'N/A';

                const row = document.createElement("tr");
                row.className = "border-b border-gray-200 hover:bg-gray-100";
                row.innerHTML = `
                    <td class="py-3 px-6">${rowNumber}</td>
                    <td class="py-3 px-6">${drug.code || 'N/A'}</td>
                    <td class="py-3 px-6 text-left">${drug.name || 'Unknown Drug'}</td>
                    <td class="py-3 px-6">${quantity}</td>
                    <td class="py-3 px-6">${stock.oldest ? formatDate(stock.oldest) : ''}</td>
                    <td class="py-3 px-6 flex justify-center">
                        <a href="/inventory/stocks/${stock.drug_id}" class="bg-blue-500 hover:bg-blue-600 p-2 rounded-md">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.99972 2.5C14.4931 2.5 18.2314 5.73333 19.0156 10C18.2322 14.2667 14.4931 17.5 9.99972 17.5C5.50639 17.5 1.76805 14.2667 0.983887 10C1.76722 5.73333 5.50639 2.5 9.99972 2.5ZM9.99972 15.8333C11.6993 15.833 13.3484 15.2557 14.6771 14.196C16.0058 13.1363 16.9355 11.6569 17.3139 10C16.9341 8.34442 16.0038 6.86667 14.6752 5.80835C13.3466 4.75004 11.6983 4.17377 9.99972 4.17377C8.30113 4.17377 6.65279 4.75004 5.3242 5.80835C3.9956 6.86667 3.06536 8.34442 2.68555 10C3.06397 11.6569 3.99361 13.1363 5.32234 14.196C6.65106 15.2557 8.30016 15.833 9.99972 15.8333V15.8333ZM9.99972 13.75C9.00516 13.75 8.05133 13.3549 7.34807 12.6516C6.64481 11.9484 6.24972 10.9946 6.24972 10C6.24972 9.00544 6.64481 8.05161 7.34807 7.34835C8.05133 6.64509 9.00516 6.25 9.99972 6.25C10.9943 6.25 11.9481 6.64509 12.6514 7.34835C13.3546 8.05161 13.7497 9.00544 13.7497 10C13.7497 10.9946 13.3546 11.9484 12.6514 12.6516C11.9481 13.3549 10.9943 13.75 9.99972 13.75ZM9.99972 12.0833C10.5523 12.0833 11.0822 11.8638 11.4729 11.4731C11.8636 11.0824 12.0831 10.5525 12.0831 10C12.0831 9.44747 11.8636 8.91756 11.4729 8.52686C11.0822 8.13616 10.5523 7.91667 9.99972 7.91667C9.44719 7.91667 8.91728 8.13616 8.52658 8.52686C8.13588 8.91756 7.91639 9.44747 7.91639 10C7.91639 10.5525 8.13588 11.0824 8.52658 11.4731C8.91728 11.8638 9.44719 12.0833 9.99972 12.0833Z" fill="white"/>
                            </svg>
                        </a>
                    </td>
                `;
                tbody.appendChild(row);
            });
        }

        // Format date to local string
        // Ganti fungsi formatDate yang lama dengan yang baru
function formatDate(dateString) {
    try {
        const date = new Date(dateString);
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
        const day = String(date.getDate()).padStart(2, '0');

        return `${year}-${month}-${day}`;
    } catch (e) {
        console.error('Error formatting date:', e);
        return dateString; // Return original string if formatting fails
    }
}

        // Render pagination controls
        function renderPagination(data) {
            const paginationDiv = document.getElementById("pagination-div");
            if (!paginationDiv || !data.data) return;

            const currentPage = data.data.current_page || 1;
            const lastPage = data.data.last_page || 1;
            const links = data.data.links || [];

            let paginationHTML =
                '<nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">';

            // Previous button
            paginationHTML += `
                <span onclick="${currentPage === 1 ? '' : `fetchStocks(${currentPage - 1})`}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium
                    ${currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                    bg-white border border-gray-300 rounded-l-md leading-5">
                    &lsaquo;
                </span>
            `;

            // Page numbers
            links.forEach((link) => {
                if (!link.url || link.label.includes('pagination.')) return;
                const pageNum = link.label.replace(/[^0-9]/g, ''); // Remove non-numeric chars

                paginationHTML += `
                    <span onclick="${link.active ? '' : `fetchStocks(${pageNum})`}"
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                        ${link.active ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}
                        border border-gray-300 leading-5">
                        ${link.label}
                    </span>
                `;
            });

            // Next button
            paginationHTML += `
                <span onclick="${currentPage === lastPage ? '' : `fetchStocks(${currentPage + 1})`}"
                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                    ${currentPage === lastPage ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                    bg-white border border-gray-300 rounded-r-md leading-5">
                    &rsaquo;
                </span>
            `;

            paginationHTML += '</nav>';
            paginationDiv.innerHTML = paginationHTML;
        }

        // Add this new function to update pagination info
        function updatePaginationInfo(data) {
            const paginationInfo = document.getElementById("pagination-info");
            if (!paginationInfo || !data.data) return;

            const currentPage = data.data.current_page || 1;
            const perPage = data.data.per_page || per_page;
            const total = data.data.total || 0;

            // Calculate the range being shown
            const from = ((currentPage - 1) * perPage) + 1;
            const to = Math.min(currentPage * perPage, total);

            if (total === 0) {
                paginationInfo.textContent = "Showing 0 results";
            } else {
                paginationInfo.textContent = `Showing ${from} to ${to} of ${total} results`;
            }
        }
    });
</script>
@endsection
