<?php
    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateConversationsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('conversations', function (Blueprint $table) {
                $table->id();
                $table->text('message')->nullable();
              /*   $table->unsignedInteger('user_id');
                $table->unsignedInteger('admin_id');
                $table->unsignedInteger('group_id'); */

                $table->foreignId('user_id')->constrained('users');
                $table->foreignId('admin_id')->constrained('admins');
                $table->foreignId('group_id')->constrained('groups');
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
            Schema::dropIfExists('conversations');
        }
    }

