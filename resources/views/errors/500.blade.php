@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="title">Something went wrong.</div>
    @unless(empty($sentryID))
        <!-- Sentry JS SDK 2.1.+ required -->
            <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

            <script>
                Raven.showReportDialog({
                    eventId: '{{ $sentryID }}',

                    // use the public DSN (dont include your secret!)
                    dsn: 'https://66897948cc724d18912b71aec5edb75b@sentry.io/170881'
                });
            </script>
        @endunless
    </div>
@endsection