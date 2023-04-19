<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('created_by')->nullable(); 
            $table->string('updated_by')->nullable(); 
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            Schema::drop('created_by');
            Schema::drop('updated_by');
        });
    }
};
