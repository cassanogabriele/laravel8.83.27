<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecentlyViewedArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recently_viewed_products', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('product_name');
            $table->integer('product_price');
            $table->string('product_image');
            $table->float('shipping_cost');
            $table->integer('qty')->default(0);
            $table->string('product_description')->default(0);
            $table->string('product_category');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recently_viewed_articles');
    }
}
