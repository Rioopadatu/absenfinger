<?php

namespace App\Jobs;

use App\Models\FpAttendance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveAttendance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $dataAttendance;
    protected $mesin;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($dataAttendance,$mesin)
    {
        $this->dataAttendance=$dataAttendance;
        $this->mesin=$mesin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        collect($this->dataAttendance)->each(function (array $row) {
            $fp = FpAttendance::firstOrCreate(
                ['uid' => $row['uid'],'mesin'=>$this->mesin,'timestamp' => $row['timestamp']],
                ['id' => $row['id'],'timestamp' => $row['timestamp'],'type' => $row['type'],'state' => $row['state']]
            );
        });
    }
}
