<span class="mt-1"></span>

@if (count($errors) > 0)
    <div class="container-fluid">
        <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <ul class="text-left {{ count($errors) == 1 ? 'list-unstyled' : '' }}">
                @foreach ($errors->all() as $error)
                    <li><b>{{ $error }}</b></li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if (Session::get('success'))
    <div class="container-fluid">
        <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if (Session::get('status'))
    <div class="container-fluid">
        <div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
            {{ Session::get('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if (Session::get('error'))
    <div class="container-fluid">
        <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
<span class="mb-1"></span>
