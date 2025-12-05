<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard Statistik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Area Grafik --}}
                <div id="chart-area" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Charts akan di-load di sini --}}
                </div>
                
                <div id="loading" class="text-center py-10 text-gray-500 font-medium">
                    Memuat data statistik...
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartArea = document.getElementById('chart-area');
            const loading = document.getElementById('loading');
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