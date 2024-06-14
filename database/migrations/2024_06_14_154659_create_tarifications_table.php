<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifications', function (Blueprint $table) {
            $table->id();
            $table->double('prix'); // Use snake_case for column names

            // Assuming the actual table names are duree_locations and articles
            $table->foreignId('duree_location_id')
                ->constrained(); // Descriptive constraint name

            $table->foreignId('article_id');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tarifications', function(Blueprint $table) {
            $table->dropForeign(['duree_location_id', 'article_id']);
        });

        Schema::dropIfExists('tarifications');
    }
}
