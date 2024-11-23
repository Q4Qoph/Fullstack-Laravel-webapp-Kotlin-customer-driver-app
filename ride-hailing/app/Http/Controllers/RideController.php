<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ride;
use App\Models\County;
use App\Models\Driver;
use App\Notifications\RideRequestNotification;

class RideController extends Controller
{
    public function index(Request $request)
{
    // Fetch counties (if needed for filtering)
    $counties = County::all(); // Ensure County model is defined and populated.

    // Fetch rides with sorting
    $rides = Ride::query()
        ->when($request->has('county'), function ($query) use ($request) {
            $query->where('county', $request->county);
        })
        ->when($request->has('sub_county'), function ($query) use ($request) {
            $query->where('sub_county', $request->sub_county);
        })
        ->orderBy('created_at', 'desc') // Latest rides at the top
        ->get();

    return view('rides.index', compact('rides', 'counties'));
}
public function store(Request $request)
{
    $validated = $request->validate([
        'pickup_point' => 'required|string',
        'dropoff_point' => 'required|string',
        'number_of_passengers' => 'required|integer',
        'customer_id' => 'required|exists:customers,id',
    ]);

    // Find the closest or most suitable online driver
    $driver = Driver::where('status', 'online')->first();

    if (!$driver) {
        return response()->json(['message' => 'No drivers available'], 404);
    }

    // Save the ride request
    $ride = Ride::create([
        'pickup_point' => $validated['pickup_point'],
        'dropoff_point' => $validated['dropoff_point'],
        'number_of_passengers' => $validated['number_of_passengers'],
        'customer_id' => $validated['customer_id'],
        'driver_id' => null, // Will assign after confirmation
    ]);

    try {
        // Notify driver about the request
        $driver->notify(new RideRequestNotification($ride));
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to notify driver', 'error' => $e->getMessage()], 500);
    }

    return response()->json([
        'message' => 'Ride request sent to driver',
        'ride' => $ride,
        'driver' => $driver,
    ]);
}




public function requestRide(Request $request)
{
    // Example ride details
    $rideDetails = [
        'pickup_point' => 'required|string',
        'drop_off_point' => 'required|string',
        'number_of_passengers' => 'required|integer',
        'customer_name' => 'required|string',
        'customer_phone' => 'required|string',
    ];

    // Find an available driver (example logic)
    $driver = Driver::where('status', 'online')->first();

    if ($driver) {
        // Notify the driver
        $driver->notify(new RideRequestNotification($rideDetails));
        return response()->json(['message' => 'Ride request sent to driver.']);
    } else {
        return response()->json(['message' => 'No drivers are currently online.'], 400);
    }
}

public function getCustomerRides($customerId)
{
    $rides = Ride::where('customer_id', $customerId)
        ->with('driver:id,first_name,last_name') // Include driver info
        ->orderBy('created_at', 'desc') // Latest rides at the top
        ->get();

    return response()->json($rides);
}

    
}
