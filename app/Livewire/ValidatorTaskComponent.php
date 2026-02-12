<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ValidatorTaskComponent extends Component
{
    public $startDate, $endDate , $rangeAuditor;
    public $report = [
        'dates' => [],
        'data'  => []
    ];

    public function updatedRangeAuditor()
    {
        $this->generateReport();
    }

    public function mount(){
        $this->startDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $this->endDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $this->rangeAuditor = $this->startDate.' to '.$this->endDate;
        $this->generateReport();
    }


    #[On('echo:analis-data,UpdateAnalis')]
    #[On('echo:auditor-data,UpdateAuditor')]
    public function generateReport()
    {
        $rows = DB::table('auditorlog')
            ->join('users', 'users.id', '=', 'auditorlog.auditorId')
            ->select(
                'users.name as validatorName',
                'users.id as auditorId',
                DB::raw("DATE(auditorlog.created_at) as d"),
                DB::raw("COUNT(DISTINCT auditorlog.alertId) as total"),
                DB::raw("SUM(auditorlog.ngapain = 'Insert') as total_Insert"),
                DB::raw("SUM(auditorlog.ngapain = 'Reject') as total_Reject"),
                DB::raw("SUM(auditorlog.ngapain = 'Reclassification') as total_reclassification"),
                DB::raw("SUM(auditorlog.ngapain = 'ReexportImage') as total_reexportimage")
            )
            ->whereBetween(DB::raw("DATE(auditorlog.created_at)"), [$this->startDate, $this->endDate])
            ->where('users.is_active', 1)
            ->whereIn('auditorlog.ngapain', [
                'Insert',
                'Reject',
                'Reclassification',
                'ReexportImage'
            ])
            ->groupBy('users.name', 'users.id', DB::raw("DATE(auditorlog.created_at)"))
            ->orderBy('users.name')
            ->get();

        $results = [];
        $dates   = [];

        foreach ($rows as $row) {

            $dates[$row->d] = $row->d;

            if (!isset($results[$row->auditorId])) {
                $results[$row->auditorId] = [
                    'validatorName' => $row->validatorName,
                    'auditorId'   => $row->auditorId,
                    'dates'         => [],
                    'category'      => [
                        'Insert'            => 0,
                        'Reject'           => 0,
                        'reclassification' => 0,
                        'reexportimage'    => 0,
                    ],
                    'grandTotal' => 0
                ];
            }

            $results[$row->auditorId]['dates'][$row->d] = $row->total;

            $results[$row->auditorId]['category']['Insert'] += $row->total_Insert;
            $results[$row->auditorId]['category']['Reject'] += $row->total_Reject;
            $results[$row->auditorId]['category']['reclassification'] += $row->total_reclassification;
            $results[$row->auditorId]['category']['reexportimage'] += $row->total_reexportimage;

            $results[$row->auditorId]['grandTotal'] += $row->total;
        }

        ksort($dates);

        $this->report = [
            'dates' => array_values($dates),
            'data'  => $results
        ];
    }
    public function render()
    {
        return view('livewire.validator-task-component');
    }
}
