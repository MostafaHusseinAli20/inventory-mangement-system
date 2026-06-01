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
            // اسعار وحدة القياس الاساسية
            $table->decimal('price_uom', 10, 2)->after('retail_uom_quntToParent')
                ->comment('السعر القطاعي لوحدة القياس الاساسية');
            $table->decimal('half_gomla_price_uom', 10, 2)->after('price_uom')
                ->comment('سعر النص جملة لوحدة القياس الاساسية');
            $table->decimal('gomla_price_uom', 10, 2)->after('half_gomla_price_uom')
                ->comment('سعر الجملة لوحدة القياس الاساسية');
            
            // اسعار التجزئة
            $table->decimal('price_retail', 10, 2)->after('gomla_price_uom')
                ->nullable()->comment('السعر القطاعي لوحدة التجزئة');
            $table->decimal('half_gomla_price_retail', 10, 2)->after('price_retail')
                ->nullable()->comment('سعر النص جملة لوحدة التجزئة');
            $table->decimal('gomla_price_retail', 10, 2)->after('half_gomla_price_retail')
                ->nullable()->comment('سعر الجملة لوحدة التجزئة');

            $table->decimal('cost_price', 10, 2)->after('gomla_price_retail')
                ->comment('سعر التكلفة للصنف للوحدة الاساسية');
            $table->decimal('cost_price_retail', 10, 2)->after('cost_price')
                ->nullable()->comment('سعر التكلفة للصنف لوحدة التجزئة');
            $table->boolean('has_fixed_price')->default(false)->after('cost_price_retail')
                ->comment('هل يوجد سعر ثابت للصنف');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_item_cards', function (Blueprint $table) {
            $table->dropColumn('price_uom');
            $table->dropColumn('half_gomla_price_uom');
            $table->dropColumn('gomla_price_uom');
            $table->dropColumn('price_retail');
            $table->dropColumn('half_gomla_price_retail');
            $table->dropColumn('gomla_price_retail');
        });
    }
};
