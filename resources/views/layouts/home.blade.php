@extends('index')

@section('title', 'Inicio')

@section('main-content')
    @livewire('home')
@push('scripts')
<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/dashboard-sale.js') }}"></script>
@endpush
@endsection