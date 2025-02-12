<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pdf_links', function (Blueprint $table) {
            $table->id();
            $table->string('url'); // PDF URL
            $table->boolean('processed')->default(false); // Track if processed
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pdf_links');
    }
};
