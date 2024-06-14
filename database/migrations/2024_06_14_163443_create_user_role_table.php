<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role', function (Blueprint $table) {
            $table->foreignId("user_id");
            $table->foreignId("role_id");
        });

        Schema::enableForeignKeyConstraints(); // Corrected method name
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_role', function(Blueprint $table){
            $table->dropForeign(["user_id", "role_id"]);
        });
        Schema::dropIfExists('user_role');
    }
}