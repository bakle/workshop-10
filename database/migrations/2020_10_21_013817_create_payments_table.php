<?php

use App\Constants\PaymentGateway;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\PaymentStatus;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->enum('gateway', [PaymentGateway::PLACETOPAY, PaymentGateway::PAYMATE]);
            $table->string('reference', 40);
            $table->unsignedInteger('request_id')->nullable()->index();
            $table->tinyInteger('status')->default(PaymentStatus::PENDING);
            $table->string('process_url')->nullable();
            $table->string('receipt', 20)->nullable();
            $table->string('authorization', 40)->nullable();
            $table->string('currency', 3)->nullable();
            $table->double('total_paid')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
