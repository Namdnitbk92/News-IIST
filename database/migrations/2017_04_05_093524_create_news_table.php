<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('status_id')->nullable();
            $table->string('audio_path')->nullable();
            $table->text('audio_text')->nullable();
            $table->text('attach_path_file')->nullable();
            $table->text('file_type')->nullable();
            $table->string('place_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('reason')->nullable();
            $table->dateTime('publish_time')->nullable();
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
        Schema::dropIfExists('news');
    }
}
