<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    protected $model = Order::class;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('country');
            $table->string('postal_code');
            $table->string('payment_method');
            $table->string('payment_status');
            $table->string('payment_id');
            $table->string('payment_amount');
            $table->string('payment_currency');
            $table->string('payment_description');
            $table->string('payment_status_detail');
            $table->string('payment_created_at');
            $table->string('payment_updated_at');
            $table->string('payment_transaction_id');
            $table->string('payment_transaction_type');
            $table->string('payment_transaction_status');
            $table->string('payment_transaction_amount');
            $table->string('payment_transaction_currency');
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
        Schema::dropIfExists('orders');
    }
}
