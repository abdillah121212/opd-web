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
        Schema::create('levels', function (Blueprint $table) {
            $table->id()->primary();
            $table->enum('name', [
                'super_admin',
                'admin',
            ])->unique();
            $table->timestamps();
        });      
          DB::table('levels')->insert([
            ['name' => 'super_admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
    /**
     *     * Reverse the migrations.
     */
        public function down()
    {
        Schema::dropIfExists('levels');
    }
};
