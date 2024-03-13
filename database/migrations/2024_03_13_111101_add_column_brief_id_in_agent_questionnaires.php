<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBriefIdInAgentQuestionnaires extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agent_questionnaires', function (Blueprint $table) {
            $table->foreignId('brief_id')->after('skill')->nullable()->constrained('aud_creative_briefs')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aud_agent_questionnaires', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
}
