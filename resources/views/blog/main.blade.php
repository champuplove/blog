@extends('layout.main')
@section('header')
    <style type="text/css">
        .panel-body {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection

@section('content')
    <h2 class="form-signin-heading">Home</h2>
    @if(Auth::check())
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" onclick="window.location.href='/blog/create'">
                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Create
            </button>
        </div>
        <br><br>
    @endif
    @foreach ($blogs as $blog)
        <div class="panel panel-info">
            <div class="panel-body">
                <b>Title:</b>
                <a href="/blog/{{$blog->id}}">{{$blog->title}}</a>
            </div>
            <div class="panel-footer">
                <div class="col-md-10" align="left">
                    <b>Post By:</b>{{$blog->user->name}}
                    <b>Created on:</b>{{$blog->created_at}}{{$blog->comment->count()}}
                    <b>Last updated:</b>{{$blog->updated_at}}
                </div>
                <div align="right">
                    <b>Comment:</b>{{$blog->comment->count()}}
                    @if(Auth::check() && $blog->user->id == Auth::User()->id)
                        <form id="delete{{$blog->id}}" method="post" action="/blog/{{$blog->id}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
                            <a href="/blog/{{$blog->id}}/edit">
                                <span class="glyphicon glyphicon-edit" aria-hidden="true">Edit</span>
                            </a>
                            &nbsp;/&nbsp;
                            <a href="#" onclick="return checkDelete('{{$blog->id}}')">
                                <span class="glyphicon glyphicon-trash" aria-hidden="true">Delete</span>
                            </a>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    <div class="col-md-12" align="right">
        {{ $blogs->links() }}
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        function checkDelete($id) {
            if (confirm('Are you sure?')) {
                document.getElementById('delete' + $id).submit();
            }
        }
    </script>
@endsection