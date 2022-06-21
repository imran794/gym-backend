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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_id',20)->uniqid();
            $table->string('name',50);
            $table->tinyInteger('gender');
            $table->string('mobile',11);
            $table->enum('blood_group',["A+","A-","AB+","AB-","B+","B-","O+","O-"]);
            $table->text('address');
            $table->string('photo',100);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('lock')->default(0);
            $table->string('card_no',15)->default('0000000000');
            $table->unsignedBigInteger('created_by');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

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
        Schema::dropIfExists('members');
    }
};
