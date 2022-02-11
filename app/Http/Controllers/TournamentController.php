<?php

namespace App\Http\Controllers;



use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\TournamentEnrollement;
use App\Models\EnrollementUser;
use App\Models\User;
use Illuminate\Support\Facades\Validator;



class TournamentController extends Controller
{
    public function TournamentEnrollementApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id'       => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->all(),404);
        }
       $checkTornament =  TournamentEnrollement::where('status','created')->where('count','<',8)->get()->first();
       if($checkTornament)
       {
           $tornmanet_id = $checkTornament->id;
           $myData = ['count'=>$checkTornament->count + 1,'status'=>'created'];

           if($checkTornament->count == 7 )
           {
             $myData['status'] = 'started';
           }

           $res =  TournamentEnrollement::where('id',$tornmanet_id)->update($myData);
             $inroll_user = EnrollementUser::create([
                'tournament_inrolment_id' =>$tornmanet_id,
                'player_id'               =>$request->player_id,

            ]);
        }else{
        $tornmanet = TournamentEnrollement::create([
            'status'        =>'created',
            'count'         =>1
        ]);

       EnrollementUser::create([
            'tournament_inrolment_id' =>$tornmanet->id,
            'player_id'               =>$request->player_id,

        ]);
        $tornmanet_id = $tornmanet->id;
     }

       $players = EnrollementUser::where('tournament_inrolment_id',$tornmanet_id)->pluck('player_id');
       $users = User::whereIn('id',$players)->get()->toArray();
       $roles = DB::table('tournaments')->get()->toArray();
       $data = ['players'=>$users,'roles'=>$roles];
       return response()->json($data,200);
    }

    public function TournamentWinnerDeclareApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'torunamentID'       => 'required',
            'WinnerID'           => 'required',
            'PrizeType'          => 'required',
            'WinnerPrize'       => 'required',
        ]);

        if (!$validator->fails()) {
            $check = TournamentEnrollement::where(['id'=>$request->torunamentID,'status'=>'started','count'=>8])->first();


            if($check)
            {
                $res =  TournamentEnrollement::where('id',$request->torunamentID)->update(['status'=>'Ended']);
                $res =  User::where('user_id',$request->WinnerID)->update(['coins'=>'Ended']);
                $msg['message'] = "Success";

            }else{
                $msg['message'] = "Enrollement not completed ";
            }
            return response()->json($msg['message'],200);


        }else{
            return response()->json($validator->errors()->all(),404);
        }
    }
}
