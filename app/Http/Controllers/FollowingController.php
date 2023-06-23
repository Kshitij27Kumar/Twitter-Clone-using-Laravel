<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class FollowingController extends Controller
{



    public function follow_user(Request $request){
        $user_id = $request->input('user_id');
        $other_user_id =   $request->input('other_user_id');

        $already_following_this_person = DB::table('followers')->where('user_id',Auth::user()->id)->where('other_user_id',$other_user_id)->exists();

        if($already_following_this_person){
            return \redirect('/')->with('failure_message','You have followed this person before');
        }

        DB::table('followers')->insert([
            'user_id' => $user_id,
            'other_user_id' => $other_user_id
        ]);

        $user_name = Auth::user()->name;
        $other_user_name = DB::table('users')->where('id',$other_user_id)->get()[0]->name;


        //add notifications]= into database
        DB::table('notifications')->insert(['user_id'=>Auth::user()->id, 'text'=>'you have followed '.$other_user_name ]);
        DB::table('notifications')->insert(['user_id'=>$other_user_id, 'text'=>'you have a new follower '.$user_name]);
              
        return \redirect('/')->with('success_message','You have started folloing this person');



    }



    public function unfollow_user(Request $request){
        $other_user_id = $request->input('other_user_id');
        DB::table('followers')->where('user_id',Auth::user()->id)->where('other_user_id',$other_user_id)->delete();


        $user_name = Auth::user()->name;
        $other_user_name = DB::table('users')->where('id',$other_user_id)->get()[0]->name;


         //add notifications]= into database
         DB::table('notifications')->insert(['user_id'=>Auth::user()->id, 'text'=>'you have unfollowed '.$other_user_name ]);
         DB::table('notifications')->insert(['user_id'=>$other_user_id, 'text'=>Auth::user()->name.' unfollowed you']);
               
        return \redirect('/')->with('success_message','You have unfollowed this user successfully');
    }


    public function followings(){
        $followings = DB::table('followers')->where('user_id',Auth::user()->id)->leftJoin('users','followers.other_user_id','=','users.id')->get();
        return view('followings',['followings'=>$followings]);
    }

    public function followers(){
        $followings = DB::table('followers')->where('other_user_id',Auth::user()->id)->leftJoin('users','followers.user_id','=','users.id')->get();
        
        return view('followings',['followings'=>$followings]);
    }



}