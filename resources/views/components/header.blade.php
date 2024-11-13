<div class="flex justify-between items-center p-4">
    <div class="flex justify-between items-center">
        @if (str_contains(request()->route()->getName(),'show') || str_contains(request()->route()->getName(),'create') || str_contains(request()->route()->getName(),'edit'))
        <a href="{{ url()->previous() }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="black" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
              </svg>
        </a>
            
        @endif
        <h1 class="text-2xl font-bold">
            {{ $judul ?? 'SIMBAT' }}
        </h1>

    </div>

    <div class="flex items-center gap-3">
        @if (Request::is('transaction/create'))
            <a href="{{ route('transaction.index') }}" class="bg-yellow-400 hover:bg-yellow-600 px-6 py-2 h-max text-white rounded-xl">
                History

            </a>
        @endif
        <a href="{{ route('transaction.create') }}" class="bg-indigo-200 hover:bg-indigo-500 p-2 h-max rounded-xl">
            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M2 14V2H0V0H3C3.26522 0 3.51957 0.105357 3.70711 0.292893C3.89464 0.48043 4 0.734784 4 1V13H16.438L18.438 5H6V3H19.72C19.872 3 20.022 3.03466 20.1586 3.10134C20.2952 3.16801 20.4148 3.26495 20.5083 3.38479C20.6019 3.50462 20.6668 3.6442 20.6983 3.79291C20.7298 3.94162 20.7269 4.09555 20.69 4.243L18.19 14.243C18.1358 14.4592 18.011 14.6512 17.8352 14.7883C17.6595 14.9255 17.4429 15 17.22 15H3C2.73478 15 2.48043 14.8946 2.29289 14.7071C2.10536 14.5196 2 14.2652 2 14ZM4 21C3.46957 21 2.96086 20.7893 2.58579 20.4142C2.21071 20.0391 2 19.5304 2 19C2 18.4696 2.21071 17.9609 2.58579 17.5858C2.96086 17.2107 3.46957 17 4 17C4.53043 17 5.03914 17.2107 5.41421 17.5858C5.78929 17.9609 6 18.4696 6 19C6 19.5304 5.78929 20.0391 5.41421 20.4142C5.03914 20.7893 4.53043 21 4 21ZM16 21C15.4696 21 14.9609 20.7893 14.5858 20.4142C14.2107 20.0391 14 19.5304 14 19C14 18.4696 14.2107 17.9609 14.5858 17.5858C14.9609 17.2107 15.4696 17 16 17C16.5304 17 17.0391 17.2107 17.4142 17.5858C17.7893 17.9609 18 18.4696 18 19C18 19.5304 17.7893 20.0391 17.4142 20.4142C17.0391 20.7893 16.5304 21 16 21Z"
                    fill="white"/>
            </svg>
        </a>
<div class="relative inline-block text-left">
    <button onclick="toggleModal()" class="flex items-center justify-center w-10 h-10 bg-white border-none rounded-full focus:outline-none">
        <img src="{{ asset('assets/avatar.jpg') }}" alt="Avatar" class="w-10 h-10 rounded-full">
    </button>
</div>
        <div id="modal" class="fixed inset-0 hidden bg-black bg-opacity-50 z-50">
            <div class="bg-white w-72 rounded-lg shadow-lg p-6 absolute top-4 right-4 text-left">
                <button onclick="toggleModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
               <div class="relative w-16 h-16 bg-gray-200 rounded-full flex ml-5 justify-start">
                    <img src="{{ asset('assets/avatar.jpg') }}" alt="Avatar" class="rounded-full w-full h-full">
                    <span class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 rounded-full border-2 border-white"></span>
                </div>

                <div class="mt-4 w-full px-6">
                    <div class="flex items-center text-sm text-gray-600 font-semibold mb-2">
                        <span class="w-20 text-left flex-shrink-0">Username</span>
                        <span class="">:</span>
                        <span class="ml-1">ADMIN123</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 font-semibold mb-2">
                        <span class="w-20 text-left flex-shrink-0">Role</span>
                        <span class="">:</span>
                        <span class="ml-1">ADMIN</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600 font-semibold mb-4">
                        <span class="w-20 text-left flex-shrink-0">Email</span>
                        <span class="">:</span>
                        <span class="ml-1">ADMIN@gmail.com</span>
                    </div>
                </div>
                <div class="mt-4 flex justify-center">
                    <a href="{{ route('user.logout') }}" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-lg flex items-center justify-center w-4/5">
                        <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleModal() {
        const modal = document.getElementById('modal');
        modal.classList.toggle('hidden');
    }
</script>

