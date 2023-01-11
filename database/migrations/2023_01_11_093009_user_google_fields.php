<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserGoogleFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('nickname')->nullable();
            $table->string('avatar')->nullable();
            $table->bigInteger('expires_in')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('token');
            $table->dropColumn('refresh_token');
            $table->dropColumn('nickname');
            $table->dropColumn('avatar');
            $table->dropColumn('expires_in');
        });
    }
}
