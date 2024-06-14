<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleProprieteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_propriete', function (Blueprint $table) {
            $table->foreignId("article_id");
            $table->foreignId("propriete_article_id");
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
        Schema::table('article_propriete', function(Blueprint $table){
            $table->dropForeign(["article_id", "propriete_article_id"]);
        });
        Schema::dropIfExists('article_propriete');
    }
}
