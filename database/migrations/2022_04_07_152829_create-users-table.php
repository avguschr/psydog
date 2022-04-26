<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128)->nullable(false);
            $table->string('surname', 128)->nullable(false);
            $table->string('patronymic', 128)->nullable(false);
            $table->string('email', 128)->unique()->nullable(false);
            $table->string('password', 255)->nullable(false);
            $table->string('image', 1000)->nullable(true);
            $table->integer('role')->default(3);
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
        Schema::dropIfExists('users');
    }
}
