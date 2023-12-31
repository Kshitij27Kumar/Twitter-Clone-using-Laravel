@extends('layout.main')

@section('content')
  


    <!-- feed starts -->
    <div class="feed">
      <div class="feed__header">
        <h2>Home</h2>
      </div>


      @if(Session::has('success_message'))
      <div class="alert alert-success text-center">{{Session::get('success_message')}}</div>
      @endif

      @if(Session::has('failure_message'))
      <div class="alert alert-danger text-center">{{Session::get('failure_message')}}</div>
      @endif


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




      @foreach($following_tweets as $tweet)
      <!-- post starts -->
      <div class="post">
        <div class="post__avatar">
          <img
            src="{{asset('images/'.$tweet->user_image)}}"
            alt=""
           
          />
        </div>

        <div class="post__body">
          <div class="post__header">
            <div class="post__headerText">
              <h3>
                {{$tweet->user_name}}
                <span class="post__headerSpecial"
                  ><span class="material-icons post__badge"> verified </span></span
                >
              </h3>
            </div>
            <div class="post__headerDescription">
              <p>{{$tweet->text}}</p>
            </div>
          </div>
          <img
            src="https://www.focus2move.com/wp-content/uploads/2020/01/Tesla-Roadster-2020-1024-03.jpg"
            alt=""
          />
          <div class="post__footer">
            <span class="material-icons"> repeat </span>
      
            <span class="material-icons"> publish </span>
          </div>
        </div>
      </div>
      {{$following_tweets->links()}}
      <!-- post ends -->
      @endforeach

      
      <!-- post ends -->
    </div>
    <!-- feed ends -->


    @endsection

 
