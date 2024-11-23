package com.example.driveapp

import android.os.Bundle
import androidx.appcompat.app.ActionBarDrawerToggle
import androidx.appcompat.app.AppCompatActivity
import androidx.appcompat.widget.Toolbar
import androidx.drawerlayout.widget.DrawerLayout
import androidx.fragment.app.FragmentContainerView
import androidx.navigation.fragment.NavHostFragment
import androidx.navigation.ui.AppBarConfiguration
import androidx.navigation.ui.NavigationUI
import androidx.navigation.ui.navigateUp
import com.google.android.material.navigation.NavigationView

class HomeActivity : AppCompatActivity() {
    private lateinit var appBarConfiguration: AppBarConfiguration
    private lateinit var drawerLayout: DrawerLayout

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_home)
        // Setup Toolbar
        val toolbar: Toolbar = findViewById(R.id.toolbar)
        setSupportActionBar(toolbar)
        // Setup Drawer Layout
        drawerLayout = findViewById(R.id.drawerLayout)
        val navView = findViewById<NavigationView>(R.id.navigationView)

        // Fetch NavHostFragment using FragmentContainerView
        val navHostFragment = supportFragmentManager
            .findFragmentById(R.id.navHostFragment) as? NavHostFragment

        // Check if the NavHostFragment was found
        if (navHostFragment != null) {
            val navController = navHostFragment.navController

            // Setup Navigation with Drawer
            appBarConfiguration = AppBarConfiguration(navController.graph, drawerLayout)
            NavigationUI.setupWithNavController(navView, navController)
            NavigationUI.setupActionBarWithNavController(this, navController, appBarConfiguration)

            // Setup Toggle Button for Drawer
            val toggle = ActionBarDrawerToggle(
                this, drawerLayout, findViewById(R.id.toolbar),
                R.string.navigation_drawer_open, R.string.navigation_drawer_close
            )
            drawerLayout.addDrawerListener(toggle)
            toggle.syncState()
        } else {
            // Log an error or handle the case when NavHostFragment is not found
            throw IllegalStateException("NavHostFragment not found in the layout.")
        }
    }

    override fun onSupportNavigateUp(): Boolean {
        val navHostFragment = supportFragmentManager
            .findFragmentById(R.id.navHostFragment) as? NavHostFragment
        return navHostFragment?.navController?.navigateUp(appBarConfiguration)
            ?: super.onSupportNavigateUp()
    }
}
