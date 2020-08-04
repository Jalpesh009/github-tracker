@extends('layouts.app')

@section('content')
<div class="Container-fluid mx-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create New Repo</div>
                <div class="card-body">
                  <form method="POST" action="{{ route('create.repo') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Description</label>
                            <div class="col-md-6">
                                <input id="password" type="text" class="form-control @error('description') is-invalid @enderror" name="description"  value="{{ old('description') }}" required autocomplete="current-password">
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Your Repo</div>
                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Url</th>
                        <th scope="col">Local Action</th>
                        <th scope="col">Github Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($repos as $repo)
                       <tr>
                          <td width="10%">{{ $repo['id'] }}</td>
                          <td width="15%">{{ $repo['name'] }}</td>
                          <td width="20%">{{ $repo['clone_url'] }}</td>
                          <td width="10%">
                            @if (isset($repo['db_row']))
                                @if(!$repo['db_row']['cloned'])
                                  <a class="btn btn-primary btn-sm" href="{{route('clone.repo',['id'=>$repo['db_row']['id']])}}" role="button">Clone</a>
                                @else
                                  <a class="btn btn-primary btn-sm" href="{{route('view.repo',['id'=>$repo['db_row']['id']])}}" role="button">View</a>
                                  <a class="btn btn-primary btn-sm" href="{{route('view.repo.commits',['id'=>$repo['db_row']['id']])}}" role="button">Commits List</a>
                                @endif
                            @endif
                          </td>
                          <td width="15%">
                            <form method="POST" action="{{ route('clone.repo-github') }}">
                                  @csrf
                                  <input type="hidden" name="name" value="{{ $repo['name'] }}">
                                  <input type="hidden" name="url" value="{{ $repo['clone_url'] }}">
                                  <input type="hidden" name="git_res" value="{{ json_encode($repo) }}">
                                  <button class="btn btn-primary btn-sm" type="submit">Clone On GitHub</button>
                                  <a class="btn btn-danger btn-sm" href="{{route('remove.repo-github',['name'=>$repo['name']])}}" role="button">Delete On GitHub</a>
                            </form>
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
