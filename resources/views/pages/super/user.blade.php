@extends('layouts.main')
@section('container')
    <div class="p-6 bg-white rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Manage Account</h2>

        <div class="flex justify-between items-center mb-4">
            <!-- Add Button -->
            <a href="{{ route('user.create') }}">
                <button
                    class="bg-green-500 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-green-600 transition-colors duration-200">+
                    Add User</button>
            </a>
            <form action="">
                <input type="text" name="" id="" placeholder="Search..."
                    class="ring-2 ring-gray-300 rounded-full px-6 py-2">
            </form>
        </div>


        <!-- Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-200 text-black uppercase text-sm leading-normal">
                        <th class="w-1 py-3 px-6 text-center w-1">NO</th>
                        <th class="w-32 py-3 px-6 text-center">NAME</th>
                        <th class="w-24 py-3 px-6 text-center">ROLE</th>
                        <th class="w-24 py-3 px-6 text-center">EMAIL</th>
                        <th class="w-48 py-3 px-6 text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-light">
                    <!-- Data Row 1 -->
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-center">1</td>
                        <td class="py-3 px-6 text-left">Lorem Ipsun</td>
                        <td class="py-3 px-6 text-center">Dokter</td>
                        <td class="py-3 px-6 text-left">loremIpsun@mail.com</td>
                        <td class="flex justify-center gap-2 py-3">
                            <a href="{{ route('user.edit', 1) }}"
                                class="flex items-center bg-yellow-300 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-yellow-400 transition-colors duration-200 mr-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.728 9.68602L14.314 8.27202L5 17.586V19H6.414L15.728 9.68602ZM17.142 8.27202L18.556 6.85802L17.142 5.44402L15.728 6.85802L17.142 8.27202ZM7.242 21H3V16.757L16.435 3.32202C16.6225 3.13455 16.8768 3.02924 17.142 3.02924C17.4072 3.02924 17.6615 3.13455 17.849 3.32202L20.678 6.15102C20.8655 6.33855 20.9708 6.59286 20.9708 6.85802C20.9708 7.12319 20.8655 7.37749 20.678 7.56502L7.243 21H7.242Z"
                                        fill="white" />
                                </svg>
                            </a>
                            <button type="button" onclick="showDeleteModal(1)"
                                class="bg-red-500 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-red-600 transition-colors duration-200">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.167 5.50002H18.3337V7.16669H16.667V18C16.667 18.221 16.5792 18.433 16.4229 18.5893C16.2666 18.7456 16.0547 18.8334 15.8337 18.8334H4.16699C3.94598 18.8334 3.73402 18.7456 3.57774 18.5893C3.42146 18.433 3.33366 18.221 3.33366 18V7.16669H1.66699V5.50002H5.83366V3.00002C5.83366 2.77901 5.92146 2.56704 6.07774 2.41076C6.23402 2.25448 6.44598 2.16669 6.66699 2.16669H13.3337C13.5547 2.16669 13.7666 2.25448 13.9229 2.41076C14.0792 2.56704 14.167 2.77901 14.167 3.00002V5.50002ZM15.0003 7.16669H5.00033V17.1667H15.0003V7.16669ZM7.50033 3.83335V5.50002H12.5003V3.83335H7.50033Z"
                                        fill="white" />
                                </svg>
                            </button>
                        </td>
                        <div id="deleteModal-1"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center z-50 justify-center hidden">
                            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                                <p class="text-center text-lg font-semibold mb-4">Anda yakin untuk menghapus data ini?</p>
                                <div class="flex justify-center space-x-4">
                                    <form id="deleteForm-1" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="closeDeleteModal(1)"
                                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700">Cancel</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 text-white rounded-lg">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </tr>
                    <!-- Data Row 2 -->
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-center">2</td>
                        <td class="py-3 px-6 text-left">Lorem Ipsun</td>
                        <td class="py-3 px-6 text-center">Dokter</td>
                        <td class="py-3 px-6 text-left">loremIpsun@mail.com</td>
                        <td class="flex justify-center gap-2 py-3">
                            <a href="{{ route('user.edit', 1) }}"
                                class="flex items-center bg-yellow-300 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-yellow-400 transition-colors duration-200 mr-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.728 9.68602L14.314 8.27202L5 17.586V19H6.414L15.728 9.68602ZM17.142 8.27202L18.556 6.85802L17.142 5.44402L15.728 6.85802L17.142 8.27202ZM7.242 21H3V16.757L16.435 3.32202C16.6225 3.13455 16.8768 3.02924 17.142 3.02924C17.4072 3.02924 17.6615 3.13455 17.849 3.32202L20.678 6.15102C20.8655 6.33855 20.9708 6.59286 20.9708 6.85802C20.9708 7.12319 20.8655 7.37749 20.678 7.56502L7.243 21H7.242Z"
                                        fill="white" />
                                </svg>
                            </a>
                            <button type="button" onclick="showDeleteModal(1)"
                                class="bg-red-500 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-red-600 transition-colors duration-200">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.167 5.50002H18.3337V7.16669H16.667V18C16.667 18.221 16.5792 18.433 16.4229 18.5893C16.2666 18.7456 16.0547 18.8334 15.8337 18.8334H4.16699C3.94598 18.8334 3.73402 18.7456 3.57774 18.5893C3.42146 18.433 3.33366 18.221 3.33366 18V7.16669H1.66699V5.50002H5.83366V3.00002C5.83366 2.77901 5.92146 2.56704 6.07774 2.41076C6.23402 2.25448 6.44598 2.16669 6.66699 2.16669H13.3337C13.5547 2.16669 13.7666 2.25448 13.9229 2.41076C14.0792 2.56704 14.167 2.77901 14.167 3.00002V5.50002ZM15.0003 7.16669H5.00033V17.1667H15.0003V7.16669ZM7.50033 3.83335V5.50002H12.5003V3.83335H7.50033Z"
                                        fill="white" />
                                </svg>
                            </button>
                        </td>
                        <div id="deleteModal-1"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center z-50 justify-center hidden">
                            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                                <p class="text-center text-lg font-semibold mb-4">Anda yakin untuk menghapus data ini?</p>
                                <div class="flex justify-center space-x-4">
                                    <form id="deleteForm-1" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="closeDeleteModal(1)"
                                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700">Cancel</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 text-white rounded-lg">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </tr>
                    <!-- Data Row 3 -->
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-center">3</td>
                        <td class="py-3 px-6 text-left">Lorem Ipsun</td>
                        <td class="py-3 px-6 text-center">Apoteker</td>
                        <td class="py-3 px-6 text-left">loremIpsun@mail.com</td>
                        <td class="flex justify-center gap-2 py-3">
                            <a href="{{ route('user.edit', 1) }}"
                                class="flex items-center bg-yellow-300 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-yellow-400 transition-colors duration-200 mr-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.728 9.68602L14.314 8.27202L5 17.586V19H6.414L15.728 9.68602ZM17.142 8.27202L18.556 6.85802L17.142 5.44402L15.728 6.85802L17.142 8.27202ZM7.242 21H3V16.757L16.435 3.32202C16.6225 3.13455 16.8768 3.02924 17.142 3.02924C17.4072 3.02924 17.6615 3.13455 17.849 3.32202L20.678 6.15102C20.8655 6.33855 20.9708 6.59286 20.9708 6.85802C20.9708 7.12319 20.8655 7.37749 20.678 7.56502L7.243 21H7.242Z"
                                        fill="white" />
                                </svg>
                            </a>
                            <button type="button" onclick="showDeleteModal(1)"
                                class="bg-red-500 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-red-600 transition-colors duration-200">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.167 5.50002H18.3337V7.16669H16.667V18C16.667 18.221 16.5792 18.433 16.4229 18.5893C16.2666 18.7456 16.0547 18.8334 15.8337 18.8334H4.16699C3.94598 18.8334 3.73402 18.7456 3.57774 18.5893C3.42146 18.433 3.33366 18.221 3.33366 18V7.16669H1.66699V5.50002H5.83366V3.00002C5.83366 2.77901 5.92146 2.56704 6.07774 2.41076C6.23402 2.25448 6.44598 2.16669 6.66699 2.16669H13.3337C13.5547 2.16669 13.7666 2.25448 13.9229 2.41076C14.0792 2.56704 14.167 2.77901 14.167 3.00002V5.50002ZM15.0003 7.16669H5.00033V17.1667H15.0003V7.16669ZM7.50033 3.83335V5.50002H12.5003V3.83335H7.50033Z"
                                        fill="white" />
                                </svg>
                            </button>
                        </td>
                        <div id="deleteModal-1"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center z-50 justify-center hidden">
                            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                                <p class="text-center text-lg font-semibold mb-4">Anda yakin untuk menghapus data ini?</p>
                                <div class="flex justify-center space-x-4">
                                    <form id="deleteForm-1" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="closeDeleteModal(1)"
                                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700">Cancel</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 text-white rounded-lg">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </tr>
                    <!-- Data Row 4 -->
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-center">4</td>
                        <td class="py-3 px-6 text-left">Lorem Ipsun</td>
                        <td class="py-3 px-6 text-center">Super Admin</td>
                        <td class="py-3 px-6 text-left">loremIpsun@mail.com</td>
                        <td class="flex justify-center gap-2 py-3">
                            <a href="{{ route('user.edit', 1) }}"
                                class="flex items-center bg-yellow-300 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-yellow-400 transition-colors duration-200 mr-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.728 9.68602L14.314 8.27202L5 17.586V19H6.414L15.728 9.68602ZM17.142 8.27202L18.556 6.85802L17.142 5.44402L15.728 6.85802L17.142 8.27202ZM7.242 21H3V16.757L16.435 3.32202C16.6225 3.13455 16.8768 3.02924 17.142 3.02924C17.4072 3.02924 17.6615 3.13455 17.849 3.32202L20.678 6.15102C20.8655 6.33855 20.9708 6.59286 20.9708 6.85802C20.9708 7.12319 20.8655 7.37749 20.678 7.56502L7.243 21H7.242Z"
                                        fill="white" />
                                </svg>
                            </a>
                            <button type="button" onclick="showDeleteModal(1)"
                                class="bg-red-500 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-red-600 transition-colors duration-200">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.167 5.50002H18.3337V7.16669H16.667V18C16.667 18.221 16.5792 18.433 16.4229 18.5893C16.2666 18.7456 16.0547 18.8334 15.8337 18.8334H4.16699C3.94598 18.8334 3.73402 18.7456 3.57774 18.5893C3.42146 18.433 3.33366 18.221 3.33366 18V7.16669H1.66699V5.50002H5.83366V3.00002C5.83366 2.77901 5.92146 2.56704 6.07774 2.41076C6.23402 2.25448 6.44598 2.16669 6.66699 2.16669H13.3337C13.5547 2.16669 13.7666 2.25448 13.9229 2.41076C14.0792 2.56704 14.167 2.77901 14.167 3.00002V5.50002ZM15.0003 7.16669H5.00033V17.1667H15.0003V7.16669ZM7.50033 3.83335V5.50002H12.5003V3.83335H7.50033Z"
                                        fill="white" />
                                </svg>
                            </button>
                        </td>
                        <div id="deleteModal-1"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center z-50 justify-center hidden">
                            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                                <p class="text-center text-lg font-semibold mb-4">Anda yakin untuk menghapus data ini?</p>
                                <div class="flex justify-center space-x-4">
                                    <form id="deleteForm-1" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="closeDeleteModal(1)"
                                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700">Cancel</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 text-white rounded-lg">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </tr>
                    <!-- Data Row 5 -->
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-center">5</td>
                        <td class="py-3 px-6 text-left">Lorem Ipsun</td>
                        <td class="py-3 px-6 text-center">Apoteker</td>
                        <td class="py-3 px-6 text-left">loremIpsun@mail.com</td>
                        <td class="flex justify-center gap-2 py-3">
                            <a href="{{ route('user.edit', 1) }}"
                                class="flex items-center bg-yellow-300 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-yellow-400 transition-colors duration-200 mr-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.728 9.68602L14.314 8.27202L5 17.586V19H6.414L15.728 9.68602ZM17.142 8.27202L18.556 6.85802L17.142 5.44402L15.728 6.85802L17.142 8.27202ZM7.242 21H3V16.757L16.435 3.32202C16.6225 3.13455 16.8768 3.02924 17.142 3.02924C17.4072 3.02924 17.6615 3.13455 17.849 3.32202L20.678 6.15102C20.8655 6.33855 20.9708 6.59286 20.9708 6.85802C20.9708 7.12319 20.8655 7.37749 20.678 7.56502L7.243 21H7.242Z"
                                        fill="white" />
                                </svg>
                            </a>
                            <button type="button" onclick="showDeleteModal(1)"
                                class="bg-red-500 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-red-600 transition-colors duration-200">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.167 5.50002H18.3337V7.16669H16.667V18C16.667 18.221 16.5792 18.433 16.4229 18.5893C16.2666 18.7456 16.0547 18.8334 15.8337 18.8334H4.16699C3.94598 18.8334 3.73402 18.7456 3.57774 18.5893C3.42146 18.433 3.33366 18.221 3.33366 18V7.16669H1.66699V5.50002H5.83366V3.00002C5.83366 2.77901 5.92146 2.56704 6.07774 2.41076C6.23402 2.25448 6.44598 2.16669 6.66699 2.16669H13.3337C13.5547 2.16669 13.7666 2.25448 13.9229 2.41076C14.0792 2.56704 14.167 2.77901 14.167 3.00002V5.50002ZM15.0003 7.16669H5.00033V17.1667H15.0003V7.16669ZM7.50033 3.83335V5.50002H12.5003V3.83335H7.50033Z"
                                        fill="white" />
                                </svg>
                            </button>
                        </td>
                        <div id="deleteModal-1"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center z-50 justify-center hidden">
                            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                                <p class="text-center text-lg font-semibold mb-4">Anda yakin untuk menghapus data ini?</p>
                                <div class="flex justify-center space-x-4">
                                    <form id="deleteForm-1" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="closeDeleteModal(1)"
                                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700">Cancel</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 text-white rounded-lg">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
            <!-- Toast Success -->
        <!-- session('success') -->
        <div id="toast-success" class="fixed hidden right-5 top-5 mb-4 flex w-full max-w-xs items-center rounded-lg bg-white p-4 text-gray-500 shadow light:bg-gray-800 light:text-gray-400" role="alert">
            <div class="inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-green-100 text-green-500 light:bg-green-800 light:text-green-200">
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span class="sr-only">Check icon</span></div>
            <div class="ml-3 text-sm font-normal">{{ session('success') }}</div>
            <button type="button" onclick="" class="-mx-1.5 -my-1.5 ml-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-white p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-900 focus:ring-2 focus:ring-gray-300 light:bg-gray-800 light:text-gray-500 light:hover:bg-gray-700 light:hover:text-white"
                aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
@endsection

<script>
    function showDeleteModal(id) {
        document.getElementById('deleteForm-' + id).setAttribute('action', `category/${id}`);
        document.getElementById('deleteModal-' + id).classList.remove('hidden');
    }

    function closeDeleteModal(id) {
        // Menyembunyikan modal dengan id unik
        document.getElementById('deleteModal-' + id).classList.add('hidden');
    }
    function showToast() {
        const toast = document.getElementById('toast-success');
        toast.classList.remove('hidden');
        setTimeout(() => {
            hideToast();
        }, 3000);
    }

    function hideToast() {
        document.getElementById('toast-success').classList.add('hidden');
    }
</script>