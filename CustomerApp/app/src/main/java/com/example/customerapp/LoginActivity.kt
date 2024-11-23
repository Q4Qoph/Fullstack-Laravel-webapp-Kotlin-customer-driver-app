package com.example.customerapp

import android.content.Intent
import android.os.Bundle
import android.util.Log
import android.widget.Button
import android.widget.EditText
import android.widget.Toast
import androidx.activity.ComponentActivity
import androidx.lifecycle.lifecycleScope
import com.example.customerapp.data.models.LoginRequest
import com.example.customerapp.data.network.ApiService
import com.example.customerapp.data.network.RetrofitClient
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

            loginCustomer(phone, pin)
        }
    }

    private fun loginCustomer(phone: String, pin: String) {
        val loginRequest = LoginRequest(phone, pin)

        lifecycleScope.launch {
            try {
                val response = apiService.loginCustomer(loginRequest)
                if (response.isSuccessful && response.body() != null) {
                    val loginResponse = response.body()!!

                    Log.d("LoginActivity", "LoginResponse: $loginResponse")

                    val customerId = loginResponse.customer.id
                    val firstName = loginResponse.customer.firstName
                    val lastName = loginResponse.customer.lastName
                    val customerPhone = loginResponse.customer.phone

                    // Save customer details
                    saveCustomerDetails(customerId, loginResponse.token, firstName, lastName, customerPhone)

                    showToast("Welcome, $firstName")

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



    private fun saveCustomerDetails(customerId: Int, token: String, firstName: String, lastName: String, phone: String) {
        val sharedPreferences = getSharedPreferences("CustomerAppPrefs", MODE_PRIVATE)
        sharedPreferences.edit()
            .putInt("customerId", customerId)  // Store as an Int
            .putString("authToken", token)    // Store token
            .putString("customerName", "$firstName $lastName") // Save full name
            .putString("customerPhone", phone) // Save phone number
            .apply()

        Log.d("LoginActivity", "Saved customerId: $customerId, token: $token, name: $firstName $lastName, phone: $phone")
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
