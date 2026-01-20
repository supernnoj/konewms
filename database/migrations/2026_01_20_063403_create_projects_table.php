<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();                                    // id
            $table->string('name');                         // name
            $table->string('address')->nullable();          // address
            $table->foreignId('created_by')
                ->constrained('users')                    // references users.id
                ->cascadeOnDelete();
            $table->foreignId('deleted_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();                           // created_at, updated_at
            $table->softDeletes();                          // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
