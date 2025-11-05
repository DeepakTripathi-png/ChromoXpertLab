<!DOCTYPE html>
<html lang="en">
    <head>
        @include('Front.partials.head')
    </head>
    <body class="bg-gray-100 flex flex-col min-h-screen">

        @include('Front.partials.header')

        <!-- Main Page Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        @include('Front.partials.footer')

        @include('Front.partials.homescripts')
        @stack('scripts')
    </body>
</html>