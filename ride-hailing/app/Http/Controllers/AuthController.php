<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Driver;
use App\Models\Customer;

class AuthController extends Controller
{
    /**
     * Register a new driver.
     */
    public function registerDriver(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|unique:drivers',
                'pin' => 'required|min:4|max:4',
                'gender' => 'required|string',
                'email' => 'required|email|unique:drivers',
                'county' => 'required|string',
                'sub_county' => 'required|string',
            ]);

            $driver = Driver::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'pin' => Hash::make($validated['pin']),
                'gender' => $validated['gender'],
                'email' => $validated['email'],
                'county' => $validated['county'],
                'sub_county' => $validated['sub_county'],
            ]);

            return response()->json(['message' => 'Driver registered successfully'], 201);
        } catch (\Exception $e) {
            \Log::error('Driver registration failed: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred during registration'], 500);
        }
    }

    /**
     * Login a driver.
     */
    public function loginDriver(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required|string',
                'pin' => 'required|min:4|max:4',
            ]);

            $driver = Driver::where('phone', $request->phone)->first();

            if ($driver && Hash::check($request->pin, $driver->pin)) {
                $token = $driver->createToken('driverToken')->plainTextToken;

                return response()->json([
                    'token' => $token,
                    'driver' => $driver,
                ]);
            }

            return response()->json(['message' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {
            \Log::error('Driver login failed: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred during login'], 500);
        }
    }

    /**
     * Register a new customer.
     */
    public function registerCustomer(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|unique:customers',
                'pin' => 'required|min:4|max:4',
                'gender' => 'required|string',
                'email' => 'required|email|unique:customers',
                'county' => 'required|string',
                'sub_county' => 'required|string',
            ]);

            $customer = Customer::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'pin' => Hash::make($validated['pin']),
                'gender' => $validated['gender'],
                'email' => $validated['email'],
                'county' => $validated['county'],
                'sub_county' => $validated['sub_county'],
            ]);

            return response()->json(['message' => 'Customer registered successfully'], 201);
        } catch (\Exception $e) {
            \Log::error('Customer registration failed: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred during registration'], 500);
        }
    }

    /**
     * Login a customer.
     */
    public function loginCustomer(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'required|string',
                'pin' => 'required|min:4|max:4',
            ]);

            $customer = Customer::where('phone', $request->phone)->first();

            if ($customer && Hash::check($request->pin, $customer->pin)) {
                $token = $customer->createToken('customerToken')->plainTextToken;

                return response()->json([
                    'token' => $token,
                    'customer' => $customer,
                ]);
            }

            return response()->json(['message' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {
            \Log::error('Customer login failed: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred during login'], 500);
        }
    }
}
