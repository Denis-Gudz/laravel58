<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
    <script src="{{ asset('js/vue-router.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/menu.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">

        <v-toolbar dark color="primary" fixed z-index>

            <v-toolbar-items class="hidden-sm-and-down">
                <v-btn flat href="{{ route('shop.admin.categories.index') }}">Категории</v-btn>
                <v-btn flat href="{{ route('shop.admin.items.index') }}" >Товары</v-btn>
                <v-btn flat href="{{ route('shop.items.index') }}">Каталог товаров</v-btn>
            </v-toolbar-items>

            <v-spacer></v-spacer>

            @yield('navbar')

        </v-toolbar>

        <main class="py-5">
            @yield('content')
        </main>
    </div>
</body>
</html>
