<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelPengumuman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->increments('id');

            $table->uuid('uuid');
            $table->string('judul');
            $table->string('slug')->unique();

            $table->string('waktu')->nullable();
            $table->text('perihal')->nullable();
            
            $table->integer('id_operator')->nullable();

            $table->string('lampiran')->nullable();
            $table->integer('komentar')->default(0);
            $table->integer('view')->default(0);

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
        Schema::dropIfExists('pengumuman');
    }
}
