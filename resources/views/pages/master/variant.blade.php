@extends('layouts.main')

@section('container')
<div class="p-6 bg-white rounded-lg shadow-lg">
    <div class="flex justify-between mb-4">
        <div class="w-1/2">
            <form id="create-variant-form" action="{{ route('master.variant.store') }}" method="POST">
                @csrf
                <input type="text" name="name" class="border border-gray-300 rounded-lg p-2 w-3/4 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Tambahkan Jenis Obat">
                <button class="bg-blue-500 text-white rounded-lg hover:bg-blue-600 px-6 py-2">Tambah</button>
            </form>
        </div>

        <div class="flex justify-end">
            <form action="">
                <input type="text" name="variant-search" id="variant-search" placeholder="Search..."
                    class="ring-2 ring-gray-300 rounded-full px-6 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </form>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full text-sm text-center">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-3 px-6 w-1">No</th>
                    <th class="py-3 px-6">Nama Jenis</th>
                    <th class="py-3 px-6">Action</th>
                </tr>
            </thead>
            <tbody id="variant-data">
                {{-- Data will be populated by JavaScript --}}
            </tbody>
            <tbody id="variant-value"></tbody>
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

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 w-96 relative">
        <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600"
            onclick="closeEditModal()">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
            </svg>
            <span class="sr-only">Close modal</span>
        </button>
        <h2 class="text-center text-xl font-semibold mb-6">Ubah Jenis</h2>
        <form method="PUT" id="edit-variant-form">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-start text-gray-700 mb-2" for="name">Nama</label>
                <input class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       type="text" id="name" name="name">
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <button type="button" id="closeModal" onclick="closeEditModal()"
                    class="px-4 py-2 border rounded-lg text-gray-700 border-gray-300 bg-gray-200 hover:bg-gray-300 w-full flex-1">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white hover:bg-blue-700 rounded-lg w-full flex-1">Edit</button>
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

        if (token) {
            console.log('Token found:', token);
            fetchVariants();
        } else {
            console.error('API token not found');
        }

        document.getElementById('variant-search').addEventListener('input', handleSearchInput);
        document.getElementById('create-variant-form').addEventListener('submit', handleCreateForm);
        document.getElementById('edit-variant-form').addEventListener('submit', handleEditForm);

        function fetchVariants(page = 1) {
            currentPage = page;
            axios.get(`/api/v1/variants?per_page=${per_page}&page=${page}&search=${searchQuery}`, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                console.log('Variants data:', response.data);
                renderVariantTable(response.data);
                updatePaginationInfo(response.data);
            })
            .catch(error => {
                console.error('Failed to fetch variants:', error);
            });
        }

        // 💡 Tambahkan ini agar fungsi fetchVariants bisa dipanggil dari HTML onclick
        window.fetchVariants = fetchVariants;

        function handleSearchInput(e) {
            searchQuery = e.target.value;
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                fetchVariants(1);
            }, 400);
        }

        function handleCreateForm(e) {
            e.preventDefault();
            const formData = new FormData(e.target);

            axios.post('/api/v1/variants', formData, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                console.log('Variant created:', response.data);
                fetchVariants(currentPage);
                e.target.reset();
            })
            .catch(error => {
                console.error('Failed to create variant:', error);
            });
        }

        function handleEditForm(e) {
            e.preventDefault();
            const formData = new FormData(e.target);
            const variantId = selectedId;

            axios.post(`/api/v1/variants/${variantId}`, formData, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'multipart/form-data'
                },
                params: {
                    '_method': 'PUT'
                }
            })
            .then(response => {
                console.log('Variant updated:', response.data);
                closeEditModal();
                fetchVariants(currentPage);
            })
            .catch(error => {
                console.error('Failed to update variant:', error);
            });
        }

        function renderVariantTable(data) {
            const tbody = document.getElementById("variant-data");
            tbody.innerHTML = "";

            data.data.data.forEach((item, index) => {
                const row = document.createElement("tr");
                row.className = "border-b border-gray-200 hover:bg-gray-100";

                const rowNumber = index + 1 + ((data.data.current_page - 1) * per_page);

                row.innerHTML = `
                    <td class="py-3 px-6">${rowNumber}</td>
                    <td class="py-3 px-6 text-left">${item.name}</td>
                    <td class="py-3 px-6 flex justify-center">
                        <a class="flex cursor-pointer items-center bg-yellow-300 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-yellow-400 mr-2" title="Edit" onclick="showEditModal('${item.name}', ${item.id})">
                            <svg width="20" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.728 9.68602L14.314 8.27202L5 17.586V19H6.414L15.728 9.68602ZM17.142 8.27202L18.556 6.85802L17.142 5.44402L15.728 6.85802L17.142 8.27202ZM7.242 21H3V16.757L16.435 3.32202C16.6225 3.13455 16.8768 3.02924 17.142 3.02924C17.4072 3.02924 17.6615 3.13455 17.849 3.32202L20.678 6.15102C20.8655 6.33855 20.9708 6.59286 20.9708 6.85802C20.9708 7.12319 20.8655 7.37749 20.678 7.56502L7.243 21H7.242Z" fill="white" />
                            </svg>
                        </a>
                        <button type="button" class="bg-red-500 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-red-600" title="Delete" onclick="deleteVariant(${item.id})">
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
            const data = responseData.data; // 🔁 ambil objek 'data' dari response

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
                <span onclick="${currentPage === 1 ? '' : `fetchVariants(${currentPage - 1})`}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium
                    ${currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                    bg-white border border-gray-300 rounded-l-md leading-5">
                    &lsaquo;
                </span>
            `;

            links.forEach((link, index) => {
                if (index === 0 || index === links.length - 1) return;
                paginationHTML += `
                    <span onclick="fetchVariants(${link.label})"
                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                        ${link.active ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'}
                        border border-gray-300 leading-5">
                        ${link.label}
                    </span>
                `;
            });

            paginationHTML += `
                <span onclick="${currentPage === lastPage ? '' : `fetchVariants(${currentPage + 1})`}"
                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium
                    ${currentPage === lastPage ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 cursor-pointer hover:bg-gray-50'}
                    bg-white border border-gray-300 rounded-r-md leading-5">
                    &rsaquo;
                </span>
            `;

            paginationHTML += '</nav>';
            document.getElementById("pagination-div").innerHTML = paginationHTML;
        }

        // Global deleteVariant
        window.deleteVariant = function (id) {
            if (confirm('Are you sure you want to delete this variant?')) {
                axios.delete(`/api/v1/variants/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => {
                    console.log('Variant deleted:', response.data);
                    fetchVariants(currentPage);
                })
                .catch(error => {
                    console.error('Failed to delete variant:', error);
                });
            }
        };
    });

    // Global modal handlers
    window.showEditModal = function (name, id) {
        document.querySelector('#editModal input[name="name"]').value = name;
        window.selectedId = id;
        document.getElementById('editModal').classList.remove('hidden');
    };

    window.closeEditModal = function () {
        document.getElementById('editModal').classList.add('hidden');
    };
</script>
@endsection
