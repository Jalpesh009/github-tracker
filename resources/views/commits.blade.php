@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col"> <a class="btn btn-primary btn-sm float-left" href="{{route('home')}}" role="button">Back To List</a> </div>
                    <div class="col-8 text-center"> Commits List - ({{$flight->name}}) (# - {{$current_branch}}) </div>
                    <div class="col"> <a class="btn btn-primary btn-sm float-right" href="{{route('checkout.master',['repoId'=>$flight->id])}}" role="button">Checkout Master</a> </div>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">SHA</th>
                        <th scope="col">Massage</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($commits as $commit)
                       <tr>
                          <td>{{ $commit['id'] }}</td>
                          <td width="15%">{{ $commit['sha'] }}</td>
                          <td width="20%">{{ $commit['massage'] }}</td>
                          <td width="15%">
                            <a class="btn btn-primary btn-sm" href="{{route('checkout.commit',['id'=>$commit['id'],'repoId'=>$flight->id])}}" role="button">Checkout</a>
                          </td>
                       </tr>
                       @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
