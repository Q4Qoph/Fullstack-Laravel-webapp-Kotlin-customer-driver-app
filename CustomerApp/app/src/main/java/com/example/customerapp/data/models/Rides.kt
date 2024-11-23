package com.example.customerapp.data.models



data class Rides(
    val id: Int,
    val pickupPoint: String,
    val dropoffPoint: String,
    val passengers: Int,
    val status: String,
    val driver: Driver? = null
)

data class Driver(
    val id: Int,
    val firstName: String,
    val lastName: String
)

