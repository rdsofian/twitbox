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
                <div class="card-header">Posting Sesuatu</div>

                <div class="card-body">
                    <form action="{{ route('post.store') }}" method="post" class="form">
                        @csrf
                        <div class="form-group">
                            <label for="">Posting</label>
                            <textarea name="content" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Tags</label>
                            <input type="text" name="tags" class="form-control"> Pisahkan Tag oleh Koma
                        </div>
                        <div class="form-group">
                            <input type="file" name="photo" class="form-controll">
                            <input type="submit" value="Post" class="btn btn-success float-right">
                        </div>
                    </form>
                </div>
            </div>

            <div class="pt-4">
                <form action="" method="post">
                    <div class="float-right">
                        <label for="">Filter</label>
                        <input type="text" name="filter" >
                    </div>
                </form>
            </div>

            <div class="pt-5 mt-5">
                <div class="card">
                    @foreach ($posts as $post)
                        <div class="card-body" style="background: #D9D9D9">
                            {{ $post->user->name }}
                            <span class="float-right"> {{ date('d-M-Y', strtotime($post->created_at)) }}</span>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    {{ $post->content }}
                                </li>
                                @if (Auth::user()->id == $post->user_id)
                                    <li class="list-group-item">
                                        <a href="{{ route('post.edit', $post->id) }}" class="float-right"> Edit </a>
                                    </li>
                                @endif
                            </ul>
                            <div class="float-left pt-2"> <a href="{{ route('post.show', $post->id) }}"> {{ count($post->comments) . " Komentar" }} </a> </div>
                            <div class="float-right pt-2">

                                    <form action="{{ route('post.destroy', $post->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        @if (Auth::user()->id == $post->user_id)
                                            <input type="submit" value="Hapus" class="btn btn-danger">
                                        @endif
                                        <a href="{{ route('post.comment', $post->id) }}" class="btn btn-primary">Balas</a>
                                    </form>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
