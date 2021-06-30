@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Navigate') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('companies.index') }}" >Manage Companies Data</a>

                    <a href="{{ route('employees.index') }}">Manage Employees Data</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- <script>
    window.onload = function() {
    if (window.jQuery) {
        // jQuery is loaded
        console.log("Jquery works!");
    } else {
        // jQuery is not loaded
        console.log("Jquery doesn't works!");
    }

    var resp = $.ajax({});

    console.log('resp',resp);
}
</script> --}}
