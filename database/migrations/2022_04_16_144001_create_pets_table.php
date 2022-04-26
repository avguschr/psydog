<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128)->nullable(false);
            $table->date('birthday')->nullable(false);
            $table->string('image', 1000)->nullable(true);
            $table->enum('gender', ['male', 'female'])->nullable(false);
            $table->string('breed', 256)->nullable(false);
            $table->foreignId('owner_id')->nullable(false)->constrained('users', 'id')->
            onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pets');
    }
}
