@php
    use Carbon\Carbon;
    use App\Models\Transaction\Trash;
@endphp
@extends('layouts.main')
@section('container')
    <div class="rounded-lg bg-white p-6 shadow-lg">
        <div class="flex flex-1 justify-end mb-5">
            <button onclick="printModal()"
                class="rounded-lg bg-yellow-500 hover:bg-yellow-600 px-4 py-1 text-white">Cetak</button>
        </div>
        <div class="flex items-center justify-between w-full">
            <form id="dateFilterForm" class="flex w-auto flex-row justify-between gap-3">
                <input id="startDate" class="rounded-sm px-2 py-1 ring-2 ring-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    type="date" value="{{ request('start') ?? '' }}" name="start"/>
                <h1 class="text-lg font-inter text-gray-800">sampai</h1>
                <input id="endDate" class="rounded-sm px-2 py-1 ring-2 ring-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    type="date" value="{{ request('end') ?? '' }}" name="end"/>
                <button class="rounded-2xl bg-blue-500 px-3 font-bold text-sm font-inter text-white hover:bg-blue-600"
                    type="submit">
                    TERAPKAN
                </button>
            </form>
            <form id="searchForm" class="flex">
                <input type="text" name="search" id="transaction-search" placeholder="Search..."
                    value="{{ request('search') ?? '' }}"
                    class="rounded-full px-6 py-2 ring-2 ring-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </form>
        </div>
        <div class="overflow-hidden rounded-lg bg-white shadow-md mt-6">
            <table class="min-w-full text-sm text-center">
                <thead class="bg-gray-200">
                    <th class="py-4">No</th>
                    <th class="py-4">Kode Transaksi</th>
                    <th class="py-4">Tanggal</th>
                    <th class="py-4">Jenis</th>
                    <th class="py-4">Subtotal</th>
                    <th class="py-4">Action</th>
                </thead>
                <tbody id="transaction-data">
                    @foreach ($transactions as $number => $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="text-center py-3">{{ $number + 1 }}</td>
                            <td class="text-center py-3">{{ $item->code }}</td>
                            <td class="text-center py-3">
                                {{ Carbon::parse($item->created_at)->translatedFormat('j F Y') }}
                            </td>
                            <td class="text-center py-3">{{ $item->variant }}</td>
                            <td class="text-center py-3">
                                @php
                                    $amount = match ($item->variant) {
                                        'LPB' => $item->outcome,
                                        'LPK' => $item->details()->sum('total_price'),
                                        'Checkout' => $item->income,
                                        'Retur' => 0,
                                        'Trash' => -$item->loss,
                                        default => null,
                                    };
                                @endphp
                                {{ $amount !== null ? 'Rp ' . number_format($amount, 0, ',', '.') : '-' }}
                            </td>
                            <td class="flex justify-center py-3">
                                @php
                                    $routes = [
                                        'Checkout' => route('transaction.show', $item->id),
                                        'Trash' => $item->trash() ? route('management.trash.show', $item->trash()->id) : null,
                                        'Retur' => $item->retur() ? route('management.retur.show', $item->retur()->id) : null,
                                        'LPB' => route('inventory.inflows.show', $item->id),
                                        'default' => route('clinic.inflows.show', $item->id),
                                    ];

                                    $route = $routes[$item->variant] ?? $routes['default'];
                                @endphp

                                <a href="{{ $route }}"
                                    class="bg-blue-500 hover:bg-blue-600 p-2 rounded-md">
                                    @include('icons.mata')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Updated Pagination Section -->
        <div class="flex items-center justify-between p-4">
            <div>
                <p class="text-gray-700 text-sm" id="pagination-info">
                    Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} results
                </p>
            </div>
            <div id="pagination-div">
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">
                    {{-- Previous Page Link --}}
                    @if ($transactions->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 cursor-not-allowed bg-white border border-gray-300 rounded-l-md leading-5">
                            &lsaquo;
                        </span>
                    @else
                        <a href="{{ $transactions->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 cursor-pointer hover:bg-gray-50 bg-white border border-gray-300 rounded-l-md leading-5">
                            &lsaquo;
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)
                        @if ($page == $transactions->currentPage())
                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium bg-blue-500 text-white border border-gray-300 leading-5">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium bg-white text-gray-700 hover:bg-gray-50 border border-gray-300 leading-5">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($transactions->hasMorePages())
                        <a href="{{ $transactions->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 cursor-pointer hover:bg-gray-50 bg-white border border-gray-300 rounded-r-md leading-5">
                            &rsaquo;
                        </a>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-300 cursor-not-allowed bg-white border border-gray-300 rounded-r-md leading-5">
                            &rsaquo;
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    </div>

    <!-- Print Modal -->
    <div id="printModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96 relative">
            <button type="button" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600"
                onclick="closePrintModal()">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Apa format file yang ingin Anda simpan?</h3>
                <p class="text-sm text-gray-500 mb-5">Pilihlah salah satu format file!</p>
            </div>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('transaction.export.excel', request()->query()) }}"
                    onclick="closePrintModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 focus:outline-none">
                    Excel
                </a>
                <a href="{{ route('transaction.export.pdf', request()->query()) }}"
                    onclick="closePrintModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-blue-500 focus:outline-none">
                    PDF
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pastikan token ada
            if (!window.API_TOKEN) {
                console.error('API token is missing');
                showErrorMessage('Authentication error. Please refresh the page.');
                return;
            }

            const config = {
                headers: {
                    'Authorization': `Bearer ${window.API_TOKEN}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            };

            const perPage = {{ $transactions->perPage() }};
            let currentPage = {{ $transactions->currentPage() }};
            let searchQuery = '{{ request('search', '') }}';
            let startDate = '{{ request('start', '') }}';
            let endDate = '{{ request('end', '') }}';
            let timeout = null;

            // Inisialisasi event listeners
            initEventListeners();

            function initEventListeners() {
                // Tangkap input pencarian
                const searchInput = document.getElementById('transaction-search');
                if (searchInput) {
                    searchInput.addEventListener('input', function(e) {
                        searchQuery = e.target.value;
                        clearTimeout(timeout);
                        timeout = setTimeout(() => {
                            fetchTransactions(1);
                            updateUrl();
                        }, 500);
                    });
                }

                // Tangkap form filter tanggal
                const dateFilterForm = document.getElementById('dateFilterForm');
                if (dateFilterForm) {
                    dateFilterForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        startDate = document.getElementById('startDate').value;
                        endDate = document.getElementById('endDate').value;
                        fetchTransactions(1);
                        updateUrl();
                    });
                }

                // Tangkap form pencarian
                const searchForm = document.getElementById('searchForm');
                if (searchForm) {
                    searchForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        fetchTransactions(1);
                        updateUrl();
                    });
                }
            }

            function updateUrl() {
                const params = new URLSearchParams();
                if (searchQuery) params.set('search', searchQuery);
                if (startDate) params.set('start', startDate);
                if (endDate) params.set('end', endDate);

                const newUrl = window.location.pathname + '?' + params.toString();
                window.history.pushState({ path: newUrl }, '', newUrl);
            }

            async function fetchTransactions(page = 1) {
                try {
                    currentPage = page;

                    const params = new URLSearchParams({
                        per_page: perPage,
                        page: page,
                        search: searchQuery,
                        start: startDate,
                        end: endDate
                    });

                    const response = await axios.get(`/api/v1/reports/transactions?${params.toString()}`, config);

                    if (response.data && response.data.data) {
                        renderTransactionTable(response.data.data);
                        updatePagination(response.data);
                    } else {
                        throw new Error('Invalid response format');
                    }
                } catch (error) {
                    handleApiError(error);
                }
            }

            function renderTransactionTable(transactions) {
                const tbody = document.getElementById('transaction-data');
                if (!tbody) return;

                tbody.innerHTML = '';

                if (!transactions || transactions.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-500">
                                Tidak ada data transaksi
                            </td>
                        </tr>
                    `;
                    return;
                }

                const startIndex = (currentPage - 1) * perPage;

                transactions.forEach((item, index) => {
                    const rowNumber = startIndex + index + 1;
                    const row = createTableRow(item, rowNumber);
                    tbody.appendChild(row);
                });
            }

            function createTableRow(item, rowNumber) {
                const createdAt = item.created_at
                    ? new Date(item.created_at).toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    })
                    : '-';

                const amount = calculateAmount(item);
                const formattedAmount = amount !== null
                    ? `Rp ${amount.toLocaleString('id-ID')}`
                    : '-';

                const detailRoute = getDetailRoute(item);

                const row = document.createElement('tr');
                row.className = 'border-b border-gray-200 hover:bg-gray-100';
                row.innerHTML = `
                    <td class="text-center py-3">${rowNumber}</td>
                    <td class="text-center py-3">${item.code || '-'}</td>
                    <td class="text-center py-3">${createdAt}</td>
                    <td class="text-center py-3">${item.variant || '-'}</td>
                    <td class="text-center py-3">${formattedAmount}</td>
                    <td class="flex justify-center py-3">
                        <a href="${detailRoute}" class="bg-blue-500 hover:bg-blue-600 p-2 rounded-md">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.99972 2.5C14.4931 2.5 18.2314 5.73333 19.0156 10C18.2322 14.2667 14.4931 17.5 9.99972 17.5C5.50639 17.5 1.76805 14.2667 0.983887 10C1.76722 5.73333 5.50639 2.5 9.99972 2.5ZM9.99972 15.8333C11.6993 15.833 13.3484 15.2557 14.6771 14.196C16.0058 13.1363 16.9355 11.6569 17.3139 10C16.9341 8.34442 16.0038 6.86667 14.6752 5.80835C13.3466 4.75004 11.6983 4.17377 9.99972 4.17377C8.30113 4.17377 6.65279 4.75004 5.3242 5.80835C3.9956 6.86667 3.06536 8.34442 2.68555 10C3.06397 11.6569 3.99361 13.1363 5.32234 14.196C6.65106 15.2557 8.30016 15.833 9.99972 15.8333V15.8333ZM9.99972 13.75C9.00516 13.75 8.05133 13.3549 7.34807 12.6516C6.64481 11.9484 6.24972 10.9946 6.24972 10C6.24972 9.00544 6.64481 8.05161 7.34807 7.34835C8.05133 6.64509 9.00516 6.25 9.99972 6.25C10.9943 6.25 11.9481 6.64509 12.6514 7.34835C13.3546 8.05161 13.7497 9.00544 13.7497 10C13.7497 10.9946 13.3546 11.9484 12.6514 12.6516C11.9481 13.3549 10.9943 13.75 9.99972 13.75ZM9.99972 12.0833C10.5523 12.0833 11.0822 11.8638 11.4729 11.4731C11.8636 11.0824 12.0831 10.5525 12.0831 10C12.0831 9.44747 11.8636 8.91756 11.4729 8.52686C11.0822 8.13616 10.5523 7.91667 9.99972 7.91667C9.44719 7.91667 8.91728 8.13616 8.52658 8.52686C8.13588 8.91756 7.91639 9.44747 7.91639 10C7.91639 10.5525 8.13588 11.0824 8.52658 11.4731C8.91728 11.8638 9.44719 12.0833 9.99972 12.0833Z" fill="white"/>
                            </svg>
                        </a>
                    </td>
                `;
                return row;
            }

            function calculateAmount(item) {
                switch (item.variant) {
                    case 'LPB': return item.outcome || 0;
                    case 'LPK':
                        return item.details?.reduce((sum, detail) => sum + (detail.total_price || 0), 0) || 0;
                    case 'Checkout': return item.income || 0;
                    case 'Retur': return 0;
                    case 'Trash': return -(item.loss || 0);
                    default: return null;
                }
            }

            function getDetailRoute(item) {
                switch (item.variant) {
                    case 'Checkout': return `/transaction/${item.id}`;
                    case 'Trash': return item.trash ? `/management/trash/${item.trash.id}` : '#';
                    case 'Retur': return item.retur ? `/management/retur/${item.retur.id}` : '#';
                    case 'LPB': return `/inventory/inflows/${item.id}`;
                    default: return `/clinic/inflows/${item.id}`;
                }
            }

            function updatePagination(responseData) {
                const paginationContainer = document.getElementById('pagination-div');
                const infoContainer = document.getElementById('pagination-info');

                if (!responseData || !paginationContainer || !infoContainer) return;

                // Update pagination info
                const start = responseData.from || 0;
                const end = responseData.to || 0;
                const total = responseData.total || 0;
                infoContainer.textContent = `Showing ${start} to ${end} of ${total} results`;

                // Generate pagination links
                let paginationHTML = '<nav class="isolate inline-flex -space-x-px rounded-md shadow-xs" aria-label="Pagination">';

                // Previous button
                if (responseData.prev_page_url) {
                    paginationHTML += `
                        <a href="#" onclick="fetchTransactions(${currentPage - 1}); return false;"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 cursor-pointer hover:bg-gray-50 bg-white border border-gray-300 rounded-l-md leading-5">
                            &lsaquo;
                        </a>
                    `;
                } else {
                    paginationHTML += `
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-300 cursor-not-allowed bg-white border border-gray-300 rounded-l-md leading-5">
                            &lsaquo;
                        </span>
                    `;
                }

                // Page numbers
                for (let i = 1; i <= responseData.last_page; i++) {
                    if (i === currentPage) {
                        paginationHTML += `
                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium bg-blue-500 text-white border border-gray-300 leading-5">
                                ${i}
                            </span>
                        `;
                    } else {
                        paginationHTML += `
                            <a href="#" onclick="fetchTransactions(${i}); return false;"
                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium bg-white text-gray-700 hover:bg-gray-50 border border-gray-300 leading-5">
                                ${i}
                            </a>
                        `;
                    }
                }

                // Next button
                if (responseData.next_page_url) {
                    paginationHTML += `
                        <a href="#" onclick="fetchTransactions(${currentPage + 1}); return false;"
                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 cursor-pointer hover:bg-gray-50 bg-white border border-gray-300 rounded-r-md leading-5">
                            &rsaquo;
                        </a>
                    `;
                } else {
                    paginationHTML += `
                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-300 cursor-not-allowed bg-white border border-gray-300 rounded-r-md leading-5">
                            &rsaquo;
                        </span>
                    `;
                }

                paginationHTML += '</nav>';
                paginationContainer.innerHTML = paginationHTML;
            }

            function handleApiError(error) {
                console.error('API Error:', error);

                let message = 'Terjadi kesalahan saat memuat data';
                if (error.response) {
                    if (error.response.status === 401) {
                        message = 'Sesi Anda telah habis. Silakan login kembali';
                    } else if (error.response.status === 404) {
                        message = 'Endpoint tidak ditemukan';
                    } else if (error.response.data?.message) {
                        message = error.response.data.message;
                    }
                } else if (error.request) {
                    message = 'Tidak ada respon dari server';
                }

                showErrorMessage(message);
                const tbody = document.getElementById('transaction-data');
                if (tbody) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="6" class="py-4 text-center text-red-500">
                                ${message}
                            </td>
                        </tr>
                    `;
                }
            }
        });

        // Fungsi untuk modal print
        function printModal() {
            const modal = document.getElementById('printModal');
            if (modal) modal.classList.remove('hidden');
        }

        function closePrintModal() {
            const modal = document.getElementById('printModal');
            if (modal) modal.classList.add('hidden');
        }

        // Fungsi utilitas
        function showErrorMessage(message) {
            showToast(message, 'red');
        }

        function showSuccessMessage(message) {
            showToast(message, 'green');
        }

        function showToast(message, color = 'blue') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 bg-${color}-500 text-white px-4 py-2 rounded shadow-lg z-50 transition-opacity duration-300`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
@endsection
