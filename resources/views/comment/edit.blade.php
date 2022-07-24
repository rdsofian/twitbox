@extends('layouts.app')

@section('content')
<div class="container">

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block m-5">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block m-5">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    @endif


    <div class="row justify-content-center">
        <div class="col-md-12 pb-3">
            <div class="card">
                <div class="card-body" style="background: #D9D9D9">
                    {{$comment->post->user->name}}
                    <span class="float-right"> {{ date('d-M-Y', strtotime($comment->post->created_at)) }}</span>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">{{ $comment->post->content }}</li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="col-md-12 pl-5">
            <div class="card">
                <div class="card-header">Komentar Anda</div>

                <div class="card-body">

                <form action="{{ route('comment.update', $comment->id) }}" method="post" class="form">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="">Komentar</label>
                            <textarea name="content" cols="30" rows="3" class="form-control">{{ $comment->content }}</textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Ubah Komentar" class="btn btn-success float-right">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
