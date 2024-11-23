package com.example.driveapp.ui

import android.content.Context.MODE_PRIVATE
import android.os.Bundle
import android.util.Log
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.Toast
import androidx.fragment.app.Fragment
import com.example.driveapp.R
import com.example.driveapp.data.network.RetrofitClient
import kotlinx.coroutines.CoroutineScope
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.launch
import kotlinx.coroutines.withContext

class HomeFragment : Fragment() {

    private lateinit var goOnlineButton: Button
    private lateinit var goOfflineButton: Button

    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_home, container, false)

        // Initialize buttons
        goOnlineButton = view.findViewById(R.id.goOnlineButton)
        goOfflineButton = view.findViewById(R.id.goOfflineButton)

        // Set button click listeners
        goOnlineButton.setOnClickListener {
            updateDriverStatus(true)
        }

        goOfflineButton.setOnClickListener {
            updateDriverStatus(false)
        }

        return view
    }

    // Function to retrieve driver ID from SharedPreferences
    private fun getDriverId(): String? {
        val sharedPref = requireActivity().getSharedPreferences("DriverAppPrefs", MODE_PRIVATE)
        val driverId = sharedPref.getString("driverId", null)
        Log.d("HomeFragment", "Retrieved driverId: $driverId")
        return driverId
    }

    private fun updateDriverStatus(isOnline: Boolean) {
        val status = if (isOnline) "online" else "offline"
        val driverId = getDriverId()

        if (driverId.isNullOrEmpty()) {
            Toast.makeText(context, "Driver ID not found. Please log in again.", Toast.LENGTH_LONG).show()
            return
        }

        CoroutineScope(Dispatchers.IO).launch {
            try {
                val response = RetrofitClient.apiService.updateDriverStatus(
                    driverId = driverId,
                    statusUpdate = mapOf("status" to status)
                )
                withContext(Dispatchers.Main) {
                    if (response.isSuccessful) {
                        // Backend update successful
                        handleStatusUpdateUI(isOnline)
                        Toast.makeText(
                            context,
                            "You are now ${if (isOnline) "online" else "offline"}.",
                            Toast.LENGTH_SHORT
                        ).show()
                    } else {
                        // Handle unsuccessful response
                        val errorMessage = response.errorBody()?.string() ?: "Unknown error"
                        Toast.makeText(context, "Failed to update status: $errorMessage", Toast.LENGTH_LONG).show()
                    }
                }
            } catch (e: Exception) {
                // Handle exceptions
                withContext(Dispatchers.Main) {
                    Toast.makeText(context, "An error occurred: ${e.localizedMessage}", Toast.LENGTH_LONG).show()
                }
            }
        }
    }

    private fun handleStatusUpdateUI(isOnline: Boolean) {
        goOnlineButton.visibility = if (isOnline) View.GONE else View.VISIBLE
        goOfflineButton.visibility = if (isOnline) View.VISIBLE else View.GONE
    }
}
