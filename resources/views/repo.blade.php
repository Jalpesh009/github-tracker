@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-2"> <a class="btn btn-primary btn-sm float-left" href="{{route('home')}}" role="button">Back To List</a> </div>
                    <div class="col text-left"> {{$repo->name}} </div>
                  </div>
                </div>
                <div class="card-body">
                  <div>
                    <?php dump($file_changes) ?>
                  <div>
                    <div >
                      <!-- <a class="btn btn-primary" href="{{route('push.repo',['id'=>$repo->id])}}" role="button">Push All</a> -->
                      <form method="POST" action="{{route('push.repo',['id'=>$repo->id]) }}">
                            @csrf
                            <div class="form-group row">
                                <label for="msg" class="col-md-4 col-form-label text-md-right">Massage</label>
                                <div class="col-md-6">
                                    <textarea  id="msg" rows="3" type="textarea" class="form-control @error('msg') is-invalid @enderror" name="msg" value="{{ old('msg') }}" required autocomplete="name" autofocus ></textarea>
                                    @error('msg')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Push All
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
