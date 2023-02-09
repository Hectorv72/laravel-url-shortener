<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shorteners', function (Blueprint $table) {
            $table->id();
            $table->string('shortened_url', 5)->unique();
            $table->mediumText('linked_url');
            $table->mediumInteger('interactions')->default(0);
            $table->timestamps();

            $table->foreignId('user_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shorteners');
    }
};
