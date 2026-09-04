<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('plans', function (Blueprint $table) {
            if (!Schema::hasColumn('plans', 'usage_limit')) {
                $table->unsignedInteger('usage_limit')->default(1)->after('days');
            }
        });

        Schema::table('plan_purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('plan_purchases', 'usage_limit')) {
                $table->unsignedInteger('usage_limit')->default(1)->after('days');
            }

            if (!Schema::hasColumn('plan_purchases', 'used_count')) {
                $table->unsignedInteger('used_count')->default(0)->after('usage_limit');
            }
        });
    }

    public function down()
    {
        Schema::table('plan_purchases', function (Blueprint $table) {
            if (Schema::hasColumn('plan_purchases', 'used_count')) {
                $table->dropColumn('used_count');
            }

            if (Schema::hasColumn('plan_purchases', 'usage_limit')) {
                $table->dropColumn('usage_limit');
            }
        });

        Schema::table('plans', function (Blueprint $table) {
            if (Schema::hasColumn('plans', 'usage_limit')) {
                $table->dropColumn('usage_limit');
            }
        });
    }
};
