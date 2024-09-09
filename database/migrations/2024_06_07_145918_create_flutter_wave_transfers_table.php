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
        Schema::create('flutter_wave_transfers', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->unsigned();
            $table->string("account_number");
            $table->string("bank_code");
            $table->string("account_name")->nullable();
            $table->string("bank");
            $table->double("amount",20,2);
            $table->string("narration")->nullable();
            $table->string("reference");
            $table->string("status")->default("pending");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flutter_wave_transfers');
    }
};
