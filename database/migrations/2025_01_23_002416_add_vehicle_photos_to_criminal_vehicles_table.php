<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('criminal_vehicles', function (Blueprint $table) {
        $table->string('front_photo')->nullable()->after('driver_name'); // Foto de frente
        $table->string('left_side_photo')->nullable()->after('front_photo'); // Foto lateral izquierda
        $table->string('right_side_photo')->nullable()->after('left_side_photo'); // Foto lateral derecha
        $table->string('rear_photo')->nullable()->after('right_side_photo'); // Foto trasera
    });
}

public function down()
{
    Schema::table('criminal_vehicles', function (Blueprint $table) {
        $table->dropColumn(['front_photo', 'left_side_photo', 'right_side_photo', 'rear_photo']);
    });
}

};
