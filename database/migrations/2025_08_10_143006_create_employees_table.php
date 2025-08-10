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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('office_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('shift_id')->nullable()->constrained()->onDelete('set null');
            $table->string('employee_code')->unique();
            $table->string('position')->nullable();
            $table->date('join_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
