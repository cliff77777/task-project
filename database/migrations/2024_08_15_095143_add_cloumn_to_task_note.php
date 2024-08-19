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
        Schema::table('task_notes', function (Blueprint $table) {

        $table->unsignedBigInteger('assign_to')->nullable();
        $table->foreign('assign_to')->references('id')->on('users');

        $table->unsignedBigInteger('task_flow_step_id')->nullable();
        $table->foreign('task_flow_step_id')->references('id')->on('task_flow_steps');

        $table->unsignedBigInteger('created_by')->nullable();
        $table->foreign('created_by')->references('id')->on('users');

        $table->unsignedBigInteger('updated_by')->nullable();
        $table->foreign('updated_by')->references('id')->on('users');

        $table->integer('step')->nullable();

        $table->integer('status')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_notes', function (Blueprint $table) {
        //移除外键
        $table->dropForeign(['assign_to']);
        $table->dropForeign(['task_flow_step_id']);
        $table->dropForeign(['created_by']);
        $table->dropForeign(['updated_by']);

        // 移除列
        $table->dropColumn('assign_to');
        $table->dropColumn('task_flow_step_id');
        $table->dropColumn('created_by');
        $table->dropColumn('updated_by');
        $table->dropColumn('step');
        $table->dropColumn('status');
        });
    }
};
