<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    use SoftDeletes;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accpkg_accounts', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            // assets, liabilities, equity, expenses, and income
            $table->enum("type", ['assets', 'liabilities', 'equity', 'income', 'expenses']);
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->integer("ref_id")->nullable();
            $table->char("ref_type", 5)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('accpkg_accounts');
    }
}
