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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->unsigned();
            $table->string("account_number");
            $table->string('account_name');
            $table->string("bank");
            $table->string('bank_code');
            $table->double('amount',20,2);
            $table->string("reference");
            $table->string("status")->default("successful");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
