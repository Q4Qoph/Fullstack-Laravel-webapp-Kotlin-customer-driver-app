<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        // Fetch customers sorted by date
        $customers = Customer::query();

        if ($request->has('sort') && $request->sort === 'asc') {
            $customers->orderBy('created_at', 'asc');
        } else {
            $customers->orderBy('created_at', 'desc');
        }

        $customers = $customers->paginate(10);

        return view('customers.index', compact('customers'));
    }
}


