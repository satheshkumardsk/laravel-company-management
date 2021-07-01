<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',255);
            $table->string('last_name',255);

            // $table->unsignedBigInteger('company_id');
            // $table->foreign('company_id')->references('id')->on('companies');
            $table->foreignId('company_id')->constrained()->onUpdate('cascade')->onDelete('cascade');

            $table->string('email',255)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('designation',255)->nullable();
            $table->integer('active_status');
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
        Schema::dropIfExists('employees');
    }
}
