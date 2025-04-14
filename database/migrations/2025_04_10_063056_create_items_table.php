<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // 出品者
            $table->string('name');
            $table->text('description');
            $table->integer('price');
            $table->boolean('sold_flg')->default(false); // ←ここに移動
            $table->unsignedBigInteger('category_id')->nullable(); // カテゴリID
            $table->unsignedBigInteger('brand_id')->nullable();    // ブランドID
            $table->string('condition')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();

            // 外部キー制約
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
