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
        Schema::create('cheques', function (Blueprint $table) {
            $table->id();
            $table->string('cheque_number')->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('type')->nullable(); //in /out
            $table->double('amount')->nullable();
            $table->string('payee_name')->nullable(); //out (supplier name)
            $table->unsignedBigInteger('payee_id')->nullable(); //out (supplier id)
            $table->unsignedBigInteger('payee_account_id')->nullable(); //out (supplier account id)
            $table->string('payer_name')->nullable(); //in (customer name)
            $table->unsignedBigInteger('payer_id')->nullable(); //in (customer id)
            $table->unsignedBigInteger('payer_account_id')->nullable(); //in (customer account id)
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('status')->nullable(); //pending / cleared / bounced / returned
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheques');
    }
};
