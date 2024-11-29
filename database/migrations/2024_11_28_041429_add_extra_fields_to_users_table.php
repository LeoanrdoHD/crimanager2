<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('ci_police')->after('name');
        $table->string('phone')->after('ci_police')->nullable();
        $table->string('grade')->after('phone')->nullable();
        $table->string('escalafon')->after('grade')->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['ci_police', 'phone', 'grade', 'escalafon']);
    });
}

};
