<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('plan_purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('plan_purchases', 'payment_gateway')) {
                $table->string('payment_gateway')->nullable()->after('status');
            }

            if (!Schema::hasColumn('plan_purchases', 'payment_reference')) {
                $table->string('payment_reference')->nullable()->after('payment_gateway');
            }

            if (!Schema::hasColumn('plan_purchases', 'payment_tracking_id')) {
                $table->string('payment_tracking_id')->nullable()->after('payment_reference');
            }

            if (!Schema::hasColumn('plan_purchases', 'payment_redirect_url')) {
                $table->text('payment_redirect_url')->nullable()->after('payment_tracking_id');
            }

            if (!Schema::hasColumn('plan_purchases', 'gateway_response')) {
                $table->text('gateway_response')->nullable()->after('payment_redirect_url');
            }

            if (!Schema::hasColumn('plan_purchases', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('gateway_response');
            }
        });
    }

    public function down()
    {
        Schema::table('plan_purchases', function (Blueprint $table) {
            foreach (['paid_at', 'gateway_response', 'payment_redirect_url', 'payment_tracking_id', 'payment_reference', 'payment_gateway'] as $column) {
                if (Schema::hasColumn('plan_purchases', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
