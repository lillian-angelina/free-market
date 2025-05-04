<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('postal_code');
            $table->string('prefecture');
            $table->string('building')->nullable();
            $table->foreignId('item_id')->nullable()->constrained('items')->onDelete('cascade'); // 配送先用
            $table->timestamps();

            $table->unique(['user_id', 'item_id']); // 同じユーザーが同じ商品に複数登録不可
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
