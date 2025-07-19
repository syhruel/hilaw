<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('keahlian')->nullable();
            $table->text('pengalaman')->nullable();
            $table->string('lulusan_universitas')->nullable();
            $table->text('alamat')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['keahlian', 'pengalaman', 'lulusan_universitas', 'alamat']);
        });
    }
};
