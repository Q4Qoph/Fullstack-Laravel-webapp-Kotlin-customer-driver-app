package com.example.driveapp.data.network

import okhttp3.OkHttpClient
import okhttp3.logging.HttpLoggingInterceptor
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory

object RetrofitClient {
    private const val BASE_URL = "http://192.168.43.46:8000/"

    private val loggingInterceptor: HttpLoggingInterceptor by lazy {
        HttpLoggingInterceptor { message ->
            android.util.Log.d("RetrofitLog", message) // Logs all HTTP activity to Logcat
        }.apply {
            level = HttpLoggingInterceptor.Level.BODY // Logs headers, body, etc.
        }
    }

    private val okHttpClient: OkHttpClient by lazy {
        OkHttpClient.Builder()
            .addInterceptor(loggingInterceptor) // Attach the logging interceptor
            .build()
    }

    val apiService: ApiService by lazy {
        Retrofit.Builder()
            .baseUrl(BASE_URL)
            .client(okHttpClient) // Add the custom OkHttpClient
            .addConverterFactory(GsonConverterFactory.create()) // For JSON parsing
            .build()
            .create(ApiService::class.java)
    }
}
