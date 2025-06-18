@extends('layouts.main')

@section('container')
<div class="p-6 bg-white rounded-lg shadow-lg">
    <!-- Form Section -->
    <div class="flex justify-between mb-4">
        <div class="w-1/2">
            <a href="{{ route('master.drug.create') }}">
                <button class="bg-blue-500 text-white rounded-lg hover:bg-blue-600 px-6 py-2">+ Tambah Obat</button>
            </a>
        </div>
        <div class="flex justify-end">
            <form action="">
                <input type="text" name="drug-search" id="drug-search" placeholder="Search..."
                    class="ring-2 ring-gray-300 rounded-full px-6 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full text-sm text-center">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-3 px-6 w-1">No</th>
                    <th class="py-3 px-6">Kode</th>
                    <th class="py-3 px-6">Nama Obat</th>
                    <th class="py-3 px-6">Action</th>
                </tr>
            </thead>
            <tbody id="drug-data">
                {{-- Data will be populated by JavaScript --}}
            </tbody>
            <tbody id="drug-value"></tbody>
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

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 w-96 relative">
        <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600"
            onclick="closeDeleteModal()">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
            </svg>
            <span class="sr-only">Close modal</span>
        </button>
        <h2 class="text-center text-xl font-semibold mb-6">Konfirmasi Hapus</h2>
        <p class="text-center mb-6">Apakah Anda yakin ingin menghapus obat ini?</p>
        <form method="POST" id="delete-drug-form">
            @csrf
            @method('DELETE')
            <div class="flex justify-center space-x-4 mt-4">
                <button type="button" onclick="closeDeleteModal()"
                    class="px-4 py-2 border rounded-lg text-gray-700 border-gray-300 bg-gray-200 hover:bg-gray-300 w-full flex-1">Batal</button>
                <button type="submit"
                    class="px-4 py-2 bg-red-500 text-white hover:bg-red-700 rounded-lg w-full flex-1">Hapus</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const token = window.API_TOKEN || "{{ env('API_TOKEN') }}";
        const per_page = 5;
        let currentPage = 1;
        let searchQuery = '';
        let selectedId = null;

        if (token) {
            console.log('Token found:', token);
            fetchDrugs();
        } else {
            console.error('API token not found');
        }

        document.getElementById('drug-search').addEventListener('input', handleSearchInput);
        document.getElementById('delete-drug-form').addEventListener('submit', handleDeleteForm);

        function fetchDrugs(page = 1) {
            currentPage = page;
            axios.get(`/api/v1/drugs?per_page=${per_page}&page=${page}&search=${searchQuery}`, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                console.log('Drugs data:', response.data);
                renderDrugTable(response.data);
                updatePaginationInfo(response.data);
            })
            .catch(error => {
                console.error('Failed to fetch drugs:', error);
            });
        }

        window.fetchDrugs = fetchDrugs;

        function handleSearchInput(e) {
            searchQuery = e.target.value;
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                fetchDrugs(1);
            }, 400);
        }

       function handleDeleteForm(e) {
    e.preventDefault();
    const drugId = selectedId;

    if (!drugId) {
        console.error('Tidak ada obat yang dipilih untuk dihapus');
        return;
    }

    axios.delete(`/api/v1/drugs/${drugId}`, {
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        console.log('Obat berhasil dihapus:', response.data);
        closeDeleteModal();
        fetchDrugs(currentPage);
        // Tampilkan pesan sukses
        alert('Obat berhasil dihapus');
    })
    .catch(error => {
        console.error('Gagal menghapus obat:', error);
        let pesanError = 'Gagal menghapus obat. Silakan coba lagi.';

        // Cek error response spesifik
        if (error.response) {
            if (error.response.status === 422) {
                pesanError = 'Tidak dapat menghapus obat karena masih memiliki stok';
            } else if (error.response.data && error.response.data.message) {
                pesanError = error.response.data.message;
            }
        }

        alert(pesanError);
    });
}
        function renderDrugTable(data) {
            const tbody = document.getElementById("drug-data");
            tbody.innerHTML = "";

            data.data.data.forEach((item, index) => {
                const row = document.createElement("tr");
                row.className = "border-b border-gray-200 hover:bg-gray-100";

                const rowNumber = index + 1 + ((data.data.current_page - 1) * per_page);

                row.innerHTML = `
                    <td class="py-3 px-6">${rowNumber}</td>
                    <td class="py-3 px-6">${item.code}</td>
                    <td class="py-3 px-6 text-left">${item.name}</td>
                    <td class="py-3 px-6 flex justify-center">
                        <a class="flex cursor-pointer items-center bg-blue-500  text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-blue-600 mr-2" title="Edit" href="/master/drug/${item.id}/edit">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.99972 2.5C14.4931 2.5 18.2314 5.73333 19.0156 10C18.2322 14.2667 14.4931 17.5 9.99972 17.5C5.50639 17.5 1.76805 14.2667 0.983887 10C1.76722 5.73333 5.50639 2.5 9.99972 2.5ZM9.99972 15.8333C11.6993 15.833 13.3484 15.2557 14.6771 14.196C16.0058 13.1363 16.9355 11.6569 17.3139 10C16.9341 8.34442 16.0038 6.86667 14.6752 5.80835C13.3466 4.75004 11.6983 4.17377 9.99972 4.17377C8.30113 4.17377 6.65279 4.75004 5.3242 5.80835C3.9956 6.86667 3.06536 8.34442 2.68555 10C3.06397 11.6569 3.99361 13.1363 5.32234 14.196C6.65106 15.2557 8.30016 15.833 9.99972 15.8333V15.8333ZM9.99972 13.75C9.00516 13.75 8.05133 13.3549 7.34807 12.6516C6.64481 11.9484 6.24972 10.9946 6.24972 10C6.24972 9.00544 6.64481 8.05161 7.34807 7.34835C8.05133 6.64509 9.00516 6.25 9.99972 6.25C10.9943 6.25 11.9481 6.64509 12.6514 7.34835C13.3546 8.05161 13.7497 9.00544 13.7497 10C13.7497 10.9946 13.3546 11.9484 12.6514 12.6516C11.9481 13.3549 10.9943 13.75 9.99972 13.75ZM9.99972 12.0833C10.5523 12.0833 11.0822 11.8638 11.4729 11.4731C11.8636 11.0824 12.0831 10.5525 12.0831 10C12.0831 9.44747 11.8636 8.91756 11.4729 8.52686C11.0822 8.13616 10.5523 7.91667 9.99972 7.91667C9.44719 7.91667 8.91728 8.13616 8.52658 8.52686C8.13588 8.91756 7.91639 9.44747 7.91639 10C7.91639 10.5525 8.13588 11.0824 8.52658 11.4731C8.91728 11.8638 9.44719 12.0833 9.99972 12.0833Z" fill="white"/>
            </svg>
                        </a>
                        <button type="button" class="bg-red-500 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-red-600" title="Delete" onclick="showDeleteModal(${item.id})">
                            <svg width="20" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.167 5.50002H18.3337V7.16669H16.667V18C16.667 18.221 16.5792 18.433 16.4229 18.5893C16.2666 18.7456 16.0547 18.8334 15.8337 18.8334H4.16699C3.94598 18.8334 3.73402 18.7456 3.57774 18.5893C3.42146 18.433 3.33366 18.221 3.33366 18V7.16669H1.66699V5.50002H5.83366V3.00002C5.83366 2.77901 5.92146 2.56704 6.07774 2.41076C6.23402 2.25448 6.44598 2.16669 6.66699 2.16669H13.3337C13.5547 2.16669 13.7666 2.25448 13.9229 2.41076C14.0792 2.56704 14.167 2.77901 14.167 3.00002V5.50002ZM15.0003 7.16669H5.0003V17.1667H15.0003V7.16669ZM7.5003 3.83335V5.50002H12.5003V3.83335H7.5003Z" fill="white"/>
                            </svg>
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });

            renderPagination(data);
        }

        function updatePaginationInfo(responseData) {
            const data = responseData.data;

            const start = ((data.current_page - 1) * data.per_page) + 1;
            const end = Math.min(data.current_page * data.per_page, data.total);
            const total = data.total;

            document.getElementById('pagination-info').textContent =
                `Showing ${start} to ${end} of ${total} results`;
        }

        function renderPagination(data) {
            const currentPage = data.data.current_page;
            const lastPage = data.data.last_page;
            const links = data.data.links;

            let paginationHTML = '<nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">';

            paginationHTML += `
                <span onclick="${currentPage === 1 ? '' : `fetchDrugs(${currentPage - 1})`}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium
                    ${currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                    bg-white border border-gray-300 rounded-l-md leading-5">
                    &lsaquo;
                </span>
            `;

            links.forEach((link, index) => {
                if (index === 0 || index === links.length - 1) return;
                paginationHTML += `
                    <span onclick="fetchDrugs(${link.label})"
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                        ${link.active ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}
                        border border-gray-300 leading-5">
                        ${link.label}
                    </span>
                `;
            });

            paginationHTML += `
                <span onclick="${currentPage === lastPage ? '' : `fetchDrugs(${currentPage + 1})`}"
                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                    ${currentPage === lastPage ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                    bg-white border border-gray-300 rounded-r-md leading-5">
                    &rsaquo;
                </span>
            `;

            paginationHTML += '</nav>';
            document.getElementById("pagination-div").innerHTML = paginationHTML;
        }

        window.showDeleteModal = function (id) {
            selectedId = id;
            document.getElementById('delete-drug-form').action = `/master/drug/${id}`;
            document.getElementById('deleteModal').classList.remove('hidden');
        };

        window.closeDeleteModal = function () {
            selectedId = null;
            document.getElementById('deleteModal').classList.add('hidden');
        };
    });
</script>
@endsection
