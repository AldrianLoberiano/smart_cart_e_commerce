@extends('layouts.app')

@section('title', 'Too Many Requests - 429')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full text-center">
            <!-- Warning Icon -->
            <div class="mx-auto w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h1 class="text-5xl font-bold text-gray-900 mb-2">429</h1>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Too Many Requests</h2>

            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <p class="text-gray-600 mb-4">
                    {{ $message ?? 'You have made too many requests. Please slow down.' }}
                </p>

                @if (isset($retry_after))
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-sm text-yellow-800">
                            <strong>Please wait {{ $retry_after }} seconds before trying again.</strong>
                        </p>
                    </div>
                @endif
            </div>

            <a href="{{ route('home') }}" class="btn btn-primary w-full">
                Return to Home
            </a>
        </div>
    </div>
@endsection
