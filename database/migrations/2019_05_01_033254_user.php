<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->char('id', 32)->primary();
            $table->string('name');
            $table->string('surname');
            $table->integer('preferred_working_hours_per_day')->nullable();
            $table->string('username')->unique();
            $table->string('password', 255);
            $table->tinyInteger('user_type');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('user');
        
    }
}
