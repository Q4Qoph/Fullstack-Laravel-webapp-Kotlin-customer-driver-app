<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registered Drivers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <!-- Filter Form -->
                <form method="GET" id="filter-form" class="mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- County Dropdown -->
                        <div>
                            <label for="county" class="block text-sm font-medium text-gray-700 dark:text-gray-200">County</label>
                            <select id="county" name="county" class="form-select mt-1 block w-full">
                                <option value="">Select County</option>
                            </select>
                        </div>

                        <!-- Sub-County Dropdown -->
                        <div>
                            <label for="sub_county" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Sub-County</label>
                            <select id="sub_county" name="sub_county" class="form-select mt-1 block w-full" disabled>
                                <option value="">Select Sub-County</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Filter</button>
                        </div>
                    </div>
                </form>

                <!-- Driver Table -->
                <table class="table-auto w-full text-gray-900 dark:text-gray-100">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Phone</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">County</th>
                            <th class="px-4 py-2">Sub-County</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($drivers as $driver)
                            <tr class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="border px-4 py-2">{{ $driver->first_name }} {{ $driver->last_name }}</td>
                                <td class="border px-4 py-2">{{ $driver->phone }}</td>
                                <td class="border px-4 py-2">{{ $driver->email }}</td>
                                <td class="border px-4 py-2">{{ $driver->county }}</td>
                                <td class="border px-4 py-2">{{ $driver->sub_county }}</td>
                                <td class="border px-4 py-2">{{ ucfirst($driver->status) }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $drivers->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Filtter Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const countySelect = document.getElementById('county');
            const subCountySelect = document.getElementById('sub_county');

            // Fetch counties
            fetch('{{ route('locations.counties') }}')
                .then(response => response.json())
                .then(counties => {
                    counties.forEach(county => {
                        const option = document.createElement('option');
                        option.value = county;
                        option.textContent = county;
                        countySelect.appendChild(option);
                    });
                });

            // Fetch sub-counties when a county is selected
            countySelect.addEventListener('change', () => {
                const selectedCounty = countySelect.value;

                if (selectedCounty) {
                    subCountySelect.disabled = false;

                    // Clear sub-county dropdown
                    subCountySelect.innerHTML = '<option value="">Select Sub-County</option>';

                    fetch(`/locations/sub-counties/${selectedCounty}`)
                        .then(response => response.json())
                        .then(subCounties => {
                            subCounties.forEach(subCounty => {
                                const option = document.createElement('option');
                                option.value = subCounty;
                                option.textContent = subCounty;
                                subCountySelect.appendChild(option);
                            });
                        });
                } else {
                    subCountySelect.disabled = true;
                    subCountySelect.innerHTML = '<option value="">Select Sub-County</option>';
                }
            });
        });
    </script>
</x-app-layout>
