@extends('layouts.invoice')

@section('title', 'License Certificate')

@section('content')
    <div class="col-lg-7 m-auto">
        <div class="card border-0 shadow-none">
            <div class="card-body p-5">
                <div>
                    <div class="mb-4">
                        <img src="{{ my_asset($settings->logo) }}" style="height: 60px;" alt="{{ $settings->name }}">
                    </div>
                    <h1 class="mb-3">License certificate</h1>
                    <div class="mb-3">
                        <p class="mb-0">
                            This document certifies the purchase of the following license:
                            <strong>{{ strtoupper($item->license_type) }} LICENSE</strong>.
                        </p>
                        <p class="mb-0">
                            Details of the license can be accessed from your workspace purchases page.
                        </p>
                    </div>
                </div>
                <div class="my-3 py-3 border-bottom border-top">
                    <p>
                        <strong>Licensor's:</strong>
                        {{ $settings->name }}
                    </p>
                    <p><strong>Licensee:</strong> {{ $order->name }}</p>
                    <p><strong>Item ID:</strong> {{ $item->product->uid ?? '' }}</p>
                    <p><strong>Item Name:</strong> {{ $item->product->name ?? '' }}</p>
                    <p><strong>Item URL:</strong>
                        <a href="{{ route('products.view', $item->product->slug) }}">{{ route('products.view', $item->product->slug) }}</a>
                    </p>
                    <p><strong>Item Purchase Code:</strong> {{ $item->license_code }}</p>
                    <p class="mb-0"><strong>Purchase Date:</strong>{{ show_datetime($item->created_at) }}</p>
                </div>
                <div class="mb-4">
                    <p>For any queries related to this document or licenses please contact us via
                        <a href="{{ route('contact') }}">{{ route('contact') }}</a>
                    </p>
                    <p>{{ $settings->name }}</p>
                </div>
                <div class="mt-auto text-center">
                    <button class="btn btn-primary print-btn btn-md fw-medium" onclick="window.print()">
                        <i class="fa-solid fa-print me-2"></i>
                        Print
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('styles')
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 0;
            }

            .col-lg-7 {
                width: 100%;
            }

            .m-auto {
                margin: 0 !important;
            }

            .btn {
                display: none;
            }
        }
    </style>
@endsection

@include('layouts.meta')
