<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('schedule_interval')->default('daily'); // Options: daily, weekly, monthly
            $table->date('start_day')->nullable(); // When to start
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['schedule_interval', 'start_day']);
        });
    }
};
