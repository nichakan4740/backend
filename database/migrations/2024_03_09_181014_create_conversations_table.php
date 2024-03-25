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
                $table->foreignId('user_id')->constrained('users');
                $table->foreignId('admin_id')->constrained('admins');

                $table->unsignedBigInteger('parent_id')->nullable();
                $table->boolean('is_reply')->default(0);
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
        Schema::table('conversations', function (Blueprint $table) {
            $table->dropColumn('parent_id');
            $table->dropColumn('is_reply');
        });
    }
    
    }

