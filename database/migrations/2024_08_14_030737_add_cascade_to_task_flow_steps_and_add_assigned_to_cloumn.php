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
        Schema::table('task_flow_steps', function (Blueprint $table) {
            $table->dropForeign(['task_flow_template_id']);
            // 重新創建外鍵，並設置 ON DELETE CASCADE
            $table->foreign('task_flow_template_id')
                  ->references('id')
                  ->on('task_flow_templates')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->foreign('assigned_to')->references('id')
            ->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_flow_steps', function (Blueprint $table) {
            // 取消之前設置的外鍵約束
            $table->dropForeign(['task_flow_template_id','assigned_to']);
            // 如果需要，可以恢復到不帶 cascade 的外鍵約束
            $table->foreign('task_flow_template_id')
                  ->references('id')
                  ->on('task_flow_templates');
        });
    }
};
