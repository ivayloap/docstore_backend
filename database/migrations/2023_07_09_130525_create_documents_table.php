<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file_path');
            $table->timestamps();

            $table->unsignedBigInteger('user_id'); // Add the foreign key column

            $table->foreign('user_id')->references('id')->on('users'); // Add the foreign key constraint
        });
    }



    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
