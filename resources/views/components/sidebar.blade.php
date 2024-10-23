<button data-drawer-target="sidebar-multi-level-sidebar" data-drawer-toggle="sidebar-multi-level-sidebar" aria-controls="sidebar-multi-level-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
    <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
 </button>
 <aside id="sidebar-multi-level-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-abu">
       <ul class="space-y-2 font-medium">
        <li>
            <div style="margin-bottom: 30px; margin-left: 40px;">
                <img src="{{ asset('assets/logo simbat.png') }}" alt="Simbat Logo" style="width: 40px; height: 40px; margin-right: 3px; vertical-align: middle; display: inline-block;">
                <span style="font-size: 20px; font-weight: bold; vertical-align: middle; display: inline-block;">Simbat</span>
            </div>
            <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-900 bg-blue-500 rounded-lg dark:text-white hover:bg-blue-600 dark:hover:bg-blue-700 group mb-4">
                <svg width="22" height="19" viewBox="0 0 22 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.50033 16.4167H16.5003V7.39392L11.0003 2.39442L5.50033 7.39392V16.4167ZM17.417 18.25H4.58366C4.34054 18.25 4.10739 18.1534 3.93548 17.9815C3.76357 17.8096 3.66699 17.5765 3.66699 17.3333V9.08334H0.916992L10.3834 0.477675C10.5522 0.324113 10.7722 0.239014 11.0003 0.239014C11.2285 0.239014 11.4485 0.324113 11.6172 0.477675L21.0837 9.08334H18.3337V17.3333C18.3337 17.5765 18.2371 17.8096 18.0652 17.9815C17.8933 18.1534 17.6601 18.25 17.417 18.25ZM6.87533 10.9167H8.70866C8.70866 11.5245 8.9501 12.1074 9.37987 12.5371C9.80964 12.9669 10.3925 13.2083 11.0003 13.2083C11.6081 13.2083 12.191 12.9669 12.6208 12.5371C13.0506 12.1074 13.292 11.5245 13.292 10.9167H15.1253C15.1253 12.0107 14.6907 13.0599 13.9171 13.8335C13.1436 14.6071 12.0943 15.0417 11.0003 15.0417C9.90631 15.0417 8.8571 14.6071 8.08351 13.8335C7.30992 13.0599 6.87533 12.0107 6.87533 10.9167Z" fill="#ffffff"/>
                </svg>
                <span class="ms-3">Dashboards</span>
                <span class="inline-flex items-center justify-center w-6 h-6 p-2 ml-8 text-sm font-medium text-red-800 bg-red-100 rounded-full dark:bg-orange-600 dark:text-white" >6</span>
            </a>
        </li>
        <li class="flex items-center justify-between pt-3 pb-1 text-gray-400 uppercase">
            <div class="h-px bg-gray-300 w-1/6 mr-1"></div>
            <span class="text-[12px] font-medium tracking-wider">Apps & Pages</span>
            <div class="h-px bg-gray-300 w-1/3 ml-1"></div>
        </li>
          <li>
             <button type="button" class="flex items-center w-full p-2 text-base bg-gray-300 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-300 dark:text-black dark:hover:bg-gray-300" aria-controls="dropdown-masterdata" data-collapse-toggle="dropdown-masterdata">
                <svg width="19" height="22" viewBox="0 0 19 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.9444 0.5C18.5271 0.5 19 0.9704 19 1.55V20.45C19 21.0296 18.5271 21.5 17.9444 21.5H3.16667C2.584 21.5 2.11111 21.0296 2.11111 20.45V18.35H0V16.25H2.11111V14.15H0V12.05H2.11111V9.95H0V7.85H2.11111V5.75H0V3.65H2.11111V1.55C2.11111 0.9704 2.584 0.5 3.16667 0.5H17.9444ZM16.8889 2.6H4.22222V19.4H16.8889V2.6ZM11.6111 6.8V9.95H14.7778V12.05H11.6101L11.6111 15.2H9.5L9.49894 12.05H6.33333V9.95H9.5V6.8H11.6111Z" fill="currentColor" fill-opacity="0.9"/>
                    </svg>
                   <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Master Data</span>
                   <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                   </svg>
             </button>
             <ul id="dropdown-masterdata" class="list-none hidden py-2 space-y-2">
                <li>
                    <a href="{{ route('master.category.index') }}" class="flex items-center space-x-5 p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-black dark:hover:bg-gray-200">
                        <span class="w-2 h-2 rounded-full bg-gray-500 inline-block ms-1"></span>
                        <span class="text-sm">Kategori Obat</span>
                    </a>
                </li>
            <li>
                <a href="{{ route('master.variant.index') }}" class="flex items-center space-x-5 p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-black dark:hover:bg-gray-200">
                    <span class="w-2 h-2 rounded-full bg-gray-500 inline-block ms-1"></span>
                    <span class="text-sm">Jenis Obat</span>
                </a>
            </li>
            <li>
                <a href="{{ route('master.manufacture.index') }}" class="flex items-center space-x-5 p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-black dark:hover:bg-gray-200">
                    <span class="w-2 h-2 rounded-full bg-gray-500 inline-block ms-1"></span>
                    <span class="text-sm">Produsen Obat</span>
                </a>
            </li>
            <li>
                <a href="{{ route('master.vendor.index') }}" class="flex items-center space-x-5 p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-black dark:hover:bg-gray-200">
                    <span class="w-2 h-2 rounded-full bg-gray-500 inline-block ms-1"></span>
                    <span class="text-sm">Vendor Obat</span>
                </a>
            </li>
            <li>
                <a href="{{ route('master.drug.index') }}" class="flex items-center space-x-5 p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-black dark:hover:bg-gray-200">
                    <span class="w-2 h-2 rounded-full bg-gray-500 inline-block ms-1"></span>
                    <span class="text-sm">Nama Obat</span>
                </a>
            </li>
           </ul>
            </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group bg-gray-300 hover:bg-gray-300 dark:text-black dark:hover:bg-gray-300" aria-controls="dropdown-inventory" data-collapse-toggle="dropdown-inventory">
                    <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 4.78906V1.68359C5 1.40905 5.10536 1.14576 5.29289 0.951628C5.48043 0.757498 5.73478 0.648438 6 0.648438H14C14.2652 0.648438 14.5196 0.757498 14.7071 0.951628C14.8946 1.14576 15 1.40905 15 1.68359V4.78906H19C19.2652 4.78906 19.5196 4.89812 19.7071 5.09225C19.8946 5.28638 20 5.54968 20 5.82422V20.3164C20 20.5909 19.8946 20.8542 19.7071 21.0484C19.5196 21.2425 19.2652 21.3516 19 21.3516H1C0.734784 21.3516 0.48043 21.2425 0.292893 21.0484C0.105357 20.8542 0 20.5909 0 20.3164V5.82422C0 5.54968 0.105357 5.28638 0.292893 5.09225C0.48043 4.89812 0.734784 4.78906 1 4.78906H5ZM2 16.1758V19.2812H18V16.1758H2ZM2 14.1055H18V6.85938H2V14.1055ZM7 2.71875V4.78906H13V2.71875H7ZM9 11H11V13.0703H9V11Z" fill="#000000" fill-opacity="0.9"/>
                        </svg>

                      <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Inventory</span>
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                      </svg>
                </button>
                <ul id="dropdown-inventory" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('inventory.inflows.index') }}" class="flex items-center space-x-5 p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-black dark:hover:bg-gray-200">
                            <span class="w-2 h-2 rounded-full bg-gray-500 inline-block ms-1"></span>
                            <span class="text-sm">Barang Masuk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inventory.stocks.index') }}" class="flex items-center space-x-5 p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-black dark:hover:bg-gray-200">
                            <span class="w-2 h-2 rounded-full bg-gray-500 inline-block ms-1"></span>
                            <span class="text-sm">List Stok</span>
                        </a>
                    </li>
            </ul>
               </li>
               <li>
                <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group bg-gray-300 hover:bg-gray-300 dark:text-black dark:hover:bg-gray-300" aria-controls="dropdown-klinik" data-collapse-toggle="dropdown-klinik">
                    <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 0V2H13V5C14.657 5 16 6.343 16 8V19C16 19.552 15.552 20 15 20H1C0.448 20 0 19.552 0 19V8C0 6.343 1.343 5 3 5V2H1V0H15ZM13 7H3C2.448 7 2 7.448 2 8V18H14V8C14 7.448 13.552 7 13 7ZM9 9V11H11V13H8.999L9 15H7L6.999 13H5V11H7V9H9ZM11 2H5V5H11V2Z" fill="#000000" fill-opacity="0.9"/>
                        </svg>
                      <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Klinik</span>
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                      </svg>
                </button>
                <ul id="dropdown-klinik" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('clinic.inflows.index') }}" class="flex items-center space-x-5 p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-black dark:hover:bg-gray-200">
                            <span class="w-2 h-2 rounded-full bg-gray-500 inline-block ms-1"></span>
                            <span class="text-sm">Obat Masuk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('clinic.stocks.index') }}" class="flex items-center space-x-5 p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-black dark:hover:bg-gray-200">
                            <span class="w-2 h-2 rounded-full bg-gray-500 inline-block ms-1"></span>
                            <span class="text-sm">List Stok</span>
                        </a>
                    </li>
                </ul>
                </li>
               <li>
                <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group bg-gray-300 hover:bg-gray-300 dark:text-black dark:hover:bg-gray-300" aria-controls="dropdown-laporan" data-collapse-toggle="dropdown-laporan">
                    <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 0V2H17.007C17.555 2 18 2.445 18 2.993V19.007C18 19.555 17.555 20 17.007 20H0.993C0.445 20 0 19.555 0 19.007V2.993C0 2.445 0.445 2 0.993 2H4V0H14ZM4 4H2V18H16V4H14V6H4V4ZM6 14V16H4V14H6ZM6 11V13H4V11H6ZM6 8V10H4V8H6ZM12 2H6V4H12V2Z" fill="#000000" fill-opacity="0.9"/>
                        </svg>
                      <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Laporan</span>
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                      </svg>
                </button>
                <ul id="dropdown-laporan" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('report.drugs.index') }}" class="flex items-center space-x-5 p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-black dark:hover:bg-gray-200">
                            <span class="w-2 h-2 rounded-full bg-gray-500 inline-block ms-1"></span>
                            <span class="text-sm">Laporan obat</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('report.transactions.index') }}" class="flex items-center space-x-5 p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-black dark:hover:bg-gray-200">
                            <span class="w-2 h-2 rounded-full bg-gray-500 inline-block ms-1"></span>
                            <span class="text-sm">Laporan transaksi</span>
                        </a>
                    </li>
                </ul>
               </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 bg-gray-300 rounded-lg group hover:bg-gray-300 dark:text-black dark:hover:bg-gray-300" aria-controls="dropdown-manajementransaksi" data-collapse-toggle="dropdown-manajementransaksi">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 0C15.523 0 20 4.477 20 10C20 12.4 19.154 14.604 17.744 16.328L17.778 16.364L16.364 17.778L16.328 17.744C14.5436 19.2062 12.307 20.0036 10 20C4.477 20 0 15.523 0 10C0 4.477 4.477 0 10 0ZM2 10C1.99998 11.4969 2.41995 12.9638 3.21217 14.2339C4.00438 15.5041 5.13706 16.5264 6.48143 17.1848C7.82579 17.8432 9.32791 18.1112 10.817 17.9583C12.3061 17.8054 13.7225 17.2378 14.905 16.32L12.53 13.944C12.3558 13.9814 12.1782 14.0002 12 14H11V16H9V14H6.5V12H12C12.1249 12.0002 12.2455 11.9537 12.3378 11.8695C12.4301 11.7853 12.4876 11.6696 12.4989 11.5452C12.5102 11.4207 12.4745 11.2966 12.3988 11.1972C12.3231 11.0977 12.2129 11.0303 12.09 11.008L12 11H8C7.56116 11 7.13006 10.8845 6.75002 10.665C6.36998 10.4456 6.0544 10.13 5.83498 9.74997C5.61557 9.36993 5.50006 8.93882 5.50006 8.49998C5.50007 8.06115 5.61558 7.63004 5.835 7.25L3.679 5.094C2.58778 6.49628 1.99678 8.22317 2 10ZM10 2C8.152 2 6.45 2.627 5.095 3.68L7.47 6.055C7.64422 6.01791 7.82188 5.99948 8 6H9V4H11V6H13.5V8H8C7.87505 7.99977 7.75455 8.04633 7.66222 8.13051C7.56988 8.21469 7.51241 8.33039 7.50112 8.45482C7.48983 8.57926 7.52554 8.70341 7.60122 8.80283C7.6769 8.90225 7.78705 8.96974 7.91 8.992L8 9H12C12.4388 9.00001 12.8699 9.11553 13.25 9.33496C13.63 9.55439 13.9456 9.86998 14.165 10.25C14.3844 10.6301 14.4999 11.0612 14.4999 11.5C14.4999 11.9389 14.3844 12.37 14.165 12.75L16.321 14.905C17.2389 13.7224 17.8065 12.306 17.9593 10.8168C18.1121 9.32758 17.8441 7.82538 17.1856 6.48098C16.5271 5.13658 15.5046 4.00391 14.2343 3.21177C12.964 2.41963 11.497 1.99979 10 2Z" fill="#000000" fill-opacity="0.9"/>
                        </svg>
                      <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Manajemen Transaksi</span>
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                      </svg>
                </button>
                <ul id="dropdown-manajementransaksi" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('management.bill.index') }}" class="flex items-center space-x-5 p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-black dark:hover:bg-gray-200">
                            <span class="w-2 h-2 rounded-full bg-gray-500 inline-block ms-1"></span>
                            <span class="text-sm">Tagihan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('management.retur.index') }}" class="flex items-center space-x-5 p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200 dark:text-black dark:hover:bg-gray-200">
                            <span class="w-2 h-2 rounded-full  bg-gray-500 inline-block ms-1"></span>
                            <span class= "text-sm">Retur</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('user.index') }}" class="flex items-center p-2 text-gray-900 bg-blue-500 rounded-lg dark:text-white hover:bg-blue-600 dark:hover:bg-blue-700 group mb-4">
                    <img src="{{ asset('assets/Vector manage.png') }}" alt="Manage Accounts" style="width: 20px; height: 20px; margin-right: 3px; vertical-align: middle; display: inline-block;">
                    <span class="ms-3">Manage Accounts</span>
                </a>
            </li>
            <li>
                <a href="{{ route('user.settings') }}" class="flex items-center p-2 text-gray-900 bg-blue-500 rounded-lg dark:text-white hover:bg-blue-600 dark:hover:bg-blue-700 group mb-4">
                    <img src="{{ asset('assets/Vector settings.png') }}" alt="Manage Settings" style="width: 20px; height: 20px; margin-right: 3px; vertical-align: middle; display: inline-block;">
                    <span class="ms-3">Manage Settings</span>
                </a>
            </li>
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-900 bg-blue-500 rounded-lg dark:text-white hover:bg-blue-600 dark:hover:bg-blue-700 group mb-4">
                    <img src="{{ asset('assets/logo simbat.png') }}" alt="Logo Simbat" style="width: 20px; height: 20px; margin-right: 3px; vertical-align: middle; display: inline-block;">
                    <span class="ms-3">Simbat</span>

                </a>
            </li>

       </ul>
       <div class="navbar">
        <button class="flex items-center bg-gray-400 hover:bg-gray-400 text-black py-2 px-6 w-[230px] h-[40px] rounded-lg transition mt-2">
            <div style="display: flex; align-items: center; justify-content: center; width: 100%;">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.5 16H5.5V18H17.5V2H5.5V4H3.5V1C3.5 0.734784 3.60536 0.48043 3.79289 0.292893C3.98043 0.105357 4.23478 0 4.5 0H18.5C18.7652 0 19.0196 0.105357 19.2071 0.292893C19.3946 0.48043 19.5 0.734784 19.5 1V19C19.5 19.2652 19.3946 19.5196 19.2071 19.7071C19.0196 19.8946 18.7652 20 18.5 20H4.5C4.23478 20 3.98043 19.8946 3.79289 19.7071C3.60536 19.5196 3.5 19.2652 3.5 19V16ZM5.5 9H12.5V11H5.5V14L0.5 10L5.5 6V9Z" fill="#000000" fill-opacity="0.9"/>
                </svg>
                <span style="padding-left: 10px;">Log Out</span>
            </div>
        </button>
        </div>
    </div>




 </aside>

<script>
    document.addEventListener("DOMContentLoaded", function() {
    const dropdownToggles = document.querySelectorAll('[data-collapse-toggle]');

    dropdownToggles.forEach(function(toggle) {
        const targetId = toggle.getAttribute('data-collapse-toggle');
        const dropdownMenu = document.getElementById(targetId);

        console.log(`Target ID: ${targetId}`);

        toggle.addEventListener('click', function() {
            dropdownMenu.classList.toggle('hidden');
            dropdownMenu.classList.toggle('block');
            console.log(`Dropdown ${targetId} toggled`);
        });
    });
    });
</script>