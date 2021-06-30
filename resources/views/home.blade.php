@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                {{-- <div class="card-header">{{ __('Navigate') }}</div> --}}
                <img src="https://images.pexels.com/photos/380769/pexels-photo-380769.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" class="card-img-top" alt="Manage Company">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h5 class="card-title">Manage Companies</h5>
                    <a class="btn btn-primary" href="{{ route('companies.index') }}" >Go</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                {{-- <div class="card-header">{{ __('Navigate') }}</div> --}}
                <img src="https://images.pexels.com/photos/380769/pexels-photo-380769.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" class="card-img-top" alt="Manage Company">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h5 class="card-title">Manage Employees</h5>
                    <a class="btn btn-primary" href="{{ route('employees.index') }}">Go</a>
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
