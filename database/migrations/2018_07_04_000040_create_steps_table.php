<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 255);
            $table->string('description', 500)->nullable();
            $table->string('context', 255)->nullable();
            $table->string('lang', 20)->default('fr');
            $table->integer('step_number');
            $table->enum('priority',['P1','P2','P3','P4'])->default('P3');
            $table->enum('state',['ko','inProgress','ok'])->default('ko');

            $table->integer('scenario_id',false,true);
            //$table->integer('priority_id',false,true);
            $table->integer('page_id',false,true);

            $table->foreign('scenario_id')->references('id')->on('scenarios')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages');
            //$table->foreign('priority_id')->references('id')->on('priorities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('steps');
    }
}
