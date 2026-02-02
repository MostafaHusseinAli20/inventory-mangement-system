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
        Schema::table('inv_item_cards', function (Blueprint $table) {
            $table->decimal('quantity', 10, 3)->default(0)
                ->after('has_fixed_price')->comment('الكمية المتوفرة بوحدة الأب');
            $table->decimal('quantity_retail', 10, 3)->default(0)
                ->after('quantity')->comment('كمية التجزئة المتبقية من الوحدة الاب في حالة وجود وحدة تجزئة للصنف');
            $table->decimal('quantity_all_retails', 10, 3)->default(0)
                ->after('quantity_retail')->comment('كل الكمية المحولة بوحدة التجزئة');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_item_cards', function (Blueprint $table) {
            $table->dropColumn('quantity');
            $table->dropColumn('quantity_retail');
            $table->dropColumn('quantity_all_retails');
        });
    }
};
