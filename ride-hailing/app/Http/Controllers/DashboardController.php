<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Driver;
use App\Models\Ride;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch counts of customers, drivers, and completed rides
        $customerCount = Customer::count();
        $driverCount = Driver::count();
        $completedRidesCount = Ride::where('status', 'completed')->count();

        // Return the dashboard view with the data
        return view('dashboard', compact('customerCount', 'driverCount', 'completedRidesCount'));
    }
}
