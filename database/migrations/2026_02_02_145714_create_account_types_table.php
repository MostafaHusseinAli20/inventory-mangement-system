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
        Schema::create('account_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date')->nullable();
            $table->date('last_update')->nullable();
            $table->string('added_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->boolean('active')->default(true);
            $table->integer('com_code')->nullable();
            $table->integer('relatediternalaccounts')
                ->comment('الحسابات الابنية ذات الصلة');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_types');
    }
};
