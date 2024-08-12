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
        Schema::table('users', function (Blueprint $table) {

            $table->unsignedBigInteger('updated_by')->nullable()->after('updated_at');
            //當關聯的用戶被刪除時，updated_by 欄位將被設置為 null
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('role')->nullable()->change();
            $table->foreign('role')->references('id')->on('user_roles')
            // ->onDelete('cascade')
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['updated_by','role']);
        $table->dropColumn('updated_by');
        $table->integer('role')->change();
        });
    }
};
