<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('url')->unique();

            $table->string('front_image')->nullable();
            $table->string('front_image_alt')->nullable();

            $table->string('detail_image')->nullable();
            $table->string('detail_image_alt')->nullable();

            $table->string('cta_image')->nullable();
            $table->string('cta_image_alt')->nullable();
            $table->string('cta_link_url')->nullable();

            $table->date('date')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->longText('short_description')->nullable();
            $table->longText('detail_description')->nullable();
            $table->longText('conclusion')->nullable();

            $table->longText('schema_json')->nullable();

            // All FAQs for this blog are stored together here as a JSON array,
            // e.g. [{"faq_title":"...","faq_description":"..."}, ...]
            $table->json('faqs')->nullable();

            $table->enum('status', ['Active', 'In-Active'])->default('Active');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
