<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('group_id');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('admin_id')->constrained('admins');

            /* $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('admin_id');  */
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
        Schema::dropIfExists('group_user');
    }
}

