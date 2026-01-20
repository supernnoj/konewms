<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // new columns
            $table->foreignId('project_id')
                ->after('id')
                ->constrained('projects')
                ->cascadeOnDelete();

            $table->string('equipment_number')
                ->nullable()
                ->after('po_number');

            // drop old project_name column
            $table->dropColumn('project_name');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // restore project_name
            $table->string('project_name')->after('id');

            // drop new columns
            $table->dropConstrainedForeignId('project_id');
            $table->dropColumn('equipment_number');
        });
    }
};
