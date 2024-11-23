package com.example.customerapp.ui

import android.content.Context
import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.ProgressBar
import android.widget.Toast
import androidx.fragment.app.Fragment
import androidx.lifecycle.lifecycleScope
import androidx.recyclerview.widget.LinearLayoutManager
import androidx.recyclerview.widget.RecyclerView
import com.example.customerapp.R
import com.example.customerapp.data.network.RetrofitClient
import com.example.customerapp.ui.adapters.RideAdapter
import kotlinx.coroutines.launch

class MyRidesFragment : Fragment() {
    private lateinit var progressBar: ProgressBar
    private lateinit var rvRides: RecyclerView
    private lateinit var rideAdapter: RideAdapter

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_my_rides, container, false)

        // Initialize views
        progressBar = view.findViewById(R.id.progressBar)
        rvRides = view.findViewById(R.id.rvRides)
        rvRides.layoutManager = LinearLayoutManager(requireContext())

        // Set up RecyclerView adapter
        rideAdapter = RideAdapter()
        rvRides.adapter = rideAdapter

        // Fetch ride data
        fetchRides()

        return view
    }

    private fun fetchRides() {
        progressBar.visibility = View.VISIBLE

        // Retrieve customer ID from SharedPreferences
        val sharedPreferences = requireContext().getSharedPreferences("CustomerAppPrefs", Context.MODE_PRIVATE)
        val customerId = sharedPreferences.getInt("customerId", -1)

        if (customerId == -1) {
            progressBar.visibility = View.GONE
            Toast.makeText(requireContext(), "Customer ID not found. Please log in again.", Toast.LENGTH_SHORT).show()
            return
        }

        // Fetch rides for the logged-in customer
        viewLifecycleOwner.lifecycleScope.launch {
            try {
                val response = RetrofitClient.apiService.getCustomerRides(customerId)
                progressBar.visibility = View.GONE

                if (response.isSuccessful && response.body() != null) {
                    rideAdapter.setRides(response.body()!!) // Populate RecyclerView
                } else {
                    Toast.makeText(requireContext(), "Failed to fetch rides. Please try again.", Toast.LENGTH_SHORT).show()
                }
            } catch (e: Exception) {
                progressBar.visibility = View.GONE
                Toast.makeText(requireContext(), "Error: ${e.localizedMessage}", Toast.LENGTH_SHORT).show()
            }
        }
    }
}
