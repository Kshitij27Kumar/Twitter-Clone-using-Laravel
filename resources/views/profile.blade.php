@extends('layout.main')

@section('content')
  


<style>
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
</style>

    <!-- feed starts -->
    <div class="feed">
      <div class="feed__header">
        <h2>Home</h2>
      </div>

      <!-- tweetbox starts -->
      <!-- <div class="tweetBox">
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
      </div> -->
      <!-- tweetbox ends -->




      @foreach($single_user as $user)
      <!-- post starts -->
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
                {{$user->name}}
                <span class="post__headerSpecial"
                  ><span class="material-icons post__badge"> verified </span>{{$user->email}}</span
                >
              </h3>

              @if($user->id == Auth::user()->id)
                      <form action="{{route('upload_image')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="image" >
                            <input type="submit" value="upload image">
                        </form>
           

               <button id="myBtn">Change username</button>

                  <!-- The Modal -->
                  <div id="myModal" class="modal">

                    <!-- Modal content -->
                    <div class="modal-content">
                      <span class="close">&times;</span>
                      <p>
                        <form action="{{route('change_username')}}" method="POST">
                          @csrf
                          <input type="text" name="username" placeholder="change username">
                          <input type="submit" value="change username">
                        </form>
                      </p>
                    </div>

                  </div>


                

                @endif 

 



               
               
            </div>
        
          </div>
          <img
            src="https://www.focus2move.com/wp-content/uploads/2020/01/Tesla-Roadster-2020-1024-03.jpg"
            alt=""
          />
          <div class="post__footer">
          @if($user->id != Auth::user()->id)
          <form  method="POST" action="{{route('follow_user')}}">
                  @csrf
                  <input type="hidden" name="other_user_id" value="{{$user->id}}">
                  <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                  <input class="tweetBox__tweetButton" value="Follow" type="submit">
               </form>
           @endif  
           
             <form >
                  <input class="tweetBox__tweetButton" value="{{$number_of_tweets}} Tweets" type="submit">
               </form>

               <form method="POST" action="{{route('followers')}}">
                 @csrf
                 <input type="hidden" name="id" value="{{route('followers')}}">
                  <input class="tweetBox__tweetButton" value="{{$number_of_followers}} Follwres" type="submit">
               </form>


               <form method="POST" action="{{route('followings')}}" >
                 @csrf
                  <input type="hidden" name="id" value="{{Auth::user()->id}}">
                  <input class="tweetBox__tweetButton" value="{{$number_of_followings}} Following" type="submit">
               </form>

          </div>
        </div>
      </div>
      <!-- post ends -->
      @endforeach
      
      
      @foreach($tweets as $tweet)
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
                  ><span class="material-icons post__badge"> verified </span>@somanathg</span
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
            <span class="material-icons"> favorite_border </span>
            <span class="material-icons"> publish </span>
          </div>
        </div>
      </div>
      <!-- post ends -->
      {{$tweets->links()}}
      @endforeach
      
      <!-- post ends -->
    </div>
  
    <!-- feed ends -->




   





    <script>

                  // Get the modal
                  var modal = document.getElementById("myModal");

                  // Get the button that opens the modal
                  var btn = document.getElementById("myBtn");

                  // Get the <span> element that closes the modal
                  var span = document.getElementsByClassName("close")[0];

                  // When the user clicks on the button, open the modal
                  btn.onclick = function() {
                    modal.style.display = "block";
                  }

                  // When the user clicks on <span> (x), close the modal
                  span.onclick = function() {
                    modal.style.display = "none";
                  }

                  // When the user clicks anywhere outside of the modal, close it
                  window.onclick = function(event) {
                    if (event.target == modal) {
                      modal.style.display = "none";
                    }
                  }

                  </script>
                  


    @endsection

 
