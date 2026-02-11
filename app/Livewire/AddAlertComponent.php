<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class AddAlertComponent extends Component
{
    public $alertId, $alertStatus, $detectionDate, $observation, $alertNote;
    public $chooseRegion = '', $chooseProvince = '';
    public $region = 'Please select', $province = 'Please select';

    public function getRegions(){
        try {
            $req = Http::get('http://129.150.48.143:8080/geoserver/simontini/wfs',
            [
                'service' => 'wfs',
                'version' => '1.1.0',
                'request' => 'GetFeature',
                'typename' => 'simontini:province',
                'propertyName' => 'island_en',
                'cql_filter' => "island_en ILIKE '%". $this->chooseRegion ."%'",
                'maxFeatures' => 10,
                'outputFormat' => 'application/json',
            ]);
            $response = json_decode($req, true);
            // $arrUnique = array_unique($response['features'][0]['properties']['provinsi']);
            $res = array();
            foreach ($response['features'] as $each) {
                if (isset($res[$each['properties']['island_en']]))
                    array_push($res[$each['properties']['island_en']], $each['properties']['island_en']);
                else
                    $res[$each['properties']['island_en']] = array($each['properties']['island_en']);
                }
            return array_slice($res, 0, 10);
        } catch (\Throwable $th) {
            return [];
        }



    }

    public function getProvinces(){
        try {
            $req = Http::get('http://129.150.48.143:8080/geoserver/simontini/wfs',
            [
                'service' => 'wfs',
                'version' => '1.1.0',
                'request' => 'GetFeature',
                'typename' => 'simontini:province',
                'propertyName' => 'island_en,prov_en',
                'cql_filter' => "island_en = '". $this->region ."' AND prov_en ILIKE '%". $this->chooseProvince ."%'",
                'maxFeatures' => 10,
                'outputFormat' => 'application/json',
            ]);
            $response = json_decode($req, true);
            // $arrUnique = array_unique($response['features'][0]['properties']['provinsi']);
            $res = array();
            foreach ($response['features'] as $each) {
                if (isset($res[$each['properties']['prov_en']]))
                    array_push($res[$each['properties']['prov_en']], $each['properties']['prov_en']);
                else
                    $res[$each['properties']['prov_en']] = array($each['properties']['prov_en']);
                }
            return array_slice($res, 0, 10);
        } catch (\Throwable $th) {
            return [];
        }



    }

    public function selectRegion($value){
        // dd($value);
        $this->region = $value;
        $this->province = 'Please select';
        $this->dispatch('region', ['newName' => $value]);
        $this->chooseProvince = '';

    }

    public function selectProvince($value){
        // dd($value);
        $this->province = $value;
        $this->dispatch('province', ['newName' => $value]);

    }

    public function render()
    {
        $regions = $this->getRegions();
        $provincies = $this->getProvinces();
        return view('livewire.add-alert-component',compact('regions', 'provincies'));
    }

    public function checkAlert(){
        return DB::table('alerts')->where('alertId', $this->alertId)->where('isActive', 1)->first();
    }

    public function checkAlertStatus(){
        $status = 'pre-approved';

        if($this->alertStatus == 'rejected'){
            $status = 'rejected';
        }

        return $status;
    }

    public function storeAlert(){

        if($this->manualValidation()){
            DB::table('alerts')->insert([
                'analisId' => session('id'),
                'alertId' => $this->alertId,
                'observation' => $this->observation,
                'alertStatus' => $this->alertStatus,
                'detectionDate' => $this->detectionDate,
                'alertNote' => $this->alertNote,
                'region' => $this->region,
                'province' => $this->province,
                'auditorStatus' => $this->checkAlertStatus(),
                'isActive' => 1,
                'platformStatus' => 'sccon',
                'created_at' => Carbon::now('Asia/Jakarta')
            ]);

            DB::table('auditorlog')->insert([
                'auditorId' => session('id'),
                'alertId' => $this->alertId,
                'ngapain' =>  ($this->alertStatus == 'rejected') ? 'Reject' : 'Insert',
                'created_at' => Carbon::now('Asia/Jakarta')
            ]);
            redirect()->to('/dashboard');

        }
    }

    public function manualValidation(){
        if($this->checkAlert()){
            Toaster::error('Alert already exists in the database');
            return;
        }elseif($this->alertId == ''){
            Toaster::error('Alert ID is required!');
            return;
        }elseif($this->observation == ''){
            Toaster::error('Observation is required!');
            return;
        }elseif($this->alertStatus == ''){
            Toaster::error('Alert Status is required!');
            return;
        }elseif($this->detectionDate == ''){
            Toaster::error('Detection Date is required!');
            return;
        }elseif($this->region == 'Please select'){
            Toaster::error('Region is required!');
            return;
        }elseif($this->province == 'Please select'){
            Toaster::error('Province is required!');
            return;
        }elseif($this->alertStatus == 'rejected' && $this->alertNote == ''){
            Toaster::error('Alert note is required because you rejected this alert!');
            return;
        }
        return true;
    }
}
