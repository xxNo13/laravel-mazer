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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->string('alloted_budget')->nullable();
            $table->string('responsible')->nullable();
            $table->string('accomplishment');
            $table->string('efficiency');
            $table->string('quality');
            $table->string('timeliness');
            $table->string('average');
            $table->string('remarks');
            $table->string('type');
            $table->foreignId('user_id')->onDelete('cascade');
            $table->foreignId('target_id')->onDelete('cascade');
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
        Schema::dropIfExists('ratings');
    }
};
