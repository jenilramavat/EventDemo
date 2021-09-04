<?php

namespace App\Http\Controllers;

use App\Event;
use App\Recurrence;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Request;



class EventController extends Controller
{
    

	public function index(){
		return view('event.index');
	}

	public function ajax_datagrid(){
		$EventData=DB::table("tblevent")
			->join('tblRecurrence','tblevent.EventID','tblRecurrence.EventID')
			->select('EventTitle','StartDate','EndDate',DB::raw('CONCAT(tblRecurrence.RepeatOrder," ",tblRecurrence.RepeatDays) as Recurrence'),'tblevent.EventID as EventID','RepeatType','RepeatOrder','RepeatDays','RepeatMonth');
		return datatables()->of($EventData)->orderColumn('EventID','-EventID $1')->make(false);
    }

	public function addEvent(){
		$data=Request::all();

		$rules = array(
			'EventTitle'=>['required'],
			'StartDate'=>['required'],
			'EndDate'=>['required'],

		);
		$validator=Validator::make($data,$rules);
		if($validator->fails()){
			return json_validator_response($validator);
		}
		//print_r($data);

		$eventdata=array(
			'EventTitle'=>$data['EventTitle'],
			'StartDate'=>$data['StartDate'],
			'EndDate'=>$data['EndDate'],
			'created_at'=>date('Y-m-d H:i:s'),
			'updated_at'=>date('Y-m-d H:i:s')
		);
		if($event=Event::create($eventdata)){

			//Add records in tblRecurrence



			if($data['RepeatType']=='repeat'){
				$tblRecurrenceData=array(
					'EventID'=>$event->EventID,
					'RepeatType'=>'0',
					'RepeatOrder'=>$data['RepeatOrder'],
					'RepeatDays'=>$data['RepeatDays'],
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>date('Y-m-d H:i:s')
				);

			}else{
				$tblRecurrenceData=array(
					'EventID'=>$event->EventID,
					'RepeatType'=>'1',
					'RepeatOrder'=>$data['RepeatOrderon'],
					'RepeatDays'=>$data['RepeatDayson'],
					'RepeatMonth'=>$data['RepeatMonth'],
					'created_at'=>date('Y-m-d H:i:s'),
					'updated_at'=>date('Y-m-d H:i:s')
				);
			}


			//print_r($tblRecurrenceData);die;
			if($recu=Recurrence::create($tblRecurrenceData)){
				return response()->json(array('status'=>'success','message'=>"Event created Successfully"));
			}

			return response()->json(array('status'=>'failed','message'=>"Problem creating Event"));

		}else{
			return response()->json(array('status'=>'failed','message'=>"Problem creating Event"));
		}



	}



	public function updateEvent($id){
		if($id > 0){
			$data=Request::all();
			$Event=Event::findOrFail($id);

			$rules = array(
				'EventTitle'=>['required'],
				'StartDate'=>['required'],
				'EndDate'=>['required'],

			);
			$validator=Validator::make($data,$rules);
			if($validator->fails()){
				return json_validator_response($validator);
			}
			//print_r($data);

			$eventdata=array(
				'EventTitle'=>$data['EventTitle'],
				'StartDate'=>$data['StartDate'],
				'EndDate'=>$data['EndDate'],
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=>date('Y-m-d H:i:s')
			);

			if($Event->update($eventdata)){
				if($data['RepeatType']=='repeat'){
					$tblRecurrenceData=array(

						'RepeatType'=>'0',
						'RepeatOrder'=>$data['RepeatOrder'],
						'RepeatDays'=>$data['RepeatDays'],
						'created_at'=>date('Y-m-d H:i:s'),
						'updated_at'=>date('Y-m-d H:i:s')
					);

				}else{
					$tblRecurrenceData=array(

						'RepeatType'=>'1',
						'RepeatOrder'=>$data['RepeatOrderon'],
						'RepeatDays'=>$data['RepeatDayson'],
						'RepeatMonth'=>$data['RepeatMonth'],
						'created_at'=>date('Y-m-d H:i:s'),
						'updated_at'=>date('Y-m-d H:i:s')
					);
				}
				$EventRecur=Recurrence::where('EventID',$Event->EventID);
				if($EventRecur->update($tblRecurrenceData)){
					return response()->json(array('status'=>'success','message'=>"Event Updated Successfully"));
				}
				return response()->json(array('status'=>'success','message'=>"Problem Updating Successfully"));
			}else{
				return response()->json(array('status'=>'success','message'=>"Problem Updating Successfully"));
			}

		}
		return response()->json(array('status'=>'success','message'=>"Problem Updating Successfully"));
	}

	public function deleteEvent($id){
		if(intval($id) > 0){
			$Event=Recurrence::where('EventID',$id)->get();
			if(!empty($Event)){
				Recurrence::where('EventID',$id)->delete();
			}
			$res=Event::find($id)->delete();
			if($res){
				return response()->json(array('status'=>'success','message'=>"Event Deleted Successfully"));
			}
		}
		return response()->json(array('status'=>'success','message'=>"Problem Deleting Event"));
	}

	public function viewEvent($id){
		$Event=Event::findOrFail($id);
		$Recur=Recurrence::where('EventID',$id)->get();
		$RecuData=$Recur[0];

		$StartDate=$Event->StartDate;
		$EndDate=$Event->EndDate;

		$EventTitle=$Event->EventTitle;

		$RepeatOrder=$RecuData['RepeatOrder'];
		$RepeatDays=$RecuData['RepeatDays'];
		$RepeatMonth=$RecuData['RepeatMonth'];
		$RepeatType=$RecuData['RepeatType'];

		$ResultArray=array();
		$str='P';
		if($RepeatType=='0'){

			if($RepeatOrder=='every'){
				$str.='1';
			}else if($RepeatOrder=='everythird'){
				$str.='3';
			}else if($RepeatOrder=='everyfourth'){
				$str.='4';
			}

			if($RepeatDays=='day'){
				$str.='D';

			}else if($RepeatDays=='week'){
				$str.='W';

			}else if($RepeatDays=='month'){
				$str.='M';

			}else if($RepeatDays=='year'){
				$str.='Y';

			}
			$ResultArray = getDatesFromRange($StartDate, $EndDate,$str);
		}else{

			if($RepeatMonth=='month'){
				$str.='1M';
			}else if($RepeatMonth=='3month'){
				$str.='3M';
			}else if($RepeatMonth=='4month'){
				$str.='4M';
			}else if($RepeatMonth=='6month'){
				$str.='6M';
			}else if($RepeatMonth=='year'){
				$str.='1Y';
			}

			$ResultArray = getDatesFromRange($StartDate, $EndDate,$str);

		}

		return view('event.view',compact('ResultArray','EventTitle'));

	}

}
