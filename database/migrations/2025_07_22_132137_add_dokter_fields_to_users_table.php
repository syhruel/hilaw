<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('pengalaman_tahun')->nullable();
            $table->text('pengalaman_deskripsi')->nullable();
            $table->string('sertifikat')->nullable();
            
            if (Schema::hasColumn('users', 'pengalaman')) {
                $table->dropColumn('pengalaman');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['pengalaman_tahun', 'pengalaman_deskripsi', 'sertifikat']);
            $table->text('pengalaman')->nullable();
        });
    }
};