package com.example.driveapp.data.network

import com.example.driveapp.data.models.Driver
import com.example.driveapp.data.models.LoginRequest
import com.example.driveapp.data.models.LoginResponse
//import com.google.android.gms.common.api.Response
import retrofit2.Response

import retrofit2.http.Body
import retrofit2.http.GET
import retrofit2.http.PATCH
import retrofit2.http.POST
import retrofit2.http.Path
import retrofit2.http.Query

interface ApiService {
    @GET("/api/counties")
    suspend fun getCounties(): Response<List<String>>

    @GET("/api/counties/{countyName}/sub-counties")
    suspend fun getSubCounties(@Path("countyName") countyName: String): Response<List<String>>

//    @GET("/api/sub-counties")
//    suspend fun getSubCounties(@Query("county") county: String): Response<List<String>>

    @POST("/api/register/driver")
    suspend fun registerDriver(@Body driver: Driver): Response<Any>

    @POST("/api/login/driver")
    suspend fun loginDriver(@Body loginRequest: LoginRequest): Response<LoginResponse>

    @PATCH("/api/drivers/{id}/toggle-status")
    suspend fun updateDriverStatus(
        @Path("id") driverId: String, // Corrected the path variable name
        @Body statusUpdate: Map<String, String> // Payload should match the backend's expected format
    ): Response<Any>

}

//interface ApiService {
//    @POST("register/driver")
//    suspend fun registerDriver(@Body driver: Driver): Response<Any>
//
////    @POST("register/customer")
////    suspend fun registerCustomer(@Body customer: Customer): Response<Any>
//
////    @GET("counties")
////    suspend fun getCounties(): Response<List<County>>
//}
