@extends('layouts.app')

@section('content')
<div class="container">

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block m-5">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger m-3">
            <button type="button" class="close" data-dismiss="alert">×</button>
            Error
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block m-5">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Edit Postingan Anda</div>

                <div class="card-body">
                    <form action="{{ route('post.update', $post->id) }}" method="post" class="form">
                        @csrf
                        @method("PUT")
                        <div class="form-group">
                            <label for="">Posting</label>
                            <textarea name="content" cols="30" rows="3" class="form-control">{{ $post->content }}</textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Update" class="btn btn-success float-right">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
