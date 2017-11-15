<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShortenerCreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create(config('shortener.links_table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('hash')->unique();
            $table->string('url');
            $table->string('relation_type')->nullable();
            $table->integer('relation_id')->nullable()->unsigned();
            $table->tinyInteger('expires')->default(0);
            $table->datetime('expires_at')->nullable();
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
        //
        Schema::dropIfExists(config('shortener.links_table'));
    }
}
