<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_appointment_type', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('account_id');
        });

         // Insert default data
         $defaultCategories = [
            'Personal Training',
            'Consultation',
            'Yoga Session',
            'Group Session',
            'Body Composition',
        ];

        foreach ($defaultCategories as $category) {
            DB::table('tb_appointment_type')->insert([
                'account_id' => 1,
                'name' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_appointment_type');
    }
};
