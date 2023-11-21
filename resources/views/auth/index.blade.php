@extends('template.AuthBase')
@push('styles')
    <style>
        .form-group {
            display: flex;
            align-items: center;
            position: relative;
        }

        .field-icon {
            cursor: pointer;
            position: absolute;
            right: 10px;
            /* Adjust the right position as needed */
            top: 50%;
            transform: translateY(-50%);
            /* Centers the icon vertically */
            z-index: 10;
        }
    </style>
@endpush
@section('auth')
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">LPM Smart System</h1>
                                </div>
                                @include('partials.session')
                                <form action="{{ url('proses') }}" class="user" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                            aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email"
                                            required>
                                    </div>
                                    <div class="form-group d-flex align-items-center">
                                        <input type="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password" name="password" required>
                                        <span toggle="#exampleInputPassword"
                                            class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
@push('scripts')
    <script>
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
@endpush
