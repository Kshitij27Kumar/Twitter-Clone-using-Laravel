<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{



    public function profile(Request $request,$id){
        $single_user = DB::table('users')->where('id',$id)->get();
        $tweets = DB::table('tweets')->where('user_id',$id)->paginate(5);
        //get number of tweets
        $number_of_tweets = DB::table('tweets')->where('user_id',$id)->count();
        //get number of followers
        $number_of_followings = DB::table('followers')->where('user_id',$id)->count();
        //get number of following
        $number_of_followers = DB::table('followers')->where('other_user_id',$id)->count();

        return view('profile',['single_user'=>$single_user,'tweets'=>$tweets,
                            'number_of_tweets'=>$number_of_tweets,
                            'number_of_followings'=>$number_of_followings,
                            'number_of_followers'=>$number_of_followers]);
    }




   


    function upload_image(Request $request){

        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        $imageName = time().'.'.$request->image->extension();

        // Public Folder
        $request->image->move(public_path('images'), $imageName);


        DB::table('users')->where('id',Auth::user()->id)->update(['image'=>$imageName]);

        //update image in old tweets
        DB::table('tweets')->where('user_id',Auth::user()->id)->update(['user_image'=>$imageName]);

        // //Store in Storage Folder
        // $request->image->storeAs('images', $imageName);

        // // Store in S3
        // $request->image->storeAs('images', $imageName, 's3');

        //Store IMage in DB 


        return back()->with('success', 'Image uploaded Successfully!')
        ->with('image', $imageName);
        
        // $id = Auth::user()->id;
        // $extension = $request->file('image')->extension();
        // $request->file('image')->storeAs('images',$id.'.'.$extension);
        // DB::table('users')->where('id',$id)->update(['image'=>$id.'.'.$extension]);


        // $id = Auth::user()->id;
        // $extension = $request->image->extension();
        // $newImageName = $id.'.'.$extension;
        // $request->image->move(public_path('images',$newImageName));
        // DB::table('users')->where('id',$id)->update(['image'=>$newImageName]);
    }


    public function change_username(Request $request){
        $username = $request->input('username');
        $user_id = Auth::user()->id;

        DB::table('users')->where('id',$user_id)->update(['name'=>$username]);

        return \redirect('/')->with('success_message','Username has been changed successfully');
    }


}