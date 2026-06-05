<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPromotionToEquipmentsTable extends Migration
{
    public function up()
    {
        Schema::table('equipments', function (Blueprint $table) {
            $table->boolean('promotion')->default(false)->after('unit_price');
        });
    }

    public function down()
    {
        Schema::table('equipments', function (Blueprint $table) {
            $table->dropColumn('promotion');
        });
    }
}