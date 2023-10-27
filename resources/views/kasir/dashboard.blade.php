<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    @extends('layouts.master')

@section('title')
    <b> Dashboard</b>
@endsection


@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body text-center bg-primary">
                <h4 style="font-family: monospace">Selamat Datang</h4>
                <h4 style="font-family: monospace">Anda Login Sebagai Kasir</h4>
            </div>
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-primary justify-content-center">
            <div class="inner">
                <h3>{{ $member }}</h3>
                
                <p>Total Member</p>
            </div>
            <div class="icon">
                <i class="fa fa-id-card"></i>
            </div>
            <a href="{{ route('member.index') }}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div> --}}

@endsection

</body>
</html>