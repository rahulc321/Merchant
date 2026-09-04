<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'institution_name')) {
                $table->string('institution_name')->nullable()->after('school');
            }

            if (!Schema::hasColumn('users', 'institution_logo')) {
                $table->string('institution_logo')->nullable()->after('institution_name');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'institution_logo')) {
                $table->dropColumn('institution_logo');
            }

            if (Schema::hasColumn('users', 'institution_name')) {
                $table->dropColumn('institution_name');
            }
        });
    }
};
