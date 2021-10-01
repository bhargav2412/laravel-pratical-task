@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('error') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table table-striped">
                    <thead>
                        <th width="10%">No.</th>
                        <th width="40%">Title</th>
                        <th width="40%">Action</th>
                    </thead>
                    <tbody>
                        @foreach ($posts as $key => $post)
                            <tr>
                                <td> {{ ++$key }} </td>
                                <td>{{ ucfirst(trans($post->title)) }}</td>
                                <td>
                                    <a href="{{ route('post.show', $post->id) }}" class="btn btn-success">Show Post</a>
                                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">Edit Post</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
