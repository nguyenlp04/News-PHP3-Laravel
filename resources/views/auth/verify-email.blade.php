<!-- Đảm bảo rằng bạn đã bao gồm Bootstrap CSS trong dự án của bạn -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<style>
    .custom-card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .custom-card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .custom-card-body {
        padding: 2rem;
    }
    .custom-button {
        border-radius: 25px;
    }
    .custom-alert {
        border-radius: 15px;
        padding: 1rem;
    }
</style>

<x-guest-layout>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        {{ __('Hello, :name', ['name' => Auth::user()->name]) }}
                    </div>
                    <div class="card-body">
                        <p class="mb-4 text-gray-600">
                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                        </p>

                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success mb-4">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif

                        <div class="d-flex flex-column align-items-center">
                            <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Resend Verification Email') }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
