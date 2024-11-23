package com.example.customerapp.data.models

data class Ride(
    val pickupPoint: String,
    val dropOffPoint: String,
    val numberOfPassengers: Int,
    val customerName: String,
    val customerPhone: String,
    val customerId: Int
)
