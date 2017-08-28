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
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->unique();
            $table->string('hash')->unique();
            $table->date('expires_at')->nullable();
            $table->boolean('expires')->default(0);
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
        Schema::dropIfExists('links');
    }
}
