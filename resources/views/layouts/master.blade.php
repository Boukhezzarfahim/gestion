<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Starter</title>


 
    <link rel="stylesheet" href="{{mix("css/app.css")}}" />

    <script src="{{ mix('js/app.js') }}"></script>

    @livewireStyles


</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <x-topnav />


        <x-menu />

        <div class="content-wrapper">



            <div class="content">
                <div class="container-fluid">
                    @yield('contenu')

                </div>
            </div>

        </div>


       <x-sidebar />

        @livewireScripts

</body>

</html>