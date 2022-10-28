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
        Schema::create('supp_percentages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('percent');
            $table->foreignId('percentage_id')->onDelete('cascade');
            $table->foreignId('user_id')->onDelete('cascade');
            $table->foreignId('duration_id')->onDelete('cascade');
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
        Schema::dropIfExists('supp_percentages');
    }
};
