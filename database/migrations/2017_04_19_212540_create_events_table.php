<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 300);
            $table->string('identifier', 15);
            $table->string('venue', 50);
            $table->string('street', 150);
            $table->string('city', 50);
            $table->string('state', 50);
            $table->string('country', 50);
            $table->boolean('show_map')->default(0);
            $table->date('event_start_date');
            $table->date('event_end_date');
            $table->time('event_start_time');
            $table->time('event_end_time');
            $table->integer('age_restriction',2)->default(0);
            $table->integer('privacy', 1);
            $table->boolean('approve_individual_purchase')->default(0);
            $table->text('description');
            $table->integer('total_tickets')->default(0);
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
        Schema::dropIfExists('events');
    }
}
