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
        Schema::create('inv_uoms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_master')->default(false)->comment('هل هي الوحدة الرئيسية');
            $table->integer('added_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('com_code')->nullable();
            $table->boolean('active')->default(true);
            $table->comment('جدول الوحدات');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_uoms');
    }
};
