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

                <div class="card-header">Postingan #{{$post->user->name}}</div>
                <div class="card-body" style="background: #D9D9D9">
                    {{$post->user->name}}
                    <span class="float-right"> {{ date('d-M-Y', strtotime($post->created_at)) }}</span>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">{{ $post->content }}</li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="col-md-12 pl-5">
            <div class="card">

                @foreach ($post->comments as $comment)
                    <div class="card-body" style="background: #D9D9D9">
                        {{ $post->user->name }}
                        <span class="float-right"> {{ date('d-M-Y', strtotime($comment->created_at)) }}</span>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">{{ $comment->content }}</li>
                            @if (Auth::user()->id == $comment->user_id)
                            <li class="list-group-item">
                                <a href="{{ route('comment.edit', $comment->id) }}" class="float-right"> Edit </a>
                            </li>
                        @endif
                        </ul>

                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection
