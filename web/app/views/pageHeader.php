<!DOCTYPE html>
<html lang="zh_CN">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Bootstrap Icon CSS -->
    <link href="/icon/bootstrap-icons.css" rel="stylesheet">

    <!-- App CSS -->
    <link href="/css/app.css" rel="stylesheet">

    <title><?= $pageTitle ?></title>
</head>
<body>
        
    <header class="py-3 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
            <a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
                <img src="/images/logo.svg" style="height: 40px;">
            </a>
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="#" class="nav-link link-dark">登录</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark">注册</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark">我的 12307</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark">About</a></li>
            </ul>
        </div>
    </header>
    <nav class="py-0 mb-0" style="background: #3B99FC;">
        <div class="container d-flex flex-wrap">
            <ul class="nav me-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-primary link-light px-5 bg-primary">首页</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-primary link-light px-5">购买车票</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-primary link-light px-5">订单信息</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-primary link-light px-5">车次查询</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-primary link-light px-5">旅行指南</a>
                </li>
            </ul>
            <ul class="nav">
                <li class="nav-item">
                    <a href="#" class="nav-link nav-link-primary link-light px-5">管理界面</a>
                </li>
            </ul>
        </div>
    </nav>
