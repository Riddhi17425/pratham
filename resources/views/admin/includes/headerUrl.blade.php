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
        :root { --brand: #3d3287; --brand-dark: #29215f; --brand-light: #eeeafd; --brand-blue: #2457a6; --ink: #202033; --muted: #73758a; --canvas: #f6f7fb; }
        body { background: var(--canvas); color: var(--ink); }
        .sidebar { position: fixed; top: 0; bottom: 0; left: 0; width: 258px; background: linear-gradient(165deg, #342a78 0%, #231d55 100%); color: #dedcf4;
                   transform: translateX(-100%); transition: transform .2s; z-index: 1040; overflow-y: auto; box-shadow: 8px 0 28px #28205a20; }
        .sidebar .brand { display: block; padding: 1.25rem 1.4rem; font-size: 1.35rem; font-weight: 750; letter-spacing: .02em; color: #fff; text-decoration: none; border-bottom: 1px solid #ffffff20; }
        .sidebar .brand i { color: #a9c9ff; }
        .sidebar .m-link { display: flex; gap: .8rem; align-items: center; margin: .18rem .8rem; padding: .72rem .85rem; border-radius: .65rem; color: #dedcf4; text-decoration: none; transition: background .18s, color .18s; }
        .sidebar .m-link i { width: 1.25rem; font-size: 1.05rem; text-align: center; color: #b5b3dc; }
        .sidebar .m-link:hover { background: #ffffff13; color: #fff; }
        .sidebar .m-link.active { background: linear-gradient(100deg, #6558bd, #5145a3); color: #fff; box-shadow: 0 6px 16px #17133c45; }
        .sidebar .m-link.active i { color: #fff; }
        .sidebar .menu-title { padding: .9rem 1.4rem .3rem; font-size: .7rem; letter-spacing: .08em; text-transform: uppercase; color: #aaa7d0; }
        .main { min-height: 100vh; }
        .navbar { min-height: 76px; border-bottom: 1px solid #e9e9f1; }
        .navbar .dropdown-toggle > i { color: var(--brand); }
        .main > .p-3, .main > .p-lg-4 { max-width: 1600px; }
        .card { border-radius: .9rem; box-shadow: 0 5px 20px #28205a0a !important; }
        .card-header { padding: 1rem 1.25rem; border-bottom-color: #eeeef4; border-radius: .9rem .9rem 0 0 !important; }
        .btn-primary, .btn-dark { --bs-btn-bg: var(--brand); --bs-btn-border-color: var(--brand); --bs-btn-hover-bg: var(--brand-dark); --bs-btn-hover-border-color: var(--brand-dark); --bs-btn-active-bg: var(--brand-dark); --bs-btn-active-border-color: var(--brand-dark); }
        .btn-outline-primary { --bs-btn-color: var(--brand); --bs-btn-border-color: var(--brand); --bs-btn-hover-bg: var(--brand); --bs-btn-hover-border-color: var(--brand); --bs-btn-active-bg: var(--brand); --bs-btn-active-border-color: var(--brand); }
        .text-primary { color: var(--brand) !important; }
        .bg-primary { background-color: var(--brand) !important; }
        .form-control:focus, .form-select:focus, .form-check-input:focus { border-color: #8177c6; box-shadow: 0 0 0 .2rem #3d32871c; }
        .form-check-input:checked { background-color: var(--brand); border-color: var(--brand); }
        .table { --bs-table-hover-bg: #f7f6fd; }
        .table td, .table th { vertical-align: middle; }
        .table thead th { color: #696b80; font-size: .78rem; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; }
        .dropdown-menu { border-radius: .75rem; }
        @media (min-width: 992px) { .sidebar { transform: none; } .main { margin-left: 258px; } }
        body.sidebar-open .sidebar { transform: none; }
        body.sidebar-open::after { content: ''; position: fixed; inset: 0; z-index: 1030; background: #17152d66; }
        .dashboard-welcome { position: relative; overflow: hidden; padding: 1.6rem 1.8rem; color: #fff; border-radius: 1rem; background: linear-gradient(115deg, #3d3287, #5146a7 70%, #315eaa); }
        .dashboard-welcome::after { content: ''; position: absolute; width: 230px; height: 230px; right: 4%; top: -115px; border: 1px solid #ffffff25; border-radius: 50%; box-shadow: 0 0 0 28px #ffffff0b, 0 0 0 58px #ffffff09; }
        .stat-card { border: 1px solid #eeedf5; }
        .stat-icon { display: grid; place-items: center; width: 3rem; height: 3rem; border-radius: .85rem; background: var(--brand-light); color: var(--brand); font-size: 1.3rem; }
        .login-page { background: radial-gradient(ellipse at top right, #e8e5fa 0, transparent 42%), var(--canvas); }
        .login-card { border-top: 4px solid var(--brand) !important; }
        @media (min-width: 992px) { body.sidebar-open::after { display: none; } }
    </style>
    @stack('styles') 
</head>
<body>
