package com.example.customerapp.ui.adapters

import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.customerapp.R
import com.example.customerapp.data.models.Ride
import com.example.customerapp.data.models.Rides

class RideAdapter : RecyclerView.Adapter<RideAdapter.RideViewHolder>() {
    private var rides = listOf<Rides>()

    fun setRides(newRides: List<Rides>) {
        rides = newRides
        notifyDataSetChanged()
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): RideViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_ride, parent, false)
        return RideViewHolder(view)
    }

    override fun onBindViewHolder(holder: RideViewHolder, position: Int) {
        val ride = rides[position]
        holder.bind(ride)
    }

    override fun getItemCount(): Int = rides.size

    class RideViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        private val tvPickup = itemView.findViewById<TextView>(R.id.tvPickup)
        private val tvDropoff = itemView.findViewById<TextView>(R.id.tvDropoff)
        private val tvStatus = itemView.findViewById<TextView>(R.id.tvStatus)

        fun bind(ride: Rides) {
            tvPickup.text = "Pickup: ${ride.pickupPoint}"
            tvDropoff.text = "Dropoff: ${ride.dropoffPoint}"
            tvStatus.text = "Status: ${ride.status}"
        }
    }
}