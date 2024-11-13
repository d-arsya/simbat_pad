    @extends('layouts.main')

    @section('container')

    <div class="container mx-auto">
    <div class="p-6 bg-white rounded-lg shadow-lg">
        <form action="{{ route('master.drug.store') }}" id="submitForm" method="POST">
            @csrf
            <div class="grid grid-cols-6 gap-6">
                <div class="flex flex-wrap col-span-4">
                    <div class="flex w-full mb-4">
                        <label for="nama_obat" class="w-1/4">Nama Obat</label>
                        <input type="text" id="name" name="name" class="border border-gray-300 rounded p-2 w-3/4" placeholder="Inputkan nama obat">
                    </div>
                    <div class="flex w-full mb-4">
                        <label for="category_id" name="category_id" class="w-1/4">Kategori Obat</label>
                        <select id="category_id" name="category_id" class="border border-gray-300 rounded p-2 w-3/4">
                            <option value="">Pilih Kategori Obat</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex w-full mb-4">
                        <label for="variant_id" class="w-1/4">Jenis Obat</label>
                        <select id="variant_id" name="variant_id" class="border border-gray-300 rounded p-2 w-3/4">
                            <option value="">Pilih Jenis Obat</option>
                            @foreach ($variants as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex w-full mb-4">
                        <label for="manufacture_id" class="w-1/4">Produsen Obat</label>
                        <select id="manufacture_id" name="manufacture_id" class="border border-gray-300 rounded p-2 w-3/4">
                            <option value="">Pilih Produsen Obat</option>
                            @foreach ($manufactures as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex w-full mb-4">
                        <label for="maximum_capacity" class="w-1/4">PKMa</label>
                        <input type="number" id="maximum_capacity" name="maximum_capacity" class="border border-gray-300 rounded p-2 w-3/4" placeholder="Inputkan maksimum PKMa">
                    </div>
                    <div class="flex w-full mb-4">
                        <label for="minimum_capacity" class="w-1/4">PKMi</label>
                        <input type="number" id="minimum_capacity" name="minimum_capacity" class="border border-gray-300 rounded p-2 w-3/4" placeholder="Inputkan minimum PKMi">
                    </div>
                    <table class="w-full">
                        <tbody>
                            <tr>
                                <td rowspan="3" class="w-48">Konversi</td>
                                <td class="py-2 pe-24 pl-2">
                                    <div class="flex">
                                        <input type="number" id="pack_quantity" name="pack_quantity" class="rounded-none rounded-s-lg bg-gray-50 border border-gray-300 text-gray-900 block flex-1 min-w-0 w-full text-sm p-2.5" placeholder="0">
                                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-e-md">
                                            pack/box
                                        </span>
                                    </div>
                                </td>
                                <td class="py-2 pe-24">
                                    <div class="flex">
                                        <input type="number" id="pack_margin" name="pack_margin" class="rounded-none rounded-s-lg bg-gray-50 border border-gray-300 text-gray-900 block flex-1 min-w-0 w-full text-sm p-2.5" placeholder="Margin">
                                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-e-md">
                                            %
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 pe-24 pl-2">
                                    <div class="flex">
                                        <input type="number" id="piece_quantity" name="piece_quantity" class="rounded-none rounded-s-lg bg-gray-50 border border-gray-300 text-gray-900 block flex-1 min-w-0 w-full text-sm p-2.5" placeholder="0">
                                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-e-md">
                                            pcs/pack
                                        </span>
                                    </div>
                                </td>
                                <td class="py-2 pe-24">
                                    <div class="flex">
                                        <input type="number" id="piece_margin" name="piece_margin" class="rounded-none rounded-s-lg bg-gray-50 border border-gray-300 text-gray-900 block flex-1 min-w-0 w-full text-sm p-2.5" placeholder="Margin">
                                        <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-e-md">
                                            %
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2 pe-24 pl-2">
                                    <span class="text-xs italic text-gray-400">Netto</span>
                                    <div class="flex">
                                        <input type="number" id="piece_netto" name="piece_netto" class="rounded-none rounded-s-lg bg-gray-50 border border-gray-300 text-gray-900 block flex-1 min-w-0 w-full text-sm p-2.5" placeholder="Netto">
                                        <select id="piece_unit" name="piece_unit" class="border border-gray-300 rounded-e-lg p-2 w-2/5">
                                            <option value="ml">ml</option>
                                            <option value="gr">gr</option>
                                            <option value="butir">butir</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bg-white border rounded-lg p-6 shadow-sm w-full h-max col-span-2">
                    <div class="flex justify-between items-center">
                        <label for="last_price" class= mr-2">Harga</label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-s-md">
                              Rp
                            </span>
                            <input type="number" id="last_price" name="last_price" class="bg-gray-50 border border-gray-300 text-gray-900 block flex-1 min-w-0 w-40 text-sm p-2.5" placeholder="Inputkan harga">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-e-md">
                              / pcs
                            </span>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-6">
                        <label for="last_discount" class= mr-2">Diskon</label>
                        <div class="flex">
                            <input type="number" id="last_discount" name="last_discount" class="rounded-none rounded-s-lg bg-gray-50 border border-gray-300 text-gray-900 block flex-1 min-w-0 w-full text-sm p-2.5" placeholder="Inputkan discount">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-e-0 border-gray-300 rounded-e-md">
                              %
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="mt-6 text-center">
            <button onclick="showSubmitModal()" class="bg-blue-500 text-white rounded hover:bg-blue-600 px-6 py-2">Simpan</button>
        </div>
    </div>
    <div id="submitModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center z-50 justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <p class="text-center text-lg font-semibold mb-4">Anda yakin untuk menambahkan data ini?</p>
            <div class="flex justify-center space-x-4">
                <button type="button" onclick="closeSubmitModal()" class="px-4 py-2 border border-gray-300 rounded-lg">Batal</button>
                <button type="submit" form="submitForm" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Simpan</button>
            </div>
        </div>
    </div>
@endsection

<script>
    function showSubmitModal() {
        document.getElementById('submitModal').classList.remove('hidden');
    }
    function closeSubmitModal() {   
        document.getElementById('submitModal').classList.add('hidden');
    }
</script>

