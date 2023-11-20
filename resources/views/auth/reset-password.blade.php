@extends('layout')

  

@section('content')

<main class="login-form">

  <div class="cotainer">

      <div class="row justify-content-center">

          <div class="col-md-8">

              <div class="card">

                  <div class="card-header">Reset Password Code</div>

                  <div class="card-body">
                   
                    <h1>
                        {{$data['code']}}
                    <h1>

                      


                        

                  </div>

              </div>

          </div>

      </div>

  </div>

</main>

@endsection