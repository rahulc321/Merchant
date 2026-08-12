<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPublicRegistrationFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'school')) {
                $table->string('school')->nullable()->after('password');
            }

            if (!Schema::hasColumn('users', 'age')) {
                $table->unsignedInteger('age')->nullable()->after('school');
            }

            if (!Schema::hasColumn('users', 'department')) {
                $table->string('department')->nullable()->after('age');
            }

            if (!Schema::hasColumn('users', 'subject')) {
                $table->string('subject')->nullable()->after('department');
            }

            if (!Schema::hasColumn('users', 'organization')) {
                $table->string('organization')->nullable()->after('subject');
            }

            if (!Schema::hasColumn('users', 'parent_email')) {
                $table->string('parent_email')->nullable()->after('organization');
            }

            if (!Schema::hasColumn('users', 'image')) {
                $table->string('image')->nullable()->after('parent_email');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'school',
                'age',
                'department',
                'subject',
                'organization',
                'parent_email',
                'image',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
