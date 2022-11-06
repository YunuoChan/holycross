@extends('layouts.app')

@section('head')
    <title>HCC | Login</title>

      <link href="{{ asset('/css/login-page.css') }}" rel="stylesheet" type="text/css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      
@stop



@section('content')



<div class="container">
    <h2>login</h2>
    <form>
    
        <div class="group">      
          <input type="text" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Name</label>
        </div>
          
        <div class="group">      
          <input type="text" required>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Email</label>
        </div>
        
      </form>
   
</div>
@endsection


@section('page-script')

    
@stop
