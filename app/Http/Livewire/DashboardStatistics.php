<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardStatistics extends Component
{
    public $date_from;
    public $date_to;
    public $url;
    public $prev_url;
    public $user_id;
    public $country_code;
    public $days_between = 0;


    public function __construct()
    {
        if (request()->get('date_from') != null && request()->get('date_to') != null) {
            $this->date_from    = \Carbon::parse(request()->get('date_from'))->format('Y-m-d');
            $this->date_to      = \Carbon::parse(request()->get('date_to'))->format('Y-m-d');
            $this->days_between = abs(\Carbon::parse($this->date_from)->diffInDays($this->date_to)) > 31 ? 31 : abs(\Carbon::parse($this->date_from)->diffInDays($this->date_to));
        } else {
            $this->date_from    = \Carbon::parse(now())->subDays(7)->format('Y-m-d');
            $this->date_to      = \Carbon::parse(now())->format('Y-m-d');
            $this->days_between = 7;
        }

        $this->url          = request()->get('url');
        $this->prev_url     = request()->get('prev_url');
        $this->user_id      = request()->get('user_id');

    }
    public function render()
    {
        $data = [
            'new_invoices'    => $this->newInvoices(),
            'appointments'    => $this->appointments(),
        ];

        $from         = $this->date_from;
        $to           = $this->date_to;
        $days_between = $this->days_between;

        return view('livewire.dashboard-statistics', compact('data' , 'from' , 'to' , 'days_between'));
    }

    public function newInvoices(){
        $newInvoicesCount = [];
        $daysList         = [];
        $countsList       = [];
        $date_from        = Carbon::parse($this->date_from);
        $to               = Carbon::parse($this->date_to);
        $days = $date_from->diffInDays($to);
        for($i = 0 ; $i < $days && $i < $this->days_between  ; $i++){
            array_push($daysList,$to->format('m-d'));
            array_push($countsList,\App\Models\Invoice::whereDate('created_at',$to->format('Y-m-d'))->count());
            $to = $to->subDays(1);
        }
        return $newInvoicesCount = ['daysList' => $daysList,'countsList'=>$countsList];
    }

    public function appointments(){
        $appointments              =[];
        $week_appointments_queries =[];
        $date                = new \DateTime($this->date_to);
        $date->modify("+$this->days_between day");
        $days                =[];
        for($i=1;$i<=$this->days_between;$i++){
            $sub= $this->days_between-$i;
            array_push($days,\Carbon::parse(date('d.m.Y',strtotime("-$sub  days")))->format('Y-m-d'));
        }
        for($i=0;$i<count($days);$i++){
            array_push($week_appointments_queries, 
                DB::raw('(SELECT count(id) from appointments WHERE DATE(created_at) = "'.$days[$i].'") as total_appointments_'.str_replace('-', '_', $days[$i]))

             );
        }
        $total = collect(\DB::table('appointments')->select($week_appointments_queries)->first());
        
        for($i=0;$i<count($days);$i++){
            try{
                $appointments[\Carbon::parse($days[$i])->format('m-d')] =  $total['total_appointments_'.str_replace('-', '_', $days[$i]) ] ;
            }catch(\Exception $e){
                
            }
        }

        return array_reverse($appointments);
    }
}
