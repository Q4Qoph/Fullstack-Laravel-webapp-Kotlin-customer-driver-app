package com.example.driveapp

import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.widget.Button
import android.widget.EditText
import android.widget.Toast
import androidx.activity.ComponentActivity
import androidx.lifecycle.lifecycleScope
import com.example.driveapp.data.models.LoginRequest
import com.example.driveapp.data.network.ApiService
import com.example.driveapp.data.network.RetrofitClient
import kotlinx.coroutines.launch

class LoginActivity : ComponentActivity() {
    private lateinit var apiService: ApiService

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_login)

        // Initialize API service
        apiService = RetrofitClient.apiService

        // Handle login button click
        findViewById<Button>(R.id.loginButton).setOnClickListener {
            val phone = findViewById<EditText>(R.id.phoneInput).text.toString().trim()
            val pin = findViewById<EditText>(R.id.pinInput).text.toString().trim()

            if (phone.isEmpty() || pin.isEmpty()) {
                showToast("Please fill in all fields")
                return@setOnClickListener
            }

            loginDriver(phone, pin)
        }
    }

    private fun loginDriver(phone: String, pin: String) {
        val loginRequest = LoginRequest(phone, pin)

        lifecycleScope.launch {
            try {
                val response = apiService.loginDriver(loginRequest)
                if (response.isSuccessful && response.body() != null) {
                    val loginResponse = response.body()!!

                    Log.d("LoginActivity", "LoginResponse: $loginResponse")

                    val driverId = loginResponse.driver.id // Extract driver ID
                    saveDriverDetails(driverId.toString(), loginResponse.token)
                    showToast("Welcome, ${loginResponse.driver.firstName}")

                    // Navigate to the home page
                    navigateToHomePage()
                } else {
                    val errorMessage = response.errorBody()?.string() ?: "Login failed"
                    showToast("Error: $errorMessage")
                }
            } catch (e: Exception) {
                showToast("An error occurred: ${e.message}")
            }
        }
    }


    private fun saveDriverDetails(driverId: String, token: String) {
        val sharedPreferences = getSharedPreferences("DriverAppPrefs", MODE_PRIVATE)
        sharedPreferences.edit()
            .putString("driverId", driverId)  // Store driverId
            .putString("authToken", token)    // Store token
            .apply()

        Log.d("LoginActivity", "Saved driverId: $driverId, token: $token")
    }

    private fun navigateToHomePage() {
        val intent = Intent(this, HomeActivity::class.java)
        startActivity(intent)
        finish() // Prevent the user from going back to the login screen
    }

    private fun showToast(message: String) {
        Toast.makeText(this, message, Toast.LENGTH_SHORT).show()
    }
}
