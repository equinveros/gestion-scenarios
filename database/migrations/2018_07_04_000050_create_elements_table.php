<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElementsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('elements', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 255)->nullable();
            $table->string('context', 255)->nullable();
            $table->string('description', 500)->nullable();
            $table->boolean('delete')->default(false);
            $table->integer('strokeWidth')->default(12);
            $table->double('pos_x');
            $table->double('pos_y');
            $table->enum('priority', ['P1',
                                      'P2',
                                      'P3',
                                      'P4'])->default('P3');
            $table->enum('state', ['ko',
                                   'inProgress',
                                   'ok'])->default('ko');

//            $table->string('class', 50);
            $table->integer('step_id', false, true);
            $table->integer('elementable_id', false, true);
            $table->string('elementable_type', 20);

            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('elements');
    }
}
