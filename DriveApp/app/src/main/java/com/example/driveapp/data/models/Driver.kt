package com.example.driveapp.data.models

import com.google.gson.annotations.SerializedName

data class Driver(
    @SerializedName("first_name") val firstName: String,
    @SerializedName("last_name") val lastName: String,
    @SerializedName("phone") val phone: String,
    @SerializedName("pin") val pin: String,
    @SerializedName("gender") val gender: String,
    @SerializedName("email") val email: String,
    @SerializedName("county") val county: String,
    @SerializedName("sub_county") val subCounty: String
)

data class LoginRequest(
    val phone: String,
    val pin: String
)



data class LoginResponse(
    val token: String,
    @SerializedName("driver") val driver: DriverWithId
)

data class DriverWithId(
    @SerializedName("id") val id: Int,
    @SerializedName("first_name") val firstName: String,
    @SerializedName("last_name") val lastName: String,
    @SerializedName("phone") val phone: String,
    @SerializedName("pin") val pin: String,
    @SerializedName("gender") val gender: String,
    @SerializedName("email") val email: String,
    @SerializedName("county") val county: String,
    @SerializedName("sub_county") val subCounty: String,
    @SerializedName("created_at") val createdAt: String,
    @SerializedName("updated_at") val updatedAt: String,
    @SerializedName("status") val status: String
)

