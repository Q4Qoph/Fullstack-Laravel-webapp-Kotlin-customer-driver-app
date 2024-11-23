package com.example.customerapp.data.network

import com.example.customerapp.data.models.Customer
import com.example.customerapp.data.models.LoginRequest
import com.example.customerapp.data.models.LoginResponse
import com.example.customerapp.data.models.Rides
import com.example.customerapp.data.models.Ride
import retrofit2.Response
import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.PATCH
import retrofit2.http.POST
import retrofit2.http.Path

interface ApiService {
    @GET("/api/counties")
    suspend fun getCounties(): Response<List<String>>

    @GET("/api/counties/{countyName}/sub-counties")
    suspend fun getSubCounties(@Path("countyName") countyName: String): Response<List<String>>


    @POST("/api/register/customer")
    suspend fun registerCustomer(@Body driver: Customer): Response<Any>

    @POST("/api/login/customer")
    suspend fun loginCustomer(@Body loginRequest: LoginRequest): Response<LoginResponse>

    @GET("rides/customer/{id}")
    suspend fun getCustomerRides(@Path("id") customerId: Int): Response<List<Rides>>

    @POST("/api/rides/request")
    suspend fun submitRideRequest(@Body rideRequest: Ride): Response<Any>


}
