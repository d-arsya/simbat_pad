@extends('layouts.main')
@section('container')
    <div class="p-6 bg-white rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('user.create') }}">
                <button
                    class="bg-green-500 text-white font-semibold px-6 py-2 rounded-lg shadow hover:bg-green-600 transition-colors duration-200">+
                    Tambah User</button>
            </a>
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
                            <a href="{{ route('user.edit', 1) }}"
                                class="flex items-center bg-yellow-300 p-2 rounded-lg shadow hover:bg-yellow-400 transition-colors duration-200 mr-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15.728 9.68602L14.314 8.27202L5 17.586V19H6.414L15.728 9.68602ZM17.142 8.27202L18.556 6.85802L17.142 5.44402L15.728 6.85802L17.142 8.27202ZM7.242 21H3V16.757L16.435 3.32202C16.6225 3.13455 16.8768 3.02924 17.142 3.02924C17.4072 3.02924 17.6615 3.13455 17.849 3.32202L20.678 6.15102C20.8655 6.33855 20.9708 6.59286 20.9708 6.85802C20.9708 7.12319 20.8655 7.37749 20.678 7.56502L7.243 21H7.242Z"
                                        fill="white" />
                                </svg>
                            </a>
                            <button type="button"
                                class="bg-red-500 p-2 rounded-lg shadow hover:bg-red-600 transition-colors duration-200">
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
@endsection