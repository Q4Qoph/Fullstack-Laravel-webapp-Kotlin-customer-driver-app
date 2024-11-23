package com.example.driveapp

import android.os.Bundle
import android.view.View
import android.widget.*
import androidx.activity.ComponentActivity
import androidx.lifecycle.lifecycleScope
import com.example.driveapp.data.models.Driver
import com.example.driveapp.data.network.ApiService
import com.example.driveapp.data.network.RetrofitClient
import kotlinx.coroutines.launch

class RegistrationActivity : ComponentActivity() {
    private lateinit var apiService: ApiService
    private lateinit var countySpinner: Spinner
    private lateinit var subCountySpinner: Spinner

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_registration)

        // Initialize UI components
        apiService = RetrofitClient.apiService
        countySpinner = findViewById(R.id.countySpinner)
        subCountySpinner = findViewById(R.id.subCountySpinner)

        // Populate gender spinner
        populateGenderSpinner()

        // Fetch and populate counties
        fetchCounties()

        // Register button click listener
        findViewById<Button>(R.id.registerButton).setOnClickListener {
            validateAndRegisterDriver()
        }
    }

    private fun populateGenderSpinner() {
        val genders = listOf("Male", "Female", "Other")
        val adapter = ArrayAdapter(this, android.R.layout.simple_spinner_item, genders)
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
        findViewById<Spinner>(R.id.genderSpinner).adapter = adapter
    }

    private fun fetchCounties() {
        lifecycleScope.launch {
            try {
                val response = apiService.getCounties()
                if (response.isSuccessful) {
                    val counties = response.body() ?: emptyList()
                    populateCountySpinner(counties)
                } else {
                    showToast("Failed to load counties: ${response.message()}")
                }
            } catch (e: Exception) {
                showToast("Error fetching counties: ${e.message}")
            }
        }
    }

    private fun populateCountySpinner(counties: List<String>) {
        val adapter = ArrayAdapter(this, android.R.layout.simple_spinner_item, counties)
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
        countySpinner.adapter = adapter

        countySpinner.onItemSelectedListener = object : AdapterView.OnItemSelectedListener {
            override fun onItemSelected(parent: AdapterView<*>?, view: View?, position: Int, id: Long) {
                val selectedCounty = counties[position]
                fetchSubCounties(selectedCounty)
            }

            override fun onNothingSelected(parent: AdapterView<*>?) {}
        }
    }

    private fun fetchSubCounties(county: String) {
        lifecycleScope.launch {
            try {
                val response = apiService.getSubCounties(county)
                if (response.isSuccessful) {
                    val subCounties = response.body() ?: emptyList()
                    populateSubCountySpinner(subCounties)
                } else {
                    showToast("Failed to load sub-counties: ${response.message()}")
                }
            } catch (e: Exception) {
                showToast("Error fetching sub-counties: ${e.message}")
            }
        }
    }

    private fun populateSubCountySpinner(subCounties: List<String>) {
        val adapter = ArrayAdapter(this, android.R.layout.simple_spinner_item, subCounties)
        adapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item)
        subCountySpinner.adapter = adapter
    }

    private fun validateAndRegisterDriver() {
        val driver = Driver(
            firstName = findViewById<EditText>(R.id.firstNameInput).text.toString().trim(),
            lastName = findViewById<EditText>(R.id.lastNameInput).text.toString().trim(),
            phone = findViewById<EditText>(R.id.phoneInput).text.toString().trim(),
            pin = findViewById<EditText>(R.id.pinInput).text.toString().trim(),
            gender = findViewById<Spinner>(R.id.genderSpinner).selectedItem.toString(),
            email = findViewById<EditText>(R.id.emailInput).text.toString().trim(),
            county = countySpinner.selectedItem?.toString() ?: "",
            subCounty = subCountySpinner.selectedItem?.toString() ?: ""
        )

        // Validate input fields
        if (driver.firstName.isEmpty() || driver.lastName.isEmpty() || driver.phone.isEmpty() ||
            driver.pin.isEmpty() || driver.email.isEmpty() || driver.county.isEmpty() || driver.subCounty.isEmpty()
        ) {
            showToast("Please fill in all fields")
            return
        }

        if (!android.util.Patterns.EMAIL_ADDRESS.matcher(driver.email).matches()) {
            showToast("Invalid email address")
            return
        }

        if (driver.phone.length != 10 || !driver.phone.startsWith("07")) {
            showToast("Invalid phone number")
            return
        }

        // Make API call
        lifecycleScope.launch {
            try {
                val response = apiService.registerDriver(driver)
                if (response.isSuccessful) {
                    showToast("Registration successful")
                } else {
                    showToast("Registration failed: ${response.message()}")
                }
            } catch (e: Exception) {
                showToast("Error during registration: ${e.message}")
            }
        }
    }

    private fun showToast(message: String) {
        Toast.makeText(this, message, Toast.LENGTH_SHORT).show()
    }
}
