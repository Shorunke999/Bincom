<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Resources\PollinResources;
use App\Models\AnnouncedPuResult;
use App\Models\lgaTableModel;
use App\Models\polling_unit_table;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    //switch form
    public function switch(Request $request){
        if($request->input('activeForm') == 'active1'){
             return redirect()->back()->with('activeForm',$request->input('activeForm'));
        }elseif ($request->input('activeForm') == 'active2') {
           $lgaData =  lgaTableModel::all();
            return redirect()->back()->with('activeForm',$request->input('activeForm'))
            ->with('data', $lgaData);
        }elseif($request->input('activeForm') == 'active3'){
            $politicalParty = [
                'PDP',
                'DPP',
                'ACN',
                'PPA',
                'CDC',
                'JP',
                'ANPP',
                'LABOUR',
                'CPP'
            ];
            return redirect()->back()->with('activeForm',$request->input('activeForm'))
            ->with('data', $politicalParty);
        }
       
    }

    //question 1
    public function submitPollingUnitId(Request $request)
    {
        $pollingUnitId = $request->input('polling_unit_id');

        // Process the submitted polling_unit_id here
        $dataFromDb = AnnouncedPuResult::where('polling_unit_uniqueid',$pollingUnitId)->get();

        $collection = PollinResources::collection($dataFromDb);
        $totalScore = 0;
        foreach ($collection as $item ) {
            $totalScore = $totalScore +  $item->party_score;
        }
        //dd($totalScore);
        $data = [
            'id'=> $pollingUnitId,
            'score'=> $totalScore
        ];
        return redirect()->route('displayscore')->with('data', $data);
    }

    public function displayview(){
        $dataPassed = session('data');
        return view('display',[
            'id' => $dataPassed['id'],
            'score' => $dataPassed['score']
        ]);
    }

    //question 2
    public function process(Request $request){
        $score = 0;
         foreach($request['selected_items'] as $data){
            $pollingUnits = polling_unit_table::where('lga_id',json_decode($data)->lga_id)->get();
            foreach($pollingUnits as $pollingUnit){
                $pollingArray = AnnouncedPuResult::where('polling_unit_uniqueid',$pollingUnit['polling_unit_id'])->get();
                if(!empty($pollingArray)){
                    foreach($pollingArray as $pollingScore){
                        $score = $score + $pollingScore['party_score'];
                    }
                }
                
            }
        }
        return redirect()->route('computedScore')->with('msg',$score);
         
    }

    //question3
    public function saveScore(Request $request){
        //dd($request);
       $pollingId = $request->polling_unit_id;
       $enteredBy = $request->name;
       unset($request['name']);
       unset($request['polling_unit_id']);
       //dd($request);
       collect($request['req'])->map(
        function($data)use($pollingId,$enteredBy){
            //dd($data->party_abbreviation);
            AnnouncedPuResult::create([
            'entered_by_user' =>  $enteredBy,
            'polling_unit_uniqueid' => $pollingId,
            'party_abbreviation' => $data["party_abbreviation"],
            'party_score' => intval($data['score']),
            'date_entered'=>now(),
            'user_ip_address' => '192.168.1.115'
        ]);
        }
    );
       return redirect()->route('dashboard')->with('relaymessage','Upload succesfull');
    }
}

