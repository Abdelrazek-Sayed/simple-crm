<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
@include('layouts.partials.head')
@stack('styles')
@livewireStyles
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
@include('layouts.partials.navbar')

<!-- /.navbar -->

    <!-- Main Sidebar Container -->
@include('layouts.partials.sidebar')


<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{$slot}}
    </div>
    <!-- /.content-wrapper -->


    <!-- Main Footer -->

    @include('layouts.partials.footer')

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

@include('layouts.partials.scripts')
@stack('js')
{{-- sweetalert2 --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
{{--  alpinejs --}}
<script src="//unpkg.com/alpinejs" defer></script>
@livewireScripts
</body>
</html>
