<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_permission', function (Blueprint $table) {
            $table->foreignId("user_id");
            $table->foreignId("permission_id")->constrained('permissions'); // Update the referenced table name
            $table->timestamps();
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
        Schema::table('user_permission', function(Blueprint $table){
            $table->dropForeign(["user_id", "permession_id"]);
        });
        Schema::dropIfExists('user_permission');
    }
}
