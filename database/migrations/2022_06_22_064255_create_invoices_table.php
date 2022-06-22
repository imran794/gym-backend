<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('member_id',20);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('amount');
            $table->unsignedBigInteger('created_by');
            $table->tinyInteger('fee_type');
            $table->tinyInteger('payment_type');
            $table->timestamps();

            // $table->foreign('member_id')->references('')->on(''); 
            $table->foreign('member_id')->references('member_id')->on('members')->onDelete('cascade');

            $table->foreign('created_by')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
