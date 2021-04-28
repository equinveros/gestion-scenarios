<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScenariosTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('scenarios', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id');
            $table->timestamps();

            $table->string('name', 255);
            $table->string('description', 500);
            $table->string('context', 255);
            $table->boolean('delete')->default(false);
            $table->boolean('close')->default(false);
            $table->enum('state',['ko','inProgress','ok'])->default('ko');
            $table->enum('priority',['P1','P2','P3','P4'])->default('P3');

            $table->integer('site_id', false, true)->default(1);
            $table->integer('user_create_id', false, true);
            $table->integer('user_update_id', false, true)->nullable(true);

            $table->foreign('site_id')->references('id')->on('sites');
            $table->foreign('user_create_id')->references('id')->on('users');
            $table->foreign('user_update_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('scenarios');
    }
}
