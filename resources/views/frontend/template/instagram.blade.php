@extends('frontend.layouts.app')

@section('content')
  <div  class="jumbotron">
  </div>
  <section id="home-icons" class="py-2">
      <div class="container">
        <h2  class="text-center mt-0">Welcome to Instagram</h2>
        <hr class="divider my-4 " />
        <div class="row">
          <div class="col-md-4 mb-4 text-center">
            <i style="font-size: 50px;" class="fas fa-user-friends "></i>
            <h3 style="font-family: 'Nunito' , sans-serif">Friends</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora
              eos odit perferendis suscipit quibusdam quam recusandae
              exercitationem accusantium delectus itaque?
            </p>
          </div>
          <div class="col-md-4 mb-4 text-center">
              <i style="font-size: 50px; " class="fas fa-heart"></i>
            <h3 style="font-family: 'Nunito' , sans-serif" >Like</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora
              eos odit perferendis suscipit quibusdam quam recusandae
              exercitationem accusantium delectus itaque?
            </p>
          </div>
          <div class="col-md-4 mb-4 text-center">
            <i style="font-size: 50px;" class="far fa-images" ></i>
            <h3 style="font-family: 'Nunito' , sans-serif" >Images</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora
              eos odit perferendis suscipit quibusdam quam recusandae
              exercitationem accusantium delectus itaque?
            </p>
          </div>
        </div>
      </div>
    </section>
@endsection