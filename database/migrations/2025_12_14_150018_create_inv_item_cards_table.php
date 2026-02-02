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
        Schema::create('inv_item_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('barcode')->unique();
            $table->string('item_code')->unique();
            $table->integer('item_type')->comment('
                1 => مخزني
                2 => استهلاكي له تاريخ صلاحية
                3 => عهدة
            ');
            $table->foreignId('inv_item_card_category_id')->constrained('inv_item_card_categories')->cascadeOnDelete();
            $table->foreignId('parent_inv_item_card_id')->nullable()->constrained('inv_item_cards')
                ->cascadeOnDelete()
                ->comment('كود الصنف الاب لهذا الجدول');
            
            $table->foreignId('inv_uom_id')->constrained('inv_uoms')->cascadeOnDelete()
                ->comment('كود وحدة قياس الاب');
            $table->foreignId('inv_retail_uom_id')->nullable()->constrained('inv_uoms')->cascadeOnDelete()
                ->comment('كود وحدة قياس التجزئة');

            $table->boolean('does_has_retailunit')->default(false)->comment('هل يوجد وحدة تجزئة');
            $table->decimal('retail_uom_quntToParent', 10, 2)
                ->nullable()->comment('عدد الوحدات التجزئة بالنسبة للاب');

            $table->integer('added_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('com_code')->nullable();
            $table->boolean('active')->default(true);
            $table->date('date')->nullable()->comment('for search');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_item_cards');
    }
};
