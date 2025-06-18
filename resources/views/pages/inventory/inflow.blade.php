@extends('layouts.main')
@php
    use Carbon\Carbon;
@endphp
@section('container')
    <div class="p-6 bg-white rounded-lg shadow-lg">
        <div class="mb-4">
            <a href="{{ route('inventory.inflows.create') }}">
                <button
                    class="bg-blue-500 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition-colors duration-200">+
                    Tambah</button>
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-3 px-6 text-center w-1">No</th>
                        <th class="py-3 px-6 text-center">Kode LPB</th>
                        <th class="py-3 px-6 text-center">Nama Vendor</th>
                        <th class="py-3 px-6 text-center">Tanggal Masuk</th>
                        <th class="py-3 px-6 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700" id="inflow-data">
                    <!-- Data dari API akan dimasukkan di sini -->
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

    <!-- Edit Modal (hidden by default) -->
    <div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Inflow</h3>
                <form id="edit-inflow-form" class="mt-2">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="code">
                            Kode LPB
                        </label>
                        <input type="text" name="code"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="vendor">
                            Vendor
                        </label>
                        <input type="text" name="vendor"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="date">
                            Tanggal Masuk
                        </label>
                        <input type="date" name="date"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="items-center px-4 py-3">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Simpan
                        </button>
                        <button type="button" onclick="closeEditModal()"
                            class="ml-3 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = window.API_TOKEN;
            const per_page = 5;
            let currentPage = 1;
            let searchQuery = '';
            let selectedId = null;

            if (token) {
                console.log('Token found:', token);
                fetchInflows();
            } else {
                console.error('API token not found');
            }

            function fetchInflows(page = 1) {
                currentPage = page;
                axios.get(`/api/v1/inventory/inflows?per_page=${per_page}&page=${page}&search=${searchQuery}`, {
                        headers: {
                            'Authorization': `Bearer ${token}`
                        }
                    })
                    .then(response => {
                        console.log('Inflows API Response:', response.data);

                        // Normalisasi struktur response
                        let responseData = normalizeResponse(response.data);

                        renderInflowTable(responseData);
                        updatePaginationInfo(responseData);
                    })
                    .catch(error => {
                        console.error('Failed to fetch inflows:', error);
                    });
            }

            // Fungsi untuk normalisasi struktur response dari API
            function normalizeResponse(apiData) {
                // Jika response sudah dalam format yang benar
                if (apiData.data && apiData.current_page !== undefined) {
                    return apiData;
                }

                // Jika response adalah array langsung
                if (Array.isArray(apiData)) {
                    return {
                        data: apiData,
                        current_page: 1,
                        per_page: per_page,
                        total: apiData.length,
                        last_page: Math.ceil(apiData.length / per_page),
                        links: []
                    };
                }

                // Jika response memiliki data.data tapi pagination di root
                if (apiData.data && Array.isArray(apiData.data)) {
                    return {
                        data: apiData.data,
                        current_page: apiData.current_page || 1,
                        per_page: apiData.per_page || per_page,
                        total: apiData.total || apiData.data.length,
                        last_page: apiData.last_page || Math.ceil((apiData.total || apiData.data.length) / (apiData
                            .per_page || per_page)),
                        links: apiData.links || []
                    };
                }

                // Fallback untuk struktur tidak dikenal
                console.error('Unknown API response structure:', apiData);
                return {
                    data: [],
                    current_page: 1,
                    per_page: per_page,
                    total: 0,
                    last_page: 1,
                    links: []
                };
            }

            function renderInflowTable(data) {
                const tbody = document.getElementById("inflow-data");
                tbody.innerHTML = "";

                // Pastikan data.data ada dan berupa array
                if (!data.data || !Array.isArray(data.data)) {
                    console.error('Invalid data structure:', data);
                    const row = document.createElement("tr");
                    row.innerHTML = `<td colspan="5" class="py-3 px-6 text-center">Tidak ada data inflow</td>`;
                    tbody.appendChild(row);
                    return;
                }

                // Render data
                data.data.forEach((item, index) => {
                    const row = document.createElement("tr");
                    row.className = "border-b border-gray-200 hover:bg-gray-100";

                    // Hitung nomor urut dengan memperhitungkan pagination
                    const rowNumber = index + 1 + ((data.current_page - 1) * data.per_page);

                    // Pastikan properti yang diakses sesuai dengan response API
                    const code = item['No. LPB'] || item.code || '-';
                    const vendor = item.Vendor || item.vendor || '-';
                    const date = item.Date || item.date || '-';


row.innerHTML = `
    <td class="py-3 px-6 text-center">${rowNumber}</td>
    <td class="py-3 px-6 text-center">${code}</td>
    <td class="py-3 px-6 text-center">${vendor}</td>
    <td class="py-3 px-6 text-center">${formatDate(date)}</td>
    <td class="py-3 px-6 text-center">
        <a href="/inventory/inflows/${item.id || code}"
           class="bg-blue-500 hover:bg-blue-600 p-2 rounded-md inline-block">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.99972 2.5C14.4931 2.5 18.2314 5.73333 19.0156 10C18.2322 14.2667 14.4931 17.5 9.99972 17.5C5.50639 17.5 1.76805 14.2667 0.983887 10C1.76722 5.73333 5.50639 2.5 9.99972 2.5ZM9.99972 15.8333C11.6993 15.833 13.3484 15.2557 14.6771 14.196C16.0058 13.1363 16.9355 11.6569 17.3139 10C16.9341 8.34442 16.0038 6.86667 14.6752 5.80835C13.3466 4.75004 11.6983 4.17377 9.99972 4.17377C8.30113 4.17377 6.65279 4.75004 5.3242 5.80835C3.9956 6.86667 3.06536 8.34442 2.68555 10C3.06397 11.6569 3.99361 13.1363 5.32234 14.196C6.65106 15.2557 8.30016 15.833 9.99972 15.8333V15.8333ZM9.99972 13.75C9.00516 13.75 8.05133 13.3549 7.34807 12.6516C6.64481 11.9484 6.24972 10.9946 6.24972 10C6.24972 9.00544 6.64481 8.05161 7.34807 7.34835C8.05133 6.64509 9.00516 6.25 9.99972 6.25C10.9943 6.25 11.9481 6.64509 12.6514 7.34835C13.3546 8.05161 13.7497 9.00544 13.7497 10C13.7497 10.9946 13.3546 11.9484 12.6514 12.6516C11.9481 13.3549 10.9943 13.75 9.99972 13.75ZM9.99972 12.0833C10.5523 12.0833 11.0822 11.8638 11.4729 11.4731C11.8636 11.0824 12.0831 10.5525 12.0831 10C12.0831 9.44747 11.8636 8.91756 11.4729 8.52686C11.0822 8.13616 10.5523 7.91667 9.99972 7.91667C9.44719 7.91667 8.91728 8.13616 8.52658 8.52686C8.13588 8.91756 7.91639 9.44747 7.91639 10C7.91639 10.5525 8.13588 11.0824 8.52658 11.4731C8.91728 11.8638 9.44719 12.0833 9.99972 12.0833Z" fill="white"/>
            </svg>
        </a>
    </td>
`;
                    tbody.appendChild(row);
                });

                renderPagination(data);
            }

            // Fungsi untuk memformat tanggal ke format "6 Desember 2024"
            function formatDate(dateString) {
                if (!dateString) return '-';

                try {
                    // Daftar nama bulan dalam Bahasa Indonesia
                    const monthNames = [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];

                    // Coba parsing tanggal
                    const date = new Date(dateString);

                    // Jika parsing gagal, coba format manual untuk string seperti "2023-12-31"
                    if (isNaN(date.getTime())) {
                        // Cek format YYYY-MM-DD
                        const ymdMatch = dateString.match(/^(\d{4})-(\d{2})-(\d{2})$/);
                        if (ymdMatch) {
                            const year = parseInt(ymdMatch[1]);
                            const month = parseInt(ymdMatch[2]) - 1;
                            const day = parseInt(ymdMatch[3]);

                            // Pastikan bulan valid
                            if (month >= 0 && month < 12) {
                                return `${day} ${monthNames[month]} ${year}`;
                            }
                        }

                        // Jika tidak match format di atas, tampilkan as-is
                        return dateString;
                    }

                    // Format tanggal yang berhasil diparsing
                    const day = date.getDate();
                    const month = monthNames[date.getMonth()];
                    const year = date.getFullYear();

                    return `${day} ${month} ${year}`;
                } catch (e) {
                    console.error('Error formatting date:', e);
                    return dateString;
                }
            }

            function updatePaginationInfo(data) {
                const current_page = data.current_page || 1;
                const per_page = data.per_page || per_page;
                const total = data.total || 0;

                const start = ((current_page - 1) * per_page) + 1;
                const end = Math.min(current_page * per_page, total);

                document.getElementById('pagination-info').textContent =
                    `Showing ${start} to ${end} of ${total} results`;
            }

            function renderPagination(data) {
                const currentPage = data.current_page || 1;
                const lastPage = data.last_page || 1;
                const links = data.links || [];

                let paginationHTML =
                    '<nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">';

                // Previous button
                paginationHTML += `
            <span onclick="${currentPage === 1 ? '' : `fetchInflows(${currentPage - 1})`}"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium
                ${currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                bg-white border border-gray-300 rounded-l-md leading-5">
                &lsaquo;
            </span>
        `;

                // Page numbers
                if (links.length > 0) {
                    // Gunakan links dari API jika ada
                    links.forEach((link, index) => {
                        if (index === 0 || index === links.length - 1) return;
                        paginationHTML += `
                    <span onclick="fetchInflows(${link.label})"
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                        ${link.active ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}
                        border border-gray-300 leading-5">
                        ${link.label}
                    </span>
                `;
                    });
                } else {
                    // Buat pagination manual jika tidak ada links
                    const startPage = Math.max(1, currentPage - 2);
                    const endPage = Math.min(lastPage, currentPage + 2);

                    for (let i = startPage; i <= endPage; i++) {
                        paginationHTML += `
                    <span onclick="fetchInflows(${i})"
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
            <span onclick="${currentPage === lastPage ? '' : `fetchInflows(${currentPage + 1})`}"
                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                ${currentPage === lastPage ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                bg-white border border-gray-300 rounded-r-md leading-5">
                &rsaquo;
            </span>
        `;

                paginationHTML += '</nav>';
                document.getElementById("pagination-div").innerHTML = paginationHTML;
            }

            // Edit form handler
            document.getElementById('edit-inflow-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                axios.post(`/api/v1/inventory/inflows/${selectedId}`, formData, {
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'multipart/form-data'
                        },
                        params: {
                            '_method': 'PUT'
                        }
                    })
                    .then(response => {
                        console.log('Inflow updated:', response.data);
                        closeEditModal();
                        fetchInflows(currentPage);
                    })
                    .catch(error => {
                        console.error('Failed to update inflow:', error);
                    });
            });

            // Global functions
            window.showEditModal = function(code, vendor, date, id) {
                document.querySelector('#editModal input[name="code"]').value = code;
                document.querySelector('#editModal input[name="vendor"]').value = vendor;

                // Format tanggal untuk input date
                try {
                    const dateObj = new Date(date);
                    if (!isNaN(dateObj.getTime())) {
                        const formattedDate = dateObj.toISOString().split('T')[0];
                        document.querySelector('#editModal input[name="date"]').value = formattedDate;
                    } else {
                        document.querySelector('#editModal input[name="date"]').value = '';
                    }
                } catch (e) {
                    document.querySelector('#editModal input[name="date"]').value = '';
                }

                window.selectedId = id;
                document.getElementById('editModal').classList.remove('hidden');
            };

            window.closeEditModal = function() {
                document.getElementById('editModal').classList.add('hidden');
            };

            window.deleteInflow = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    axios.delete(`/api/v1/inventory/inflows/${id}`, {
                            headers: {
                                'Authorization': `Bearer ${window.API_TOKEN}`
                            }
                        })
                        .then(response => {
                            console.log('Inflow deleted:', response.data);
                            window.fetchInflows(window.currentPage);
                        })
                        .catch(error => {
                            console.error('Failed to delete inflow:', error);
                            alert('Gagal menghapus data: ' + (error.response?.data?.message || error
                                .message));
                        });
                }
            };

            window.fetchInflows = fetchInflows;


            function renderPagination(data) {
                const currentPage = data.current_page;
                const lastPage = data.last_page || 1;
                const links = data.links || [];

                let paginationHTML =
                    '<nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">';

                // Previous button
                paginationHTML += `
            <span onclick="${currentPage === 1 ? '' : `fetchInflows(${currentPage - 1})`}"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium
                ${currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                bg-white border border-gray-300 rounded-l-md leading-5">
                &lsaquo;
            </span>
        `;

                // Page numbers (simple version if links not available)
                if (links.length === 0) {
                    for (let i = 1; i <= lastPage; i++) {
                        paginationHTML += `
                    <span onclick="fetchInflows(${i})"
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                        ${i === currentPage ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}
                        border border-gray-300 leading-5">
                        ${i}
                    </span>
                `;
                    }
                } else {
                    // Page numbers from links
                    links.forEach((link, index) => {
                        if (index === 0 || index === links.length - 1) return;
                        paginationHTML += `
                    <span onclick="fetchInflows(${link.label})"
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                        ${link.active ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}
                        border border-gray-300 leading-5">
                        ${link.label}
                    </span>
                `;
                    });
                }

                // Next button
                paginationHTML += `
            <span onclick="${currentPage === lastPage ? '' : `fetchInflows(${currentPage + 1})`}"
                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                ${currentPage === lastPage ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                bg-white border border-gray-300 rounded-r-md leading-5">
                &rsaquo;
            </span>
        `;

                paginationHTML += '</nav>';
                document.getElementById("pagination-div").innerHTML = paginationHTML;
            }

            // Edit form handler
            document.getElementById('edit-inflow-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                axios.post(`/api/v1/inventory/inflows/${selectedId}`, formData, {
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Content-Type': 'multipart/form-data'
                        },
                        params: {
                            '_method': 'PUT'
                        }
                    })
                    .then(response => {
                        console.log('Inflow updated:', response.data);
                        closeEditModal();
                        fetchInflows(currentPage);
                    })
                    .catch(error => {
                        console.error('Failed to update inflow:', error);
                    });
            });

            // Global functions
            window.showEditModal = function(code, vendor, date, id) {
                document.querySelector('#editModal input[name="code"]').value = code;
                document.querySelector('#editModal input[name="vendor"]').value = vendor;
                document.querySelector('#editModal input[name="date"]').value = date;
                window.selectedId = id;
                document.getElementById('editModal').classList.remove('hidden');
            };

            window.closeEditModal = function() {
                document.getElementById('editModal').classList.add('hidden');
            };

            window.deleteInflow = function(id) {
                if (confirm('Are you sure you want to delete this inflow?')) {
                    axios.delete(`/api/v1/inventory/inflows/${id}`, {
                            headers: {
                                'Authorization': `Bearer ${window.API_TOKEN}`
                            }
                        })
                        .then(response => {
                            console.log('Inflow deleted:', response.data);
                            window.fetchInflows(window.currentPage);
                        })
                        .catch(error => {
                            console.error('Failed to delete inflow:', error);
                        });
                }
            };
        });
    </script>
@endsection
