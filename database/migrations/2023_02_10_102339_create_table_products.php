<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the table already exists
        if (Schema::hasTable('products')) {
            return;
        }

        // Create the table if it doesn't exist
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('description');
            $table->string('image');
            $table->integer('price');
            $table->integer('quantity');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the table if it exists
        Schema::dropIfExists('products');
    }
};
