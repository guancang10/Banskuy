<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTrnotification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trnotification', function (Blueprint $table) {
            $table->increments('TrNotificationID');
            $table->integer('HtrNotificationID')->unsigned();
            $table->integer('ReceiverID')->unsigned();
            $table->integer('StatusNotification')->unsigned();
            //1 for unread
            //2 for read
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
        Schema::dropIfExists('table_trnotification');
    }
}
