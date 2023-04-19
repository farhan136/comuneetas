<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('status'); 
            // jika dibuat oleh non admin = requested
            // jika dibuat oleh non admin dan ditolak oleh admin = rejected
            // jika dibuat oleh admin dan tanggalnya future date = waiting to do
            // jika dibuat oleh admin dan tanggalnya current date = doing
            // jika dibuat oleh non admin dan diapprove admin = sama seperti status yang dibuat oleh admin
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            Schema::drop('status');
        });
    }
};
