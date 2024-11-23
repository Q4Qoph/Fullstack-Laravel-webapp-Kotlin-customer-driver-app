<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Yurban Rides Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Registered Customers Summary -->
                        <div class="bg-green-500 dark:bg-green-600 rounded-lg shadow p-4">
                            <h3 class="text-lg font-semibold">Registered Customers</h3>
                            <p class="text-2xl">{{ $customerCount }}</p>
                        </div>

                        <!-- Registered Drivers Summary -->
                        <div class="bg-blue-500 dark:bg-blue-600 rounded-lg shadow p-4">
                            <h3 class="text-lg font-semibold">Registered Drivers</h3>
                            <p class="text-2xl">{{ $driverCount }}</p>
                        </div>

                        <!-- Completed Rides Summary -->
                        <div class="bg-purple-500 dark:bg-purple-600 rounded-lg shadow p-4">
                            <h3 class="text-lg font-semibold">Completed Rides</h3>
                            <p class="text-2xl">{{ $completedRidesCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Links Section -->
            <div class="bg-gray-100 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Registered Customers Link -->
                        <a href="{{ route('customers.index') }}" class="flex items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                            <svg class="w-6 h-6 text-green-500 dark:text-green-400 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a6 6 0 00-12 0v2h5m-6-6a4 4 0 110-8 4 4 0 010 8zm6-10h.01"></path>
                            </svg>
                            <span>View Registered Customers</span>
                        </a>

                        <!-- Registered Drivers Link -->
                        <a href="{{ route('drivers.index') }}" class="flex items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                            <svg class="w-6 h-6 text-blue-500 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h2l1-2h8l1 2h2a1 1 0 011 1v6a1 1 0 01-1 1h-2l-1 2H6l-1-2H3a1 1 0 01-1-1v-6a1 1 0 011-1z"></path>
                            </svg>
                            <span>View Registered Drivers</span>
                        </a>

                        <!-- Ride Requests Link -->
                        <a href="{{ route('rides.index') }}" class="flex items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                            <svg class="w-6 h-6 text-purple-500 dark:text-purple-400 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8h13M9 20H7c-1.5 0-3-1-3-3V7c0-1 1-2 2-2h12c1 0 2 1 2 2v10c0 1.5-1.5 2-2 2h-3m-2 0h6"></path>
                            </svg>
                            <span>View Ride Requests</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
