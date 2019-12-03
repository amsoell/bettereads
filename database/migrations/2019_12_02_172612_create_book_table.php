<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTable extends Migration
{
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('isbn')->unique();
            $table->timestamps();
        });

        Schema::create('book_user', function (Blueprint $table) {
            $table->bigInteger('book_id');
            $table->bigInteger('user_id');
            $table->timestamps();

            $table->primary([
                'book_id',
                'user_id',
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('book_user');
        Schema::dropIfExists('books');
    }
}
