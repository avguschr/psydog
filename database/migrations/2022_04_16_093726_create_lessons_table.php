<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->timestamp('start')->nullable(false);
            $table->timestamp('end')->nullable(false);
            $table->integer('max')->nullable(false)->default(1);
            $table->foreignId('service_id')->nullable(false)->constrained('services', 'id')->
            onDelete('cascade');
            $table->foreignId('tutor_id')->nullable(false)->constrained('users', 'id')->
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
        Schema::dropIfExists('lessons');
    }
}
