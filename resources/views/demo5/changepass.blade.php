@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6 col-md-offset-2">
            <div class="panel panel-default">          
                <br>
                <br>
                <div class="panel-heading"><h3>Reset Password: First Time Use</h3></div>
                  <br>

                <div class="panel-body jumbotron" style="background-color: #ffffff">
                    <form action="{{ route('changePassword')}}" method="post"> 
          
                   @include('inc.messages')
                   <input type="hidden" name="id" value="{{ Auth::user()->id }}">
        
                        {{ csrf_field() }}
                        
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="password" class="col-12 control-label">Password</label>

                            <div class="col-12">
                                <input id="password" type="password" class="form-control" name="password" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="password" class="col-12 control-label">Confirm Password</label>

                            <div class="col-12">
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                               <br>
                            </div>
                        </div>
                       

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 


 