package com.example.driveapp

import android.util.Log
import com.google.firebase.messaging.FirebaseMessagingService
import com.google.firebase.messaging.RemoteMessage
import android.app.Notification
import android.app.NotificationChannel
import android.app.NotificationManager
import android.content.Context
import android.os.Build

class MyFirebaseMessagingService : FirebaseMessagingService() {

    override fun onMessageReceived(remoteMessage: RemoteMessage) {
        // Check if the message contains a notification
        remoteMessage.notification?.let {
            // Handle the notification (e.g., show a system notification)
            val title = it.title
            val body = it.body
            Log.d("FCM", "Notification received: $title - $body")
            // You can also show a custom notification here
        }

        // Check if the message contains data
        remoteMessage.data.isNotEmpty().let {
            // Handle the data
            val rideId = remoteMessage.data["rideId"]
            val pickupPoint = remoteMessage.data["pickup_point"]
            val dropoffPoint = remoteMessage.data["dropoff_point"]
            // Handle this data (e.g., update UI, show a dialog)
            Log.d("FCM", "Ride Request: $rideId, $pickupPoint to $dropoffPoint")
        }
    }

    override fun onNewToken(token: String) {
        // This method is called when a new FCM token is generated
        Log.d("FCM", "New FCM token: $token")

        // Send the token to your backend (e.g., via API call)
        sendTokenToBackend(token)
    }

    private fun sendTokenToBackend(token: String) {
        // You should send the FCM token to your backend so that it can be stored and used
        // to send notifications to this specific driver.
    }


    fun showNotification(title: String, body: String) {
        val notificationManager = getSystemService(Context.NOTIFICATION_SERVICE) as NotificationManager
        val channelId = "ride_requests"

        // Create the NotificationChannel (required for Android 8.0 and above)
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.O) {
            val channel = NotificationChannel(
                channelId,
                "Ride Requests",
                NotificationManager.IMPORTANCE_DEFAULT
            )
            notificationManager.createNotificationChannel(channel)
        }

        // Build the notification
        val notification = Notification.Builder(this, channelId)
            .setContentTitle(title)
            .setContentText(body)
            .setSmallIcon(R.drawable.ic_notification)
            .build()

        // Show the notification
        notificationManager.notify(1, notification)
    }

}