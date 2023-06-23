@extends('layout.main')

@section('content')
  

    <!-- feed starts -->
    <div class="feed">
      <div class="feed__header">
        <h2>Home</h2>
      </div>

      <!-- tweetbox starts -->
      <div class="tweetBox">
        <form method="POST" action="{{route('submit_tweet')}}">
          @csrf
          <div class="tweetbox__input">
            <img
              src="https://i.pinimg.com/originals/a6/58/32/a65832155622ac173337874f02b218fb.png"
              alt=""
            />
            <input name="text" type="text" placeholder="What's happening?" />
            <input name="user_id" type="hidden" value="{{Auth::user()->id}}" >
            <input name="user_name" type="hidden" value="{{Auth::user()->name}}" >
            <input name="user_image" type="hidden" value="{{Auth::user()->image}}">
          </div>
          <input class="tweetBox__tweetButton" value="Tweet" type="submit">
        </form>
      </div>
      <!-- tweetbox ends -->




      @foreach($followers as $user)
      <!-- post starts -->

     @if($user->id != Auth::user()->id)

      <div class="post">
        <div class="post__avatar">
          <img
            src="{{asset('images/'.$user->image)}}"
            alt=""
           
          />
        </div>

        <div class="post__body">
          <div class="post__header">
            <div class="post__headerText">
              <h3>
                  <a href="{{route('profile',['id'=>$user->id])}}"> {{$user->name}}</a>
                <span class="post__headerSpecial"
                  ><span class="material-icons post__badge"> verified </span>{{$user->email}}</span
                >
                <form  method="POST" action="{{route('single_message')}}">
                  @csrf
                  <input type="hidden" name="other_user_id" value="{{$user->id}}">
                  <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                  <input class="tweetBox__tweetButton" value="Message" type="submit">
               </form>
              </h3>
            </div>
            <div class="post__headerDescription">
             
            </div>
          </div>
          <img
            src="https://www.focus2move.com/wp-content/uploads/2020/01/Tesla-Roadster-2020-1024-03.jpg"
            alt=""
          />
        
          <div class="post__footer">
           
            
       


          </div>


        </div>
      </div>
      <!-- post ends -->
      @endif
    
      @endforeach

      
      <!-- post ends -->
    </div>
    <!-- feed ends -->


    @endsection

 
