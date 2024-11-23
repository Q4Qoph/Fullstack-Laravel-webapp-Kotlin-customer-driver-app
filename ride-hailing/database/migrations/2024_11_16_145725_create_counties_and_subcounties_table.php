<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the counties table
        Schema::create('counties', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // County name
            $table->timestamps();
        });

        // Create the sub_counties table
        Schema::create('sub_counties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('county_id'); // Foreign key referencing counties
            $table->string('name'); // Sub-county name
            $table->timestamps();

            // Add the foreign key constraint
            $table->foreign('county_id')
                ->references('id')
                ->on('counties')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the sub_counties table first to avoid foreign key constraint issues
        Schema::dropIfExists('sub_counties');
        // Then drop the counties table
        Schema::dropIfExists('counties');
    }
};
