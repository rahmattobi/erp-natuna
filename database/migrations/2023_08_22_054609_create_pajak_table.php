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
        Schema::create('pajaks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ntpn');
            $table->unsignedBigInteger('id_invoice_detail');
            $table->timestamps();
            $table->foreign('id_invoice_detail')->references('id')->on('invoice_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pajaks');
    }
};
