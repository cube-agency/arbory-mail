<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateArboryMailTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('arbory_mail_translations', function (Blueprint $table) {
            $table->renameColumn('text', 'html');

        });

        Schema::table('arbory_mail_translations', function (Blueprint $table) {
            $table->text('plain')->after('html')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arbory_mail_translations', function (Blueprint $table) {
            $table->renameColumn('html', 'text');
            $table->dropColumn(['plain']);
        });
    }
}
