<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultilanguageSettingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multilanguage_setting_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('multilanguage_setting_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('script');
            $table->string('native');
            $table->string('regional');
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
        Schema::dropIfExists('multilanguage_setting_details');
    }
}
