<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · Order Desk</title>
    <style>
        :root {
            --ink: #1d2733;
            --muted: #5d6b7a;
            --line: #d9e0e6;
            --surface: #f5f7f9;
            --accent: #1f5f8b;
            --accent-ink: #ffffff;
            --ok-bg: #e6f4ea;
            --ok-ink: #1e6b3a;
            --err-bg: #fbe9e7;
            --err-ink: #9b2c1f;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif; color: var(--ink); background: var(--surface); font-size: 15px; line-height: 1.5; }
        header { background: var(--ink); color: #fff; }
        .bar { max-width: 1040px; margin: 0 auto; padding: 0.75rem 1.25rem; display: flex; flex-wrap: wrap; align-items: center; gap: 1.5rem; }
        .brand { font-weight: 700; font-size: 1.1rem; }
        nav { display: flex; gap: 1.1rem; flex: 1; }
        nav a { color: #c9d4de; text-decoration: none; }
        nav a:hover, nav a.active { color: #fff; }
        .switcher { display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; color: #c9d4de; margin: 0; }
        .switcher select { font: inherit; padding: 0.25rem 0.4rem; border-radius: 4px; border: 1px solid #47586a; background: #2b3846; color: #fff; }
        main { max-width: 1040px; margin: 0 auto; padding: 1.5rem 1.25rem 3rem; }
        h1 { font-size: 1.5rem; margin: 0 0 1rem; }
        .panel { background: #fff; border: 1px solid var(--line); border-radius: 6px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 0.65rem 0.9rem; text-align: left; border-bottom: 1px solid var(--line); vertical-align: middle; }
        th { font-size: 0.85rem; color: var(--muted); font-weight: 600; background: #fbfcfd; }
        tr:last-child td { border-bottom: 0; }
        td.num, th.num { text-align: right; white-space: nowrap; }
        .sku { color: var(--muted); font-size: 0.85rem; }
        input[type=number] { width: 4.5rem; padding: 0.3rem 0.4rem; font: inherit; border: 1px solid var(--line); border-radius: 4px; }
        select { font: inherit; padding: 0.3rem 0.4rem; border: 1px solid var(--line); border-radius: 4px; }
        button { font: inherit; padding: 0.35rem 0.8rem; border-radius: 4px; border: 1px solid var(--accent); background: var(--accent); color: var(--accent-ink); cursor: pointer; }
        button.secondary { background: #fff; color: var(--accent); }
        button.danger { background: #fff; color: var(--err-ink); border-color: #e3b5ae; }
        button:focus-visible, a:focus-visible, select:focus-visible, input:focus-visible { outline: 2px solid #f2b705; outline-offset: 2px; }
        .inline { display: inline-flex; gap: 0.4rem; align-items: center; margin: 0; }
        .flash { padding: 0.65rem 0.9rem; border-radius: 6px; margin-bottom: 1rem; }
        .flash.ok { background: var(--ok-bg); color: var(--ok-ink); }
        .flash.err { background: var(--err-bg); color: var(--err-ink); }
        .flash ul { margin: 0; padding-left: 1.1rem; }
        .summary { display: flex; justify-content: flex-end; align-items: center; gap: 1.25rem; padding: 1rem 0.9rem; border-top: 1px solid var(--line); margin: 0; }
        .summary strong { font-size: 1.15rem; }
        .status { display: inline-block; padding: 0.1rem 0.55rem; border-radius: 999px; font-size: 0.82rem; font-weight: 600; }
        .status-pending { background: #fff4d6; color: #7a5a00; }
        .status-completed { background: var(--ok-bg); color: var(--ok-ink); }
        .status-cancelled { background: #eceff2; color: var(--muted); }
        .toolbar { display: flex; justify-content: space-between; align-items: center; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap; }
        .toolbar h1 { margin: 0; }
        .empty { padding: 2rem; text-align: center; color: var(--muted); margin: 0; }
        .meta { color: var(--muted); margin: 0 0 1rem; }
        a { color: var(--accent); }
    </style>
</head>
<body>
<header>
    <div class="bar">
        <span class="brand">Order Desk</span>
        <nav>
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
            <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}">Cart ({{ $cartCount }})</a>
            <a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">My orders</a>
        </nav>
        <form method="POST" action="{{ route('user.switch') }}" class="switcher">
            @csrf
            <label for="user_id">Signed in as</label>
            <select id="user_id" name="user_id" onchange="this.form.submit()">
                @foreach ($switchableUsers as $user)
                    <option value="{{ $user->id }}" @selected($user->id === $currentUser->id)>{{ $user->name }}</option>
                @endforeach
            </select>
            <noscript><button type="submit" class="secondary">Switch</button></noscript>
        </form>
    </div>
</header>
<main>
    @if (session('status'))
        <div class="flash ok" role="status">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="flash err" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>
</body>
</html>
