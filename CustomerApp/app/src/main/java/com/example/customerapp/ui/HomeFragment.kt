package com.example.customerapp.ui

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.fragment.app.Fragment
import com.example.customerapp.R

class HomeFragment : Fragment() {
    override fun onCreateView(
        inflater: LayoutInflater, container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        val view = inflater.inflate(R.layout.fragment_home, container, false)

        // Set up button listener
        view.findViewById<View>(R.id.btnRequestRide).setOnClickListener {
            // Navigate to Request Ride Fragment
            requireActivity().supportFragmentManager.beginTransaction()
                .replace(R.id.fragment_container, RequestRideFragment())
                .addToBackStack(null)
                .commit()
        }

        return view
    }
}