@extends('layouts.main')
@section('container')
<div class="p-6 bg-white rounded-lg shadow-lg">
    <div class="flex justify-between mb-4">
        <a href="{{ route('master.drug.create') }}">
            <button class="bg-blue-500 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-blue-600">+ Tambah</button>
        </a>
        <input type="text" name="drug-search" id="drug-search" placeholder="Search..."
            class="ring-2 ring-gray-300 rounded-full px-6 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
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
            <tbody id="drug-value"></tbody>
            <tbody id="drug-data" class="text-gray-700">
                @foreach ($drugs as $number => $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $loop->iteration + ($drugs->currentPage() - 1) * $drugs->perPage() }}</td>
                        <td class="py-3 px-6">{{ $item->code }}</td>
                        <td class="py-3 px-6 text-left">{{ $item->name }}</td>
                        <form id="delete-form-{{ $item->id }}" action="{{ route('master.drug.destroy',$item->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                        </form>
                        <td class="py-3 px-6 flex justify-center">
                            <a href="{{ route('master.drug.edit', $item->id) }}"
                                class="h-max flex items-center bg-blue-500 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-blue-600 mr-2">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.99972 2.5C14.4931 2.5 18.2314 5.73333 19.0156 10C18.2322 14.2667 14.4931 17.5 9.99972 17.5C5.50639 17.5 1.76805 14.2667 0.983887 10C1.76722 5.73333 5.50639 2.5 9.99972 2.5ZM9.99972 15.8333C11.6993 15.833 13.3484 15.2557 14.6771 14.196C16.0058 13.1363 16.9355 11.6569 17.3139 10C16.9341 8.34442 16.0038 6.86667 14.6752 5.80835C13.3466 4.75004 11.6983 4.17377 9.99972 4.17377C8.30113 4.17377 6.65279 4.75004 5.3242 5.80835C3.9956 6.86667 3.06536 8.34442 2.68555 10C3.06397 11.6569 3.99361 13.1363 5.32234 14.196C6.65106 15.2557 8.30016 15.833 9.99972 15.8333V15.8333ZM9.99972 13.75C9.00516 13.75 8.05133 13.3549 7.34807 12.6516C6.64481 11.9484 6.24972 10.9946 6.24972 10C6.24972 9.00544 6.64481 8.05161 7.34807 7.34835C8.05133 6.64509 9.00516 6.25 9.99972 6.25C10.9943 6.25 11.9481 6.64509 12.6514 7.34835C13.3546 8.05161 13.7497 9.00544 13.7497 10C13.7497 10.9946 13.3546 11.9484 12.6514 12.6516C11.9481 13.3549 10.9943 13.75 9.99972 13.75ZM9.99972 12.0833C10.5523 12.0833 11.0822 11.8638 11.4729 11.4731C11.8636 11.0824 12.0831 10.5525 12.0831 10C12.0831 9.44747 11.8636 8.91756 11.4729 8.52686C11.0822 8.13616 10.5523 7.91667 9.99972 7.91667C9.44719 7.91667 8.91728 8.13616 8.52658 8.52686C8.13588 8.91756 7.91639 9.44747 7.91639 10C7.91639 10.5525 8.13588 11.0824 8.52658 11.4731C8.91728 11.8638 9.44719 12.0833 9.99972 12.0833Z" fill="white"/>
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
        {{ $drugs->links() }}
    </div>
</div>
<script>
    let timeout = null;
        const drugInput = document.getElementById('drug-search')
        drugInput.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value;
            timeout = setTimeout(() => {
                if (query.length > 0) {
                    document.getElementById('drug-data').classList.add('hidden')
                    document.getElementById('drug-value').classList.remove('hidden')
                    fetch(`/drug-search?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            const suggestions = document.getElementById('drug-value');
                            suggestions.innerHTML = '';

                            if (data.length > 0) {
                                data.forEach((item,number) => {
                                    suggestions.innerHTML += `<tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">${number+1}</td>
                        <td class="py-3 px-6">${item.code}</td>
                        <td class="py-3 px-6 text-left">${item.name}</td>
                        <td class="py-3 px-6 flex justify-center">
                            <a href="/master/drug/${item.id}/edit"
                                class="h-max flex items-center bg-blue-500 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-blue-600 mr-2">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.99972 2.5C14.4931 2.5 18.2314 5.73333 19.0156 10C18.2322 14.2667 14.4931 17.5 9.99972 17.5C5.50639 17.5 1.76805 14.2667 0.983887 10C1.76722 5.73333 5.50639 2.5 9.99972 2.5ZM9.99972 15.8333C11.6993 15.833 13.3484 15.2557 14.6771 14.196C16.0058 13.1363 16.9355 11.6569 17.3139 10C16.9341 8.34442 16.0038 6.86667 14.6752 5.80835C13.3466 4.75004 11.6983 4.17377 9.99972 4.17377C8.30113 4.17377 6.65279 4.75004 5.3242 5.80835C3.9956 6.86667 3.06536 8.34442 2.68555 10C3.06397 11.6569 3.99361 13.1363 5.32234 14.196C6.65106 15.2557 8.30016 15.833 9.99972 15.8333V15.8333ZM9.99972 13.75C9.00516 13.75 8.05133 13.3549 7.34807 12.6516C6.64481 11.9484 6.24972 10.9946 6.24972 10C6.24972 9.00544 6.64481 8.05161 7.34807 7.34835C8.05133 6.64509 9.00516 6.25 9.99972 6.25C10.9943 6.25 11.9481 6.64509 12.6514 7.34835C13.3546 8.05161 13.7497 9.00544 13.7497 10C13.7497 10.9946 13.3546 11.9484 12.6514 12.6516C11.9481 13.3549 10.9943 13.75 9.99972 13.75ZM9.99972 12.0833C10.5523 12.0833 11.0822 11.8638 11.4729 11.4731C11.8636 11.0824 12.0831 10.5525 12.0831 10C12.0831 9.44747 11.8636 8.91756 11.4729 8.52686C11.0822 8.13616 10.5523 7.91667 9.99972 7.91667C9.44719 7.91667 8.91728 8.13616 8.52658 8.52686C8.13588 8.91756 7.91639 9.44747 7.91639 10C7.91639 10.5525 8.13588 11.0824 8.52658 11.4731C8.91728 11.8638 9.44719 12.0833 9.99972 12.0833Z" fill="white"/>
                                </svg>
                            </a>
                            <button type="button" onclick="showModal('delete','delete-form-${item.id}')"
                                class="bg-red-500 text-white text-sm px-2 py-2 rounded-lg shadow hover:bg-red-600">
                                <svg width="20" height="21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.167 5.50002H18.3337V7.16669H16.667V18C16.667 18.221 16.5792 18.433 16.4229 18.5893C16.2666 18.7456 16.0547 18.8334 15.8337 18.8334H4.16699C3.94598 18.8334 3.73402 18.7456 3.57774 18.5893C3.42146 18.433 3.33366 18.221 3.33366 18V7.16669H1.66699V5.50002H5.83366V3.00002C5.83366 2.77901 5.92146 2.56704 6.07774 2.41076C6.23402 2.25448 6.44598 2.16669 6.66699 2.16669H13.3337C13.5547 2.16669 13.7666 2.25448 13.9229 2.41076C14.0792 2.56704 14.167 2.77901 14.167 3.00002V5.50002ZM15.0003 7.16669H5.00033V17.1667H15.0003V7.16669ZM7.50033 3.83335V5.50002H12.5003V3.83335H7.50033Z" fill="white" />
                                </svg>
                            </button>
                        </td>
                    </tr>`
                                });
                            }
                        });
                } else {
                    document.getElementById('drug-data').classList.remove('hidden')
                    document.getElementById('drug-value').classList.add('hidden')
                }
            }, 400);
        });
</script>
@endsection
