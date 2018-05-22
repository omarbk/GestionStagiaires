<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Notifications\RepliedThread;
use App\Events\NewComment;
use App\Evaluateur;
use App\User;
class NotificationController extends Controller
{
    public function MarkNotifRead(){
        foreach (Auth::user()->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        
      
        $CountnotifNotRead = count(Auth::user()->unreadNotifications);
        return Response()->json(['CountnotifNotRead' => $CountnotifNotRead ]);
    }

    public function addNotification(Request $request){
                
        $evaluateur = Evaluateur::leftJoin('users', 'evaluateurs.fk_user', '=', 'users.id')
                    ->select('evaluateurs.*', 'users.*')
                    ->where('evaluateurs.id_evaluateur','=',$request->id_evaluateur)
                    ->get();
                    $user = User::where('id', '=', $evaluateur[0]->fk_user)->get();
        //$user = Auth::user();
        \Notification::send($user, new RepliedThread($request->message));
        
        event(new NewComment());
        return Response()->json(['notif' => $request->intitule_stage ]);
    }
    public function getNotifications(){

        $notifications = Auth::user()->notifications;
        $CountnotifNotRead = count(Auth::user()->unreadNotifications);
        return Response()->json(['notifications' => $notifications ,'CountnotifNotRead' => $CountnotifNotRead ]);
     }
     public function getEvaluateurParStage($id_evaluateur){
        
        $evaluateur = Evaluateur::leftJoin('users', 'evaluateurs.fk_user', '=', 'users.id')
                    ->select('evaluateurs.*', 'users.*')
                    ->where('evaluateurs.id_evaluateur','=',$id_evaluateur)
                    ->get();
                    $user = User::where('id', '=', $evaluateur[0]->fk_user)->get();
                   // $user = Auth::user()->get();
                    dd($users);
                   // dd($evaluateur[0]->fk_user);

                 return Response()->json(['evaluateur' => $user]);
    }

}
