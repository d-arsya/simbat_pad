@extends('layouts.main')
@section('container')

<div class="p-6 bg-white rounded-lg shadow-lg">
    <div class="max-w-7xl mx-auto">

        <div class="mb-4">
            <a href="{{ route('clinic.inflows.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 text-base rounded-lg flex items-center shadow" style="width: 125px;">
                <i class="fas fa-plus mr-1 text-xs"></i> + Tambah
            </a>
        </div>


        <div class="bg-white shadow-md rounded-lg overflow-hidden w-full">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-200 text-black text-sm leading-normal">
                        <th class="py-3 px-6 text-center w-1">No</th>
                        <th class="py-3 px-6 text-center">Kode LPB</th>
                        <th class="py-3 px-6 text-center">Nama Vendor</th>
                        <th class="py-3 px-6 text-center">Tanggal Masuk</th>
                        <th class="py-3 px-6 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-light">
                    @foreach ($transactions as $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}</td>
                        <td class="py-3 px-6 text-center">{{ $item->code }}</td>
                        <td class="py-3 px-6 text-left">Klinik Simbat</td>
                        <td class="py-3 px-6 text-center">{{ $item->created_at }}</td>
                        <td class="flex justify-center py-3">
                            <a href="{{ route('clinic.inflows.show', $item->id) }}" class="bg-blue-500 hover:bg-blue-600 p-2 rounded-md">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.99972 2.5C14.4931 2.5 18.2314 5.73333 19.0156 10C18.2322 14.2667 14.4931 17.5 9.99972 17.5C5.50639 17.5 1.76805 14.2667 0.983887 10C1.76722 5.73333 5.50639 2.5 9.99972 2.5ZM9.99972 15.8333C11.6993 15.833 13.3484 15.2557 14.6771 14.196C16.0058 13.1363 16.9355 11.6569 17.3139 10C16.9341 8.34442 16.0038 6.86667 14.6752 5.80835C13.3466 4.75004 11.6983 4.17377 9.99972 4.17377C8.30113 4.17377 6.65279 4.75004 5.3242 5.80835C3.9956 6.86667 3.06536 8.34442 2.68555 10C3.06397 11.6569 3.99361 13.1363 5.32234 14.196C6.65106 15.2557 8.30016 15.833 9.99972 15.8333V15.8333ZM9.99972 13.75C9.00516 13.75 8.05133 13.3549 7.34807 12.6516C6.64481 11.9484 6.24972 10.9946 6.24972 10C6.24972 9.00544 6.64481 8.05161 7.34807 7.34835C8.05133 6.64509 9.00516 6.25 9.99972 6.25C10.9943 6.25 11.9481 6.64509 12.6514 7.34835C13.3546 8.05161 13.7497 9.00544 13.7497 10C13.7497 10.9946 13.3546 11.9484 12.6514 12.6516C11.9481 13.3549 10.9943 13.75 9.99972 13.75ZM9.99972 12.0833C10.5523 12.0833 11.0822 11.8638 11.4729 11.4731C11.8636 11.0824 12.0831 10.5525 12.0831 10C12.0831 9.44747 11.8636 8.91756 11.4729 8.52686C11.0822 8.13616 10.5523 7.91667 9.99972 7.91667C9.44719 7.91667 8.91728 8.13616 8.52658 8.52686C8.13588 8.91756 7.91639 9.44747 7.91639 10C7.91639 10.5525 8.13588 11.0824 8.52658 11.4731C8.91728 11.8638 9.44719 12.0833 9.99972 12.0833Z" fill="white" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-6">
        {{ $transactions->links() }}
    </div>
</div>

@endsection
