<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link rel="stylesheet" href="/css/chinamax.css"/>

    <link href={{ asset('css/jquery.nice-number.css') }} rel="stylesheet">
	<script src={{ asset('js/jquery.nice-number.js') }}></script>

    <style>
        .footer-dark {
            padding:50px 0;
            color:#f0f9ff;
            background-color:#282d32;
        }

        .footer-dark h3 {
            margin-top:0;
            margin-bottom:12px;
            font-weight:bold;
            font-size:16px;
        }

        .footer-dark ul {
            padding:0;
            list-style:none;
            line-height:1.6;
            font-size:14px;
            margin-bottom:0;
        }

        .footer-dark ul a {
            color:inherit;
            text-decoration:none;
            opacity:0.6;
        }

        .footer-dark ul a:hover {
            opacity:0.8;
        }

        @media (max-width:767px) {
            .footer-dark .item:not(.social) {
                text-align:center;
                padding-bottom:20px;
            }
        }

        .footer-dark .item.text {
            margin-bottom:36px;
        }

        @media (max-width:767px) {
            .footer-dark .item.text {
                margin-bottom:0;
            }
        }

        .footer-dark .item.text p {
            opacity:0.6;
            margin-bottom:0;
        }

        .footer-dark .item.social {
            text-align:center;
        }

        @media (max-width:991px) {
            .footer-dark .item.social {
                text-align:center;
                margin-top:20px;
            }
        }

        .footer-dark .item.social > a {
            font-size:20px;
            width:36px;
            height:36px;
            line-height:36px;
            display:inline-block;
            text-align:center;
            border-radius:50%;
            box-shadow:0 0 0 1px rgba(255,255,255,0.4);
            margin:0 8px;
            color:#fff;
            opacity:0.75;
        }

        .footer-dark .item.social > a:hover {
            opacity:0.9;
        }

        .footer-dark .copyright {
            text-align:center;
            padding-top:24px;
            opacity:0.3;
            font-size:13px;
            margin-bottom:0;
        }

        #carouselExampleCaptions {
            height: 300px;
            width: 500px
        }

        .trend-product {
            float: left;
            width: 16%;
        }
        .trend-wraper {
            margin: 80px;
        }

        #cart_count {
            text-align: center;
            padding: 0 0.9rem 0.1rem 0.9rem;
            border-radius: 3rem;
            border-style: solid;
        }

        .box input {
            border:1px solid gray;
            outline: none;
            padding: 6px 10px;
            border-radius: 5px;
            margin: 0 5px !important;
        }
        .box button {
            background-color: #e6e6e6;
            color: black;
            font-size: 20px;
            font-weight: 900;
            border: 1px solid gray;
            outline: none;
            padding: 8px 16px;
            border-radius: 50%;
        }

    </style>
</head>
<body>
    {{ View::make('layouts.header') }}
    @yield('content')
    {{ View::make('layouts.footer') }}
</body>
</html>