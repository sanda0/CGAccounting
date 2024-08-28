<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accpkg_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("from_account");
            $table->unsignedBigInteger("to_account");
            $table->double("debit")->default(0);
            $table->double("credit")->default(0);
            $table->double("balance")->default(0);
            $table->integer("ref_id")->nullable();
            $table->char("ref_type",10)->nullable();
            $table->string("description",60)->nullable();

            $table->timestamps();

            $table->foreign('from_account')->references('id')->on('accpkg_accounts')->onDelete('cascade');
            $table->foreign('to_account')->references('id')->on('accpkg_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accpkg_entries');
    }

    /*

    Credit (facc,tacc,amount,ref_id = null,ref_type = null,description = null)

    Debit (facc,tacc,amount,ref_id = null,ref_type = null,description = null)

    cash --> 1000

    lite bill <-- 1000


    Credit
    ----------------------------------------------------------------
     lrb = form account->last_row_balance
        t = form account->type

        if t == "assets" || t == "expense" {
            new_bal = lrb - amount
        }
        if t == "liability" || t == "equity" || t == "income"{
            new_bal = lrb + amount
        }



    Dedit
    ----------------------------------------------------------------
     lrb = form account->last_row_balance
        t = form account->type

        if t == "assets" || t == "expense" {
            new_bal = lrb + amount
        }
        if t == "liability" || t == "equity" || t == "income"{
            new_bal = lrb - amount
        }





    */




}
