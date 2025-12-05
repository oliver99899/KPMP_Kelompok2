<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard Statistik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Variabel $isAdmin, $isSeller, dan $pendingSellers diasumsikan dilewatkan dari DashboardController@index --}}
                
                
                {{-- START: KONTEN UTAMA ADMIN (Hanya Dropdown Laporan Platform) --}}
                @if ($isAdmin)
                    
                    {{-- Judul dan Dropdown Laporan Admin di Baris Atas --}}
                    <div class="flex justify-between items-center mb-6"> 
                        <h3 class="font-bold text-gray-900 text-xl">Laporan Platform (SRS 09-11)</h3>

                        {{-- DROPDOWN LAPORAN PLATFORM (SRS 09-11) --}}
                        <div x-data="{ open: false }" class="relative inline-block text-left">
                            {{-- Gaya Disamakan dengan Tombol Penjual (bg-green-600) --}}
                            <button type="button" @click="open = !open" class="inline-flex justify-center w-full rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-green-600 text-sm font-bold text-white hover:bg-green-700 focus:outline-none transition">
                                Download Laporan Platform (PDF)
                                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-20">
                                <div class="py-1">
                                    <a href="{{ route('report.platform.status', ['action' => 'download']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Akun Penjual</a>
                                    <div class="h-px bg-gray-100 mx-4 my-1"></div>
                                    <a href="{{ route('report.platform.location', ['action' => 'download']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Toko per Lokasi</a>
                                    <div class="h-px bg-gray-100 mx-4 my-1"></div>
                                    <a href="{{ route('report.platform.rating', ['action' => 'download']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Produk Berdasarkan Rating</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- END: KONTEN UTAMA ADMIN --}}
                
                
                {{-- START: KONTEN KHUSUS PENJUAL (Laporan Stok SRS 12-14) --}}
                @if ($isSeller)
                    {{-- DROP DOWN LAPORAN SELLER (Di sini tombol sudah diatur agar sejajar di kanan) --}}
                    <div class="flex justify-between items-center mb-6 @if($isAdmin) mt-8 @endif"> 
                        <h3 class="font-bold text-gray-900 text-xl">Statistik Toko & Laporan Stok Produk</h3>

                        {{-- DROPDOWN DOWNLOAD LAPORAN STOK (SRS 12-14) --}}
                        <div x-data="{ open: false }" class="relative inline-block text-left">
                            <button type="button" @click="open = !open" class="inline-flex justify-center w-full rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-green-600 text-sm font-bold text-white hover:bg-green-700 focus:outline-none transition">
                                Cetak Laporan Stok (PDF)
                                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            </button>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-20">
                                <div class="py-1">
                                    <a href="{{ route('seller.report.stock.by_stock', ['action' => 'download']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Stok Menurun</a>
                                    <div class="h-px bg-gray-100 mx-4 my-1"></div>
                                    <a href="{{ route('seller.report.stock.by_rating', ['action' => 'download']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Rating Menurun</a>
                                    <div class="h-px bg-gray-100 mx-4 my-1"></div>
                                    <a href="{{ route('seller.report.stock.urgent', ['action' => 'download']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Produk Segera Dipesan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- END: KONTEN KHUSUS PENJUAL --}}
                
                
                {{-- Area Grafik (Tampil untuk Admin dan Seller) --}}
                <div id="chart-area" class="grid grid-cols-1 lg:grid-cols-3 gap-8 @if($isAdmin || $isSeller) mt-8 @endif">
                    {{-- Charts akan di-load di sini --}}
                </div>
                
                <div id="loading" class="text-center py-10 text-gray-500 font-medium">
                    Memuat data statistik...
                </div>

            </div>
        </div>
    </div>

    <script>
        // Memuat Chart.js dari CDN (diperlukan untuk menjalankan grafik)
        document.head.innerHTML += '<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></' + 'script>';

        document.addEventListener('DOMContentLoaded', function() {
            const chartArea = document.getElementById('chart-area');
            const loading = document.getElementById('loading');
            
            // Variabel $isAdmin sekarang harus dilewatkan dari Controller
            const isAdmin = {{ $isAdmin ? 'true' : 'false' }};
            const apiUrl = isAdmin ? '/api/dashboard/platform' : '/api/dashboard/seller';
            
            // --- FUNGSI UTAMA UNTUK MENGAMBIL DATA & MEMBUAT GRAFIK ---
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    loading.style.display = 'none';

                    if (isAdmin) {
                        renderAdminCharts(data);
                    } else {
                        renderSellerCharts(data);
                    }
                })
                .catch(error => {
                    loading.textContent = 'Gagal memuat data. Pastikan Anda memiliki toko aktif atau akun admin.';
                    console.error('Error fetching dashboard data:', error);
                });

            // --- FUNGSI PEMBANTU UNTUK MEMBUAT CANVAS ---
            function createChartContainer(title, chartId, chartType='canvas') {
                const container = document.createElement('div');
                container.className = 'bg-gray-50 p-4 rounded-xl border border-gray-200 shadow-sm col-span-1';
                container.innerHTML = `
                    <h4 class="text-lg font-bold mb-4 border-b pb-2 text-gray-800">${title}</h4>
                    <${chartType} id="${chartId}"></${chartType}>
                `;
                chartArea.appendChild(container);
                return document.getElementById(chartId);
            }

            // --- SRS-07: GRAFIK PLATFORM (ADMIN) ---
            function renderAdminCharts(data) {
                // CHART 1: Produk per Kategori (Pie Chart)
                const categoryCtx = createChartContainer('Sebaran Produk per Kategori', 'productCategoryChart');
                new Chart(categoryCtx, {
                    type: 'pie', data: { labels: Object.keys(data.product_category), datasets: [{ data: Object.values(data.product_category), backgroundColor: ['#4F46E5', '#EF4444', '#10B981', '#F59E0B', '#6366F1', '#A855F7', '#EC4899'] }] }, options: { responsive: true, plugins: { legend: { position: 'top' } } }
                });

                // CHART 2: Status Penjual (Doughnut Chart)
                const statusCtx = createChartContainer('Status Penjual (Aktif vs Pending/Tolak)', 'sellerStatusChart');
                new Chart(statusCtx, {
                    type: 'doughnut', data: { labels: Object.keys(data.seller_status), datasets: [{ data: Object.values(data.seller_status), backgroundColor: ['#10B981', '#F59E0B', '#EF4444'] }] }, options: { responsive: true, plugins: { legend: { position: 'right' } } }
                });
                
                // CHART 3: JUMLAH TOKO BERDASARKAN PROPINSI (Pie Chart)
                const provinceStoreCtx = createChartContainer('Jumlah Toko Berdasarkan Propinsi', 'storeProvinceChart');
                new Chart(provinceStoreCtx, {
                    type: 'pie', data: { labels: Object.keys(data.seller_province), datasets: [{ data: Object.values(data.seller_province), backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899'] }] }, options: { responsive: true, plugins: { legend: { position: 'top' } } }
                });

                // CHART 4: JUMLAH PENGUNJUNG UNIK (Bar Chart Sederhana)
                const reviewerCtx = createChartContainer('Pengunjung Unik Pemberi Ulasan', 'reviewerCountChart');
                new Chart(reviewerCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(data.reviewers_count),
                        datasets: [{ label: 'Jumlah Pengunjung', data: Object.values(data.reviewers_count), backgroundColor: '#4F46E5' }]
                    },
                    options: { responsive: true, scales: { y: { beginAtZero: true } } }
                });
            }

            // --- SRS-08: GRAFIK PENJUAL (SELLER) ---
            function renderSellerCharts(data) {
                // CHART 1: Stok per Produk (Bar Chart)
                const stockCtx = createChartContainer('Sebaran Stok Produk', 'sellerStockChart');
                new Chart(stockCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(data.stock_data),
                        datasets: [{
                            label: 'Stok',
                            data: Object.values(data.stock_data),
                            backgroundColor: '#10B981',
                        }]
                    },
                    options: { responsive: true, scales: { y: { beginAtZero: true } } }
                });
                
                // CHART 2: Rating per Produk (Doughnut Chart)
                const ratingCtx = createChartContainer('Rata-rata Rating per Produk', 'sellerRatingChart');
                new Chart(ratingCtx, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(data.rating_data),
                        datasets: [{
                            data: Object.values(data.rating_data),
                            backgroundColor: ['#F59E0B', '#EC4899', '#3B82F6', '#8B5CF6', '#F43F5E']
                        }]
                    },
                    options: { responsive: true }
                });

                // CHART 3: Pemberi Rating per Propinsi (Bar Chart)
                const provinceCtx = createChartContainer('Sebaran Pemberi Rating (Provinsi)', 'reviewProvinceChart');
                new Chart(provinceCtx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(data.review_province),
                        datasets: [{
                            label: 'Jumlah Pemberi Rating',
                            data: Object.values(data.review_province),
                            backgroundColor: '#4F46E5',
                        }]
                    },
                    options: { responsive: true, scales: { y: { beginAtZero: true } } }
                });
            }
        });
    </script>
</x-app-layout>