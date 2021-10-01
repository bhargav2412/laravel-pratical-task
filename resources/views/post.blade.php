@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create Post</div>
                    <div class="card-body">

                        @php
                            if (@$post) {
                                $url = url('post/update/' . $post->id);
                            } else {
                                $url = url('post/store');
                            }
                        @endphp
                        <form method="post" action="{{ $url }}" enctype="multipart/form-data">
                            <div class="form-group">
                                @csrf
                                <label class="label">Post Title: </label>
                                <input type="text" name="title" class="form-control" value="{{ @$post->title }}" />
                                @if ($errors->has('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="label">Post Body: </label>
                                <textarea name="body" rows="10" cols="30"
                                    class="form-control">{{ @$post->body }}</textarea>
                                @if ($errors->has('body'))
                                    <span class="text-danger">{{ $errors->first('body') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="label">Post Media: </label>
                                <input type="file" name="post_media[]" class="form-control" multiple>
                                @if ($errors->has('post_media'))
                                    <span class="text-danger">{{ $errors->first('post_media') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <img src="{{ asset(@$post['postMedia']['media_name']) }}"
                                    style="height: 200px;width: 400px;">
                            </div>
                            <input type="hidden" name="old_image" value="{{ @$post['postMedia']['media_name'] }}">
                            <div class="form-group">
                                <input type="submit" class="btn btn-success" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
