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
        Schema::create('agreegator_earnings', function (Blueprint $table) {
            $table->id();
            $table->integer("agreegator_id");
            $table->integer("user_id");
            $table->string("name");
            $table->string("earned_from");
            $table->double("amount",20,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreegator_earnings');
    }
};
