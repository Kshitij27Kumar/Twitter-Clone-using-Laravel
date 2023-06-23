<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{
    //

    public function submit_tweet(Request $request){
       $text = $request->input('text');
       $user_name = $request->input('user_name');
       $user_id = $request->input('user_id');
       $user_image = $request->input('user_image');
       $time = date('Y-m-d H:i:s');

       DB::table('tweets')->insertGetId([
           'user_name'=>$user_name,
           'user_id'=>$user_id,
           'user_image'=>$user_image,
           'text'=>$text,
           'time'=>$time
       ]);

       return \redirect('/');

    }


    public function index(){
       //$tweets = DB::table('tweets')->get();
       $following_tweets = DB::table('followers')->where('other_user_id',Auth::user()->id)->leftJoin('tweets','followers.user_id','=','tweets.user_id')
                          ->orderBy('tweets.id','desc')->paginate(10);
                           // dd($following_tweets);  
                            //tweet user_id        followers other_user_id
                                //1
                                //2
       return \view('index',['following_tweets'=>$following_tweets]);
    }

    public function lists(){
        $users = DB::table('users')->paginate(2);
        return view('lists',['users'=>$users]);
    }


    public function like_post(Request $request,$tweet_id,$user_id){
        
        $has_user_liked_this_post = DB::table('like')->where('tweet_id',$tweet_id)->where('user_id',$user_id)->exists();

        if($has_user_liked_this_post){
            return \redirect('/')->with('failure_message','you have liked this post before');
        }

        //increase number of likes
       $tweet = DB::table('tweets')->where('id',$tweet_id)->get();
                 DB::table('tweets')->where('id',$tweet_id)->update([
                       'number_of_likes'=> $tweet[0]->number_of_likes+1
                 ]);

         //notify other_user that their tweet has been liked        
         $other_user =   DB::table('tweets')->where('id',$tweet_id)->get()[0];
         DB::table('notifications')->insert(['user_id'=>$other_user->user_id,'text'=>'Your tweet has been liked by '.Auth::user()->name]);  

         //insert tweet_id and user_id in like table        
        DB::table('like')->insert(['tweet_id'=>$tweet_id,'user_id'=>$user_id]);       
        return \redirect('/')->with('success_message','You have liked this tweet');         
    }


    public function test(Request $request){
        return view('test');
    }
    public function test1(Request $request,$id1,$id2){
        dd($id1,$id2);
        return view('test');
    }


    public function notifications(Request $request){
        $notifications = DB::table('notifications')->where('user_id',Auth::user()->id)->get();
        return view('notifications',['notifications'=>$notifications]);
    }
    
}
