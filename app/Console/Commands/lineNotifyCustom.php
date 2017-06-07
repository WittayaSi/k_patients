<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use KS\Line\LineNotify;

class lineNotifyCustom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'line:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command to send line notify to user';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $this->lineNotification();
        
    }

    private function lineNotification()
    {
        $date_tomorow = date('Y-m-d', strtotime('tomorrow'));

        $appoint_tomorrow = DB::select('
            select a.*, d.*,c.id_doctor, c.name_doctor
            from appointments as a
            left join (
                select p.*, cp.detail
                from patients as p
                left join cprenames as cp on (cp.id_prename = p.prename)
            ) as d on (d.id_no = a.id_no)
            left join doctors c on (c.id_doctor = a.doctor_id)
            where a.app_date = "' . $date_tomorow . '"
            order by c.id_doctor ASC'
        );

        $content = "";
        foreach($appoint_tomorrow as $a){
            $content = $content . ($a->detail).($a->name).' '.($a->lname).', ';
        }

        $app_no = count($appoint_tomorrow);

        // line notify 
        if($app_no > 0) {

            $token = 'GNYga83I4mg9roJYc8C2NXGlGb42dCDUDFUUVLwRZWF';
            $ln = new LineNotify($token);

            $message = $message = 'พรุ่งนี้ '. $date_tomorow .' มีนัดหมาย จำนวน ' . $app_no . ' คน คือ ' .
                       $content;
            $ln->send($message);

        }
        //end line notify
    }
}
