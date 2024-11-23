<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $drivers = Driver::query();

        if ($request->filled('county')) {
            $drivers->where('county', $request->county);
        }

        if ($request->filled('sub_county')) {
            $drivers->where('sub_county', $request->sub_county);
        }

        $drivers = $drivers->orderBy('created_at', 'desc')->paginate(10);

        return view('drivers.index', compact('drivers'));
    }

    public function toggleStatus(Request $request, $driverId)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|string|in:online,offline',
        ]);
    
        // Find the driver
        $driver = Driver::find($driverId);
    
        if (!$driver) {
            return response()->json(['error' => 'Driver not found'], 404);
        }
    
        // Update the driver's status
        $driver->status = $request->input('status');
        $driver->save();
    
        return response()->json(['status' => $driver->status], 200);
    }
    
}
