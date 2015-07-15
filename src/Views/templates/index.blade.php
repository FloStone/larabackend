@extends('Backend::master')
@section('content')
<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <style>
            html, body {
                height: 100%;
            }
            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }
            .container {
                text-align: center;
                vertical-align: middle;
                margin-top: 15%;
            }
            .content {
                text-align: center;
                display: inline-block;
            }
            .title {
                font-size: 96px;
                margin-bottom: 40px;
            }
            .quote {
                font-size: 24px;
            }
        </style>
    </head>
    <div class="container">
        <div class="content">
            <div class="title">Laravel 5 Backend</div>
            <div class="quote">{{ Inspiring::quote() }}</div>
        </div>
    </div>
</html>

@stop