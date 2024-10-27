<?php

use App\Models\Master\Drug;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouse_inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Drug::class);
            $table->integer('quantity');
            $table->date('oldest');
            $table->date('latest');
            $table->timestamps();
        });
        Schema::create('clinic_inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Drug::class);
            $table->integer('quantity');
            $table->date('oldest');
            $table->date('latest');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('warehouse_inventory');
        Schema::dropIfExists('clinic_inventory');
    }
};