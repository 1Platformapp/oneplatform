<?php

namespace App\Console\Commands;

use App\Models\AgentQuestionnaire;
use App\Models\CreativeBrief;
use Illuminate\Console\Command;

class ReplaceBriefColumn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'replace:skill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $creatives = CreativeBrief::all();
        foreach($creatives as $creative) {
            $this->line('Updating brief ids for the'. $creative->title);
            $questionaires = AgentQuestionnaire::where('brief_title', $creative->title)->get();
            foreach($questionaires as $questionaire) {
                $questionaire->fill(['brief_id' => $creative->id]);
                $questionaire->save();
            }
        }
        logger('Shifting skills into skill id in agent questionaires Command');
    }
}
