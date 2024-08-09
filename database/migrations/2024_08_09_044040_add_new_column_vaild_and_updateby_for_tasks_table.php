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
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->integer('valid')->default(1)->comment('任務單有效性');//0:失效1:有效:2:處理中3:問題4:失敗5:完成
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('updated_by');
            $table->dropColumn('valid');
        });
    }
};
