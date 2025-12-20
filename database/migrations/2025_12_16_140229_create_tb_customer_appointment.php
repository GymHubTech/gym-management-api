<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_customer_appointment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->foreignId('customer_id')->constrained('tb_customers')->onDelete('cascade');
            $table->foreignId('appointment_type_id')->constrained('tb_appointment_type')->onDelete('cascade');
            $table->foreignId('trainer_id')->unsignedBigInteger()->nullable();
            $table->dateTime('appointment_start');
            $table->dateTime('appointment_end');
            $table->string('notes')->nullable();
            $table->smallInteger('duration');
            $table->string('appointment_status');
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('account_id');
            $table->index('customer_id');
            $table->index('appointment_type_id');
            $table->index('appointment_start');
            $table->index('appointment_status');
            $table->index('deleted_at');

            // Composite indexes for common query patterns
            $table->index(['account_id', 'customer_id']);
            $table->index(['account_id', 'appointment_start']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_customer_appointment');
    }
};
