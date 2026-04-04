<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::connection()->getDriverName() !== 'pgsql') {
            return;
        }

        Schema::ensureVectorExtensionExists();

        Schema::create('knowledge_chunks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->vector('embedding', dimensions: 1536)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() !== 'pgsql') {
            return;
        }

        Schema::dropIfExists('knowledge_chunks');
    }
};
