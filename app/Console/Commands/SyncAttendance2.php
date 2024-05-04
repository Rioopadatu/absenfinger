<?php

namespace App\Console\Commands;

use App\Jobs\SaveAttendance;
use App\Models\FpAttendance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Rats\Zkteco\Lib\ZKTeco;

class SyncAttendance2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:attendance2';

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
        //Mesin2
        $zk2 = new ZKTeco(env("IP_FINGERPRINT_SECONDARY"));

        if($zk2->connect()){
            DB::transaction(function () use($zk2){
                foreach (array_chunk($zk2->getAttendance(),100) as $t)
                {
                    /*collect($t)->each(function (array $row) {
                        $fp = FpAttendance::firstOrCreate(
                            ['uid' => $row['uid'],'mesin'=>'mesin2'],
                            ['id' => $row['id'],'timestamp' => $row['timestamp'],'type' => $row['type'],'state' => $row['state']]
                        );
                    });*/
                    dispatch(new SaveAttendance($t,'mesin2'));
                }
                //$zk2->clearAttendance();
            });
        }

        return 0;
    }
}
