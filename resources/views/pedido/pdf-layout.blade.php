<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }
        @page {
            margin: 10px 15px;
        }
        body{
            font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif;
            margin: 60px 50px;
            font-size: 0.7em;
        }
        .table{
            width: 100%;
            border-collapse: collapse
        }
        .table-striped tbody tr:nth-child(odd) td, .table-striped tbody tr:nth-child(odd) th {
            background-color: #efefef;
        }
        .table-striped tbody tr:nth-child(even) td, .table-striped tbody tr:nth-child(even) th {
            background-color: #fff;
        }
        .width-to-content {
            width:1px;
            white-space:nowrap;
            padding-right: 20px;
        }
        .table-border, .table-border th, .table-border td {
            border: 1px solid black;
        }
        .mp-0 {
            margin: 0;
            padding: 0;
        }
        .table-padding td{
            padding: 5px 0;
        }
        .table-padding-mint td{
            padding: 1.5px;
        }
        .page_break { page-break-before: always; }
        @for($i = 1; $i <= 12; $i++)
        .col-md-{{ $i }}{
            width: {{ ($i*100)/12 }}%;
            padding: 0;
            margin: 0;
            float: left;
        }
        @endfor
        @for($i = 1; $i <= 100; $i++)
        .m-{{ $i }}{
            margin: {{ $i }}px;
        }
        .mt-{{ $i }}{
            margin-top: {{ $i }}px;
        }
        .mb-{{ $i }}{
            margin-bottom: {{ $i }}px;
        }
        .ml-{{ $i }}{
            margin-left: {{ $i }}px;
        }
        .mr-{{ $i }}{
            margin-right: {{ $i }}px;
        }
        .mx-{{ $i }}{
            margin-left: {{ $i }}px;
            margin-right: {{ $i }}px;
        }
        .my-{{ $i }}{
            margin-top: {{ $i }}px;
            margin-bottom: {{ $i }}px;
        }
        .p-{{ $i }}{
            padding: {{ $i }}px;
        }
        .pt-{{ $i }}{
            padding-top: {{ $i }}px;
        }
        .pb-{{ $i }}{
            padding-bottom: {{ $i }}px;
        }
        .pl-{{ $i }}{
            padding-left: {{ $i }}px;
        }
        .pr-{{ $i }}{
            padding-right: {{ $i }}px;
        }
        .px-{{ $i }}{
            padding-left: {{ $i }}px;
            padding-right: {{ $i }}px;
        }
        .py-{{ $i }}{
            padding-top: {{ $i }}px;
            padding-bottom: {{ $i }}px;
        }
        @endfor
        .clearfix:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;
        }
        .clearfix { display: inline-table; }
        .item-title {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 30px;
        }
        .divider-space {
            padding-top: 20px;
        }
        .td-title-tight {
            white-space: nowrap;
            width: 1px;
            padding-right: 5px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .nowrap {
            white-space: nowrap;
        }
        .text-left {
            text-align: left;
        }
        .clearfix:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;
        }
        .clearfix { display: inline-table; }
        .item-title {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 30px;
        }
        .divider-space {
            padding-top: 20px;
        }
        .td-title-tight {
            white-space: nowrap;
            width: 1px;
            padding-right: 5px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .nowrap {
            white-space: nowrap;
        }
        .text-left {
            text-align: left;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>