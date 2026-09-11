<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The orders table originally cascaded on address deletion, which meant
     * deleting a saved address would silently wipe out a customer's order
     * history. This changes it to restrict, so an address that is used on
     * an existing order simply can't be deleted (the controller shows a
     * friendly message instead).
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['address_id']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('address_id')
                ->references('id')->on('addresses')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['address_id']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('address_id')
                ->references('id')->on('addresses')
                ->onDelete('cascade');
        });
    }
};
