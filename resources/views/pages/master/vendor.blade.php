@extends('layouts.main')
@section('container')
<div class="p-6 bg-white rounded-lg shadow-lg">
    <div class="flex justify-between mb-4">
        <div>
            <button onclick="showTambahModal()" class="bg-blue-500 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition-colors duration-200">+ Tambah</button>
        </div>
        <div class="flex justify-end">
            <form action="">
                <input type="text" name="" id="" placeholder="Search..." class="ring-2 ring-gray-300 rounded-full px-6 py-2 mb-4">
            </form>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden mt-6">
        <table class="min-w-full text-sm text-center">
            <thead>
                <tr class="bg-gray-200">
                    <th class="py-3 px-6  w-1">No</th>
                    <th class="py-3 px-6">Nama Vendor</th>
                    <th class="py-3 px-6">Telepon</th>
                    <th class="py-3 px-6">Alamat</th>
                    <th class="py-3 px-6">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach ($vendors as $number => $item)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6">{{ $loop->iteration + ($vendors->currentPage() - 1) * $vendors->perPage() }}</td>
                    <td class="py-3 px-6 text-left">{{ $item->name }}</td>
                    <td class="py-3 px-6">{{ $item->phone }}</td>
                    <td class="py-3 px-6 text-left">{{ $item->address }}</td>
                    <form id="delete-form-{{ $item->id }}" action="{{ route('master.vendor.destroy',$item->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                    </form>
                    <td class="py-3 px-6 flex justify-center">
                        <a onclick="showEditModal('{{ $item->name }}','{{ $item->address }}','{{ $item->phone }}','{{ $item->id }}')"
                            class="flex cursor-pointer items-center bg-yellow-300 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-yellow-400 transition-colors duration-200 mr-2">
                            <svg width="20" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.728 9.68602L14.314 8.27202L5 17.586V19H6.414L15.728 9.68602ZM17.142 8.27202L18.556 6.85802L17.142 5.44402L15.728 6.85802L17.142 8.27202ZM7.242 21H3V16.757L16.435 3.32202C16.6225 3.13455 16.8768 3.02924 17.142 3.02924C17.4072 3.02924 17.6615 3.13455 17.849 3.32202L20.678 6.15102C20.8655 6.33855 20.9708 6.59286 20.9708 6.85802C20.9708 7.12319 20.8655 7.37749 20.678 7.56502L7.243 21H7.242Z" fill="white" />
                            </svg>
                        </a>
                        <button type="button" onclick="showModal('delete','delete-form-{{ $item->id }}')"
                            class="bg-red-500 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-red-600">
                            <svg width="20" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.167 5.50002H18.3337V7.16669H16.667V18C16.667 18.221 16.5792 18.433 16.4229 18.5893C16.2666 18.7456 16.0547 18.8334 15.8337 18.8334H4.16699C3.94598 18.8334 3.73402 18.7456 3.57774 18.5893C3.42146 18.433 3.33366 18.221 3.33366 18V7.16669H1.66699V5.50002H5.83366V3.00002C5.83366 2.77901 5.92146 2.56704 6.07774 2.41076C6.23402 2.25448 6.44598 2.16669 6.66699 2.16669H13.3337C13.5547 2.16669 13.7666 2.25448 13.9229 2.41076C14.0792 2.56704 14.167 2.77901 14.167 3.00002V5.50002ZM15.0003 7.16669H5.00033V17.1667H15.0003V7.16669ZM7.50033 3.83335V5.50002H12.5003V3.83335H7.50033Z" fill="white" />
                            </svg>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-6">
        {{ $vendors->links() }}
    </div>
</div>
<div id="tambahModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 w-96 relative">
        <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600"
            onclick="closeTambahModal()">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
            </svg>
            <span class="sr-only">Close modal</span>
        </button>
        <h2 class="text-center text-xl font-semibold mb-6">Tambah Vendor</h2>
        <form id="create-vendor-form" action="{{ route('master.vendor.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="name">Nama</label>
                <input class="w-full px-3 py-2 border rounded-lg" type="text" id="name" name="name">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 mb-2" for="phone">Telepon</label>
                <input class="w-full px-3 py-2 border rounded-lg" type="text" id="phone" name="phone">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 mb-2" for="address">Alamat</label>
                <input class="w-full px-3 py-2 border rounded-lg" type="text" id="address" name="address">
            </div>
            <div class="flex justify-center space-x-4 mt-4">
                <button type="button" id="closeModal" onclick="closeTambahModal()"
                    class="px-4 py-2 border rounded-lg text-gray-700 border-gray-300 bg-gray-200 hover:bg-gray-300 w-full flex-1">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white hover:bg-blue-700 rounded-lg w-full flex-1">Tambah</button>
            </div>
        </form>
    </div>
</div>
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
        <h2 class="text-center text-xl font-semibold mb-6">Ubah Vendor</h2>
        <form id="edit-vendor-form" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-start text-gray-700 mb-2" for="name">Nama</label>
                <input class="w-full px-3 py-2 border rounded-lg" type="text" id="name" name="name">
            </div>
            <div class="mb-4">
                <label class="block text-start text-gray-700 mb-2" for="phone">Telepon</label>
                <input class="w-full px-3 py-2 border rounded-lg" type="text" id="phone" name="phone">
            </div>
            <div class="mb-6">
                <label class="block text-start text-gray-700 mb-2" for="address">Alamat</label>
                <input class="w-full px-3 py-2 border rounded-lg" type="text" id="address" name="address">
            </div>

            <div class="flex justify-center space-x-4 mt-4">
                <button type="button" id="closeModal" onclick="closeEditModal()"
                    class="px-4 py-2 border rounded-lg text-gray-700 border-gray-300 bg-gray-200 hover:bg-gray-300 w-full flex-1">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white hover:bg-blue-700 rounded-lg w-full flex-1">Edit</button>
            </div>
        </form>
    </div>
</div>


<script>
    function showEditModal(name, address, phone, id) {
        document.querySelector('#editModal input[name="name"]').value = name;
        document.querySelector('#editModal input[name="address"]').value = address;
        document.querySelector('#editModal input[name="phone"]').value = phone;
        document.querySelector('#editModal form').setAttribute('action', `{{ route('master.vendor.index') }}/${id}`);
        document.getElementById('editModal').classList.remove('hidden');
    }

    function showTambahModal() {
        document.getElementById('tambahModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function closeTambahModal() {
        document.getElementById('tambahModal').classList.add('hidden');
    }
    document.getElementById('edit-vendor-form').addEventListener('submit', function(e) {
        e.preventDefault()
        closeEditModal()
        showModal('save', 'edit-vendor-form')
    })
    document.getElementById('create-vendor-form').addEventListener('submit', function(e) {
        e.preventDefault()
        closeTambahModal()
        showModal('add', 'create-vendor-form')
    })
</script>
@endsection