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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('account_type_id')->constrained('account_types')->cascadeOnDelete();
            $table->boolean('is_parent')->default(false);
            $table->bigInteger('parent_account_number')->nullable();
            $table->bigInteger('account_number');
            $table->boolean('start_balance_status')->default(false)
                ->comment('
                    1 => credited => دائن
                    2 => debited => مدين
                    3 => balanced => متزن
                ');
            $table->decimal('start_balance', 10, 2)->nullable();
            $table->decimal('current_balance', 10, 2)->nullable();
            $table->integer('other_table_FK')->nullable()
                ->comment('الجداول المرتبطة بهذا الجدول');
            $table->string('notes')->nullable();
            $table->date('date')->nullable();
            $table->string('added_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->integer('com_code')->nullable();
            $table->boolean('active')->default(true);
            $table->comment('جدول الشجرة المحاسبية العامة');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
