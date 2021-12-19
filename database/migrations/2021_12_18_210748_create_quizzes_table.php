<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_logs', function (Blueprint $table) {
            # A classic solution for a such task is to create two tables:
            # 1) quizzes (id UNSIGNED INTEGER [+primary autoincrement], name VARCHAR [+unique index])
            # 2) quiz_logs (quiz_id UNSIGNED INTEGER, $payload_key VARCHAR [+unique index], $hits UNSIGNED INTEGER [+index])
            #
            # For performance reasons we should deal with only 1 table here, CRC32 hash algo is used
            # to represent the class name and constructor's input data as hash values, so we'll be
            # able to use MySQL as a fast caching persistent mechanism (we can cache "value" here as well)
            $table->unsignedInteger('quiz_name_hash')->index()->comment('quiz_name_hash = CRC32(Quiz::class)');
            $table->unsignedInteger('payload_hash')->index()->comment('payload_hash = CRC32(serialize($data))');
            $table->unsignedInteger('hits')->default(0);
            $table->timestamps();

            $table->unique(['quiz_name_hash', 'payload_hash']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_logs');
    }
}
