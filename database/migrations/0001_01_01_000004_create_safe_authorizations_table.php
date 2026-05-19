<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('authorizations', function (Blueprint $table) {
            $table->id();
            $table->string('professor_name');
            $table->string('student_name');
            $table->string('classroom');
            $table->string('action');
            $table->time('scheduled_time');
            $table->boolean('absence')->default(false);
            $table->unsignedTinyInteger('lesson');
            $table->string('authorized_by');
            $table->date('date');
            $table->string('status')->default('pendente');
            $table->timestamp('professor_validated_at')->nullable();
            $table->timestamp('portaria_confirmed_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authorizations');
    }
};
