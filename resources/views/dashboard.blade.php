<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Admin Users</h3>
                        <div class="flex space-x-4">
                            <button id="refresh-btn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                <i class="fas fa-sync-alt mr-2"></i>Refresh
                            </button>
                        </div>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loading" class="text-center py-8">
                        <i class="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
                        <p class="mt-2">Loading admin users...</p>
                    </div>

                    <!-- Error Message -->
                    <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <span class="block sm:inline" id="error-text"></span>
                    </div>

                    <!-- Users Table -->
                    <div class="overflow-x-auto">
                        <table id="users-table" class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 hidden">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="users-table-body" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                <!-- Data will be inserted here by JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div id="pagination" class="mt-4 flex items-center justify-between hidden">
                        <div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Showing <span id="from-item" class="font-medium">1</span> to <span id="to-item" class="font-medium">10</span> of <span id="total-items" class="font-medium">20</span> results
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <button id="prev-page" class="px-3 py-1 border rounded text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 disabled:opacity-50">
                                Previous
                            </button>
                            <button id="next-page" class="px-3 py-1 border rounded text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 disabled:opacity-50">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript untuk memanggil API -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variabel untuk pagination
            let currentPage = 1;
            const itemsPerPage = 10;
            let totalUsers = 0;
            
            // Elemen DOM
            const usersTable = document.getElementById('users-table');
            const usersTableBody = document.getElementById('users-table-body');
            const loadingElement = document.getElementById('loading');
            const errorElement = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');
            const paginationElement = document.getElementById('pagination');
            const prevPageBtn = document.getElementById('prev-page');
            const nextPageBtn = document.getElementById('next-page');
            const fromItem = document.getElementById('from-item');
            const toItem = document.getElementById('to-item');
            const totalItems = document.getElementById('total-items');
            const refreshBtn = document.getElementById('refresh-btn');

            // Fungsi untuk memformat tanggal
            function formatDate(dateString) {
                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                return new Date(dateString).toLocaleDateString(undefined, options);
            }

            // Fungsi untuk menampilkan error
            function showError(message) {
                errorText.textContent = message;
                errorElement.classList.remove('hidden');
                loadingElement.classList.add('hidden');
            }

            // Fungsi untuk menyembunyikan error
            function hideError() {
                errorElement.classList.add('hidden');
            }

            // Fungsi untuk memuat data admin
            async function loadAdminUsers(page = 1) {
                try {
                    // Tampilkan loading, sembunyikan tabel dan error
                    loadingElement.classList.remove('hidden');
                    usersTable.classList.add('hidden');
                    paginationElement.classList.add('hidden');
                    hideError();

                    // Ganti dengan endpoint API Anda yang sesuai
                    const response = await fetch(`/api/admin/users?page=${page}&limit=${itemsPerPage}`, {
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        credentials: 'same-origin'
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    
                    // Update variabel pagination
                    currentPage = page;
                    totalUsers = data.total;
                    
                    // Render tabel
                    renderUsersTable(data.data);
                    updatePagination();
                    
                    // Sembunyikan loading, tampilkan tabel
                    loadingElement.classList.add('hidden');
                    usersTable.classList.remove('hidden');
                    if (data.total > itemsPerPage) {
                        paginationElement.classList.remove('hidden');
                    }
                    
                } catch (error) {
                    console.error('Error fetching admin users:', error);
                    showError('Failed to load admin users. Please try again later.');
                }
            }

            // Fungsi untuk merender data ke tabel
            function renderUsersTable(users) {
                usersTableBody.innerHTML = '';
                
                if (users.length === 0) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                            No admin users found.
                        </td>
                    `;
                    usersTableBody.appendChild(row);
                    return;
                }
                
                users.forEach(user => {
                    const row = document.createElement('tr');
                    
                    // Ganti dengan struktur data yang sesuai dari API Anda
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        ${user.name}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            ${user.email}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${user.email_verified_at ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'}">
                                ${user.email_verified_at ? 'Verified' : 'Pending'}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="/admin/users/${user.id}/edit" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">Edit</a>
                            <button onclick="confirmDelete(${user.id})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                        </td>
                    `;
                    
                    usersTableBody.appendChild(row);
                });
            }

            // Fungsi untuk update tampilan pagination
            function updatePagination() {
                const startItem = (currentPage - 1) * itemsPerPage + 1;
                const endItem = Math.min(currentPage * itemsPerPage, totalUsers);
                
                fromItem.textContent = startItem;
                toItem.textContent = endItem;
                totalItems.textContent = totalUsers;
                
                prevPageBtn.disabled = currentPage === 1;
                nextPageBtn.disabled = currentPage * itemsPerPage >= totalUsers;
            }

            // Event listeners
            prevPageBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    loadAdminUsers(currentPage - 1);
                }
            });

            nextPageBtn.addEventListener('click', () => {
                if (currentPage * itemsPerPage < totalUsers) {
                    loadAdminUsers(currentPage + 1);
                }
            });

            refreshBtn.addEventListener('click', () => {
                loadAdminUsers(currentPage);
            });

            // Fungsi konfirmasi delete (contoh)
            window.confirmDelete = function(userId) {
                if (confirm('Are you sure you want to delete this admin user?')) {
                    // Implementasi delete logic di sini
                    console.log('Deleting user with ID:', userId);
                }
            };

            // Load data pertama kali
            loadAdminUsers();
        });
    </script>
</x-app-layout>