@extends(config('settings.theme').'.layouts.admin')


@section('admin.sideBar')
    {!! $sideBar !!}
@endsection

@section('admin.header')
    {!! $header !!}
@endsection

@section('admin.content')
    {!! $content !!}
@endsection

@section('admin.footer')
    {!! $footer !!}
@endsection
