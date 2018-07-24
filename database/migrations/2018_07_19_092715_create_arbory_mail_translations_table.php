<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArboryMailTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arbory_mail_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mail_id')->unsigned()->index();
            $table->string('subject')->nullable();
            $table->text('text')->nullable();
            $table->string('locale')->index();
            $table->timestamps();

            $table->foreign('mail_id')->references('id')->on('arbory_mail')->onDelete('cascade');
            $table->unique(['mail_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arbory_mail_translations');
    }
}
