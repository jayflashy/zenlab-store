
<script src="{{ static_asset('js/vendors.js') }}"></script>
<script src="{{ static_asset('js/custom.js') }}"></script>
<script src="{{ static_asset('js/marquee.min.js') }}"></script>
<script src="{{ static_asset('js/main.js') }}"></script>
{{-- @livewireScripts() --}}
<script src="{{ asset('public/vendor/livewire/livewire.js') }}" data-csrf="{{ csrf_token() }}"
    data-update-uri="{{ url('livewire/update') }}" data-navigate-once="true"></script>

    <script src="{{static_asset('summernote/summernote-lite.min.js')}}"></script>
@stack('scripts')
@yield('scripts')

@include('inc.scripts')
