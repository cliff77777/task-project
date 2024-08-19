<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // 檢查 'task_flow_template_id' 欄位是否存在
            if (Schema::hasColumn('tasks', 'task_flow_template_id')) {
                $table->dropForeign(['task_flow_template_id']);
                $table->dropColumn('task_flow_template_id');
            }
            
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('task_flow_template_id')->nullable();
            $table->foreign('task_flow_template_id')
            ->references('id')
            ->on('task_flow_templates')
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // 檢查 'task_flow_template_id' 欄位是否存在
            if (Schema::hasColumn('tasks', 'task_flow_template_id')) {
                // 刪除外鍵約束
                $table->dropForeign(['task_flow_template_id']);
                // 刪除 'task_flow_template_id' 欄位
                $table->dropColumn('task_flow_template_id');
            }
        });
    }
};
