@extends('layouts.main')
@section('container')
    <div class="p-6 bg-white rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
                <button onclick="showTambahModal()" class="bg-green-500 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-green-600 transition-colors duration-200">+
                    Tambah User</button>
            <form action="">
                <input type="text" name="" id="" placeholder="Search..."
                    class="ring-2 ring-gray-300 rounded-full px-6 py-2">
            </form>
        </div>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full text-sm text-center">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="w-1 py-3 px-6 w-1">NO</th>
                        <th class="w-32 py-3 px-6">NAME</th>
                        <th class="w-24 py-3 px-6">ROLE</th>
                        <th class="w-24 py-3 px-6">EMAIL</th>
                        <th class="w-48 py-3 px-6">ACTION</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">1</td>
                        <td class="py-3 px-6 text-left">Lorem Ipsun</td>
                        <td class="py-3 px-6">Dokter</td>
                        <td class="py-3 px-6 text-left">loremIpsun@mail.com</td>
                        <td class="flex justify-center gap-2 py-3">
                            <a onclick="showEditModal()" class="flex cursor-pointer items-center bg-yellow-300 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-yellow-400 transition-colors duration-200 mr-2">
                                <svg width="20" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.728 9.68602L14.314 8.27202L5 17.586V19H6.414L15.728 9.68602ZM17.142 8.27202L18.556 6.85802L17.142 5.44402L15.728 6.85802L17.142 8.27202ZM7.242 21H3V16.757L16.435 3.32202C16.6225 3.13455 16.8768 3.02924 17.142 3.02924C17.4072 3.02924 17.6615 3.13455 17.849 3.32202L20.678 6.15102C20.8655 6.33855 20.9708 6.59286 20.9708 6.85802C20.9708 7.12319 20.8655 7.37749 20.678 7.56502L7.243 21H7.242Z" fill="white"/>
                                </svg>
                            </a>
                            <button type="button" onclick="showDeleteModal()" type="button" class="bg-red-500 p-2 rounded-lg shadow hover:bg-red-600 transition-colors duration-200">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.167 5.50002H18.3337V7.16669H16.667V18C16.667 18.221 16.5792 18.433 16.4229 18.5893C16.2666 18.7456 16.0547 18.8334 15.8337 18.8334H4.16699C3.94598 18.8334 3.73402 18.7456 3.57774 18.5893C3.42146 18.433 3.33366 18.221 3.33366 18V7.16669H1.66699V5.50002H5.83366V3.00002C5.83366 2.77901 5.92146 2.56704 6.07774 2.41076C6.23402 2.25448 6.44598 2.16669 6.66699 2.16669H13.3337C13.5547 2.16669 13.7666 2.25448 13.9229 2.41076C14.0792 2.56704 14.167 2.77901 14.167 3.00002V5.50002ZM15.0003 7.16669H5.00033V17.1667H15.0003V7.16669ZM7.50033 3.83335V5.50002H12.5003V3.83335H7.50033Z"
                                        fill="white" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="tambahModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <form method="POST">
                    @csrf
                    @method('GET')
                    <div class="bg-white rounded-lg shadow-lg p-6 w-96 relative">
                        <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600" onclick="closeTambahModal()">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    <div class="text-center">
                        <h2 class="text-center text-xl font-semibold mb-6">Tambah Akun</h2>
                        <div class="relative mb-4">
                                <label class="mb-2 block text-md font-medium text-left">Nama</label>
                                <input type="text" class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama"/>
                            </div>
                            <div class="relative mb-4">
                                <label class="mb-2 block text-md font-medium text-left">Role</label>
                                <select class="w-full rounded border border-gray-300 p-3">
                                    <option selected disabled>Masukkan Role</option>
                                    <option>Super Admin</option>
                                    <option>SIMKLINIK</option>
                                    <option>Dokter</option>
                                    <option>Apoteker</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label class="mb-2 block text-md font-medium text-left">Email</label>
                                <input type="text" class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan email"/>
                            </div>
                            <div class="mb-6">
                                <label class="mb-2 block text-md font-medium text-left">Kata sandi</label>
                                <input type="password" class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan kata sandi"/>
                            </div>
                    </div>
                    <div class="flex justify-center space-x-4">
                        <button onclick="closeAddUserModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none">
                            Batal
                        </button>
                        <button onclick="addUserModal()" type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <form method="POST">
                @csrf
                @method('POST')
                <div class="bg-white rounded-lg shadow-lg p-6 w-96 relative">
                    <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600" onclick="closeEditModal()">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                <div class="text-center">
                    <h2 class="text-center text-xl font-semibold mb-6">Ubah Akun</h2>
                    <div class="relative mb-4">
                            <label class="mb-2 block text-md font-medium text-left">Nama</label>
                            <input type="text" class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama"/>
                        </div>
                        <div class="relative mb-4">
                            <label class="mb-2 block text-md font-medium text-left">Role</label>
                            <select class="w-full rounded border border-gray-300 p-3">
                                <option selected disabled>Masukkan Role</option>
                                <option>Super Admin</option>
                                <option>SIMKLINIK</option>
                                <option>Dokter</option>
                                <option>Apoteker</option>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label class="mb-2 block text-md font-medium text-left">Email</label>
                            <input type="text" class="w-full rounded-lg border px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan email"/>
                        </div>
                </div>
                <div class="flex justify-center space-x-4">
                    <button onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none">
                        Batal
                    </button>
                    <button onclick="submitEdirForm()" type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96 relative">
            <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600" onclick="closeDeleteModal()">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Anda yakin untuk menghapus data ini?</h3>
                <p class="text-sm text-gray-500 mb-5">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="flex justify-center space-x-4">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none">
                    Batal</button>
                <button onclick="deleteItem()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none">
                    Hapus</button>
            </div>
        </div>
    </div>
    <div id="saveModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96 relative">
            <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600" onclick="closeSaveModal()">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Apakah Anda yakin ingin menyimpan transaksi ini?</h3>
                <p class="text-sm text-gray-500 mb-5">Pastikan semua data sudah benar sebelum menyimpan.</p>
            </div>
            <div class="flex justify-center space-x-4">
                <button onclick="closeSaveModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none">
                    Batal
                </button>
                <button onclick="submitForm()" type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none">
                    Simpan
                </button>
            </div>
        </div>
    </div>  
@endsection

<script>
    function showDeleteModal(index) {
        deleteForItem = index;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function showEditModal() {
        document.getElementById('editModal').classList.remove('hidden');
    }

    function showTambahModal() {
        document.getElementById('tambahModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function closeTambahModal() {
        document.getElementById('tambahModal').classList.add('hidden');
    }

    function addUserModal() {
        document.getElementById('saveModal').classList.remove('hidden');
    }

    function closeAddUserModal() {
        document.getElementById('saveModal').classList.add('hidden');
    }
    function showSaveModal() {
        document.getElementById('saveModal').classList.remove('hidden');
    }

    function closeSaveModal() {
        document.getElementById('saveModal').classList.add('hidden');
    }
    function submitEdirForm() {
        document.getElementById('saveModal').classList.remove('hidden');
    }

    function closeSubmitEdirForm() {
        document.getElementById('saveModal').classList.add('hidden');
    }
        
</script>
