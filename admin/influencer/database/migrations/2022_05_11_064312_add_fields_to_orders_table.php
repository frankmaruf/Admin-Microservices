<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('link');
            $table->unsignedBigInteger('user_id');
            $table->string('influencer_email');
            $table->tinyInteger('completed')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('link');
            $table->dropColumn('user_id');
            $table->dropColumn('influencer_email');
            $table->dropColumn('completed');
        });
    }
}
