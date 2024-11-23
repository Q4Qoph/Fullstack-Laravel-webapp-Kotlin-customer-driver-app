<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registered Drivers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <form method="GET">
            <label>County: 
                <select name="county">
                    <option value="">All Counties</option>
                    @foreach($counties as $county)
                        <option value="{{ $county->county }}">{{ $county->county }}</option>
                    @endforeach
                </select>
            </label>
            <label>Sub-County: <input type="text" name="sub_county"></label>
            <button type="submit">Filter</button>
        </form>

        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>County</th>
                    <th>Sub-County</th>
                    <th>Registration Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $driver->first_name }} {{ $driver->last_name }}</td>
                        <td>{{ $driver->phone }}</td>
                        <td>{{ $driver->email }}</td>
                        <td>{{ $driver->county }}</td>
                        <td>{{ $driver->sub_county }}</td>
                        <td>{{ $driver->created_at->toDateString() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $drivers->links() }}
    </div>
</x-app-layout>
