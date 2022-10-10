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
        Schema::create('suboutputs', function (Blueprint $table) {
            $table->id();
            $table->string('suboutput');
            $table->string('type');
            $table->foreignId('output_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('duration_id')->constrained();
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
        Schema::dropIfExists('suboutputs');
    }
};
