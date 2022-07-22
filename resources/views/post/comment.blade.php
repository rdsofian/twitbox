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
                    {{$post->user->name}}
                    <span class="float-right"> {{ date('d-M-Y', strtotime($post->created_at)) }}</span>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">{{ $post->content }}</li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="col-md-10 float-right">
            <div class="card">
                <div class="card-header">Komentar Anda</div>

                <div class="card-body">

                <form action="{{ route('post.post-comment') }}" method="post" class="form">
                        @csrf
                        <div class="form-group">
                            <label for="">Komentar</label>
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                            <textarea name="content" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Tags</label>
                            <input type="text" name="tags" class="form-control"> Pisahkan Tag oleh Koma
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Komentari" class="btn btn-success float-right">
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
