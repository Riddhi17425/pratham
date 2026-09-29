<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') | Pratham</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Abhi Bootstrap CDN par chal raha hai. Baad me eBazar template ki CSS yahin lagegi. --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #f4f6fa; }
        .sidebar { position: fixed; top: 0; bottom: 0; left: 0; width: 250px; background: #111827; color: #cbd5e1;
                   transform: translateX(-100%); transition: transform .2s; z-index: 1040; overflow-y: auto; }
        .sidebar .brand { display: block; padding: 1.1rem 1.4rem; font-size: 1.3rem; font-weight: 700; color: #fff; text-decoration: none; border-bottom: 1px solid #1f2937; }
        .sidebar .m-link { display: flex; gap: .7rem; align-items: center; padding: .7rem 1.4rem; color: #cbd5e1; text-decoration: none; }
        .sidebar .m-link:hover { background: #1f2937; color: #fff; }
        .sidebar .m-link.active { background: #2563eb; color: #fff; }
        .sidebar .menu-title { padding: .9rem 1.4rem .3rem; font-size: .7rem; letter-spacing: .08em; text-transform: uppercase; color: #64748b; }
        .main { min-height: 100vh; }
        @media (min-width: 992px) { .sidebar { transform: none; } .main { margin-left: 250px; } }
        body.sidebar-open .sidebar { transform: none; }
        .table td, .table th { vertical-align: middle; }
    </style>
    @stack('styles') 
</head>
<body>
