<?php

use App\Models\Master\Category;
use App\Models\Master\Drug;
use App\Models\Master\Manufacture;
use App\Models\Master\Variant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('code',2);
            $table->timestamps();
        });
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('manufactures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->timestamps();
        });
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->constrained()->onDelete('restrict');
            $table->foreignIdFor(Variant::class)->constrained()->onDelete('restrict');
            $table->foreignIdFor(Manufacture::class)->constrained()->onDelete('restrict');
            $table->string('name');
            $table->char('code','6')->unique();
            $table->integer('last_price')->nullable();
            $table->integer('last_discount')->nullable();
            $table->integer('maximum_capacity');
            $table->integer('minimum_capacity');
            $table->integer('box_quantity');
            $table->integer('box_margin');
            $table->integer('pack_quantity');
            $table->integer('pack_margin');
            $table->integer('piece_quantity');
            $table->integer('piece_margin');
            $table->timestamps();
        });
        Schema::create('repacks',function(Blueprint $table){
            $table->id();
            $table->foreignIdFor(Drug::class)->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('unit',['box','pack','ml','pcs','gr']);
            $table->integer('quantity');
            $table->integer('margin');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('variants');
        Schema::dropIfExists('manufactures');
        Schema::dropIfExists('vendors');
        Schema::dropIfExists('drugs');
        Schema::dropIfExists('repacks');
    }
};