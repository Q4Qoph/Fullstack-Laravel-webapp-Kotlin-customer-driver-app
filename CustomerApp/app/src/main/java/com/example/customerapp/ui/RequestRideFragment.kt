package com.example.customerapp.ui

import android.content.Context
import android.os.Bundle
import androidx.fragment.app.Fragment
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.EditText
import android.widget.Toast
import com.example.customerapp.R
import com.example.customerapp.data.models.Ride
import com.example.customerapp.data.network.RetrofitClient
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch

class RequestRideFragment : Fragment() {
    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_request_ride, container, false)

        // Get customer details from SharedPreferences
        val sharedPreferences = requireContext().getSharedPreferences("CustomerAppPrefs", Context.MODE_PRIVATE)
        val customerName = sharedPreferences.getString("customerName", "Unknown") // Default to "Unknown"
        val customerPhone = sharedPreferences.getString("customerPhone", "000000000") // Default to dummy phone
        val customerId = sharedPreferences.getInt("customerId", -1) // Default to -1 if not found

        if (customerId == -1) {
            Toast.makeText(requireContext(), "Customer not logged in!", Toast.LENGTH_SHORT).show()
            return view
        }

        // Set up form submission
        view.findViewById<View>(R.id.btnSubmitRideRequest).setOnClickListener {
            val pickupPoint = view.findViewById<EditText>(R.id.etPickupPoint).text.toString()
            val dropOffPoint = view.findViewById<EditText>(R.id.etDropOffPoint).text.toString()
            val numberOfPassengers = view.findViewById<EditText>(R.id.etNumberOfPassengers).text.toString()

            if (pickupPoint.isEmpty() || dropOffPoint.isEmpty() || numberOfPassengers.isEmpty()) {
                Toast.makeText(requireContext(), "Please fill in all fields.", Toast.LENGTH_SHORT).show()
            } else {
                // Create Ride object with dynamic customer data
                val rideRequest = Ride(
                    pickupPoint = pickupPoint,
                    dropOffPoint = dropOffPoint,
                    numberOfPassengers = numberOfPassengers.toInt(),
                    customerName = customerName ?: "Unknown",
                    customerPhone = customerPhone ?: "000000000",
                    customerId = customerId
                )

                // Send ride request to backend
                sendRideRequestToBackend(rideRequest)
            }
        }

        return view
    }

    private fun sendRideRequestToBackend(rideRequest: Ride) {
        CoroutineScope(Dispatchers.IO).launch {
            try {
                val response = RetrofitClient.apiService.submitRideRequest(rideRequest)
                if (response.isSuccessful) {
                    CoroutineScope(Dispatchers.Main).launch {
                        Toast.makeText(requireContext(), "Ride request submitted!", Toast.LENGTH_SHORT).show()
                    }
                } else {
                    CoroutineScope(Dispatchers.Main).launch {
                        Toast.makeText(requireContext(), "No drivers available.", Toast.LENGTH_SHORT).show()
                    }
                }
            } catch (e: Exception) {
                CoroutineScope(Dispatchers.Main).launch {
                    Toast.makeText(requireContext(), "Error: ${e.message}", Toast.LENGTH_SHORT).show()
                }
            }
        }
    }
}
