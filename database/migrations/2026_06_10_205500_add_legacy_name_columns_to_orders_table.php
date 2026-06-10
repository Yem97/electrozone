<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Background: the original 2025_05_20_055052_create_orders_table migration
     * was edited after it had already run on production to add
     * first_name/last_name/email/phone as "legacy split-name columns" -- but
     * Laravel never re-runs a migration that's already recorded in the
     * `migrations` table, so the live `orders` table never actually got these
     * columns. CheckoutController::store() writes to all four on every
     * checkout, which fails with:
     *   SQLSTATE[42S22]: Column not found: 1054 Unknown column 'first_name'
     *
     * This migration adds the missing columns for real. Each addition is
     * guarded with hasColumn() so it's a safe no-op on any environment
     * (e.g. fresh local installs) where they already exist.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'first_name')) {
                $table->string('first_name')->nullable()->default('')->after('customer_phone');
            }
            if (!Schema::hasColumn('orders', 'last_name')) {
                $table->string('last_name')->nullable()->default('')->after('first_name');
            }
            if (!Schema::hasColumn('orders', 'email')) {
                $table->string('email')->nullable()->default('')->after('last_name');
            }
            if (!Schema::hasColumn('orders', 'phone')) {
                $table->string('phone')->nullable()->default('')->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            foreach (['first_name', 'last_name', 'email', 'phone'] as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
