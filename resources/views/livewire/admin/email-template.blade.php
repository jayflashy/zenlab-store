@section('title', $title)
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">{{ $title }}</h1>
            <p class="text-muted small">Manage Notification Templates</p>
        </div>
        @if ($view === 'edit')
            <div>
                <a wire:navigate href="{{ route('admin.email.templates') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>
        @endif
    </div>
    {{-- List View --}}
    @if ($view === 'list')
        {{-- Search & Filter --}}
        <div class="common-card card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <input type="text" class="common-input border" placeholder="Search templates..."
                            wire:model.live.debounce.300ms="search">
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <div class="d-flexs align-items-center">
                            {{-- <label for="per-page" class="me-2 form-label mb-0">Show</label> --}}
                            <div class="select-has-icon">
                                <select wire:model.live="perPage" id="per-page" class="common-input border">
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- templates --}}
        <div class="common-card card">
            <div class="card-body table-responsive">
                <table class="table style-two">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('name')" style="cursor: pointer;">
                                Name
                                @if ($sortField === 'name')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </th>
                            <th>Type</th>
                            <th>@lang('Subject')</th>
                            <th wire:click="sortBy('email_status')" style="cursor: pointer;">Status
                                @if ($sortField === 'email_status')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ms-1"></i>
                                @endif
                            </th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($templates as $template)
                            <tr>
                                <td>{{ $template->name }}</td>
                                <td>{{ $template->type }}</td>
                                <td>{{ $template->subject }}</td>
                                <td>
                                    @if ($template->email_status == 1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-main" wire:navigate
                                        href="{{ route('admin.email.templates.edit', $template->id) }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">No Email Template was found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $templates->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-4">
                <div class="common-card card">
                    <div class="card-body table-responsive">
                        <table class="style-two table table-sm">
                            <thead>
                                <tr>
                                    <th>Short Code</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @forelse($shortcodes as $shortcode => $key)
                                    <tr>
                                        <td>@php echo "{". $shortcode ."}"  @endphp</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-muted text-center">@lang('No shortcode available')</td>
                                    </tr>
                                @endforelse
                            </tbody>

                            <tbody class="list">
                                @foreach ($settings->shortcodes as $shortcode => $key)
                                    <tr>
                                        <td>@php echo "{". $shortcode ."}"  @endphp</td>
                                        <td>{{ $key }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="common-card card">
                    <div class="card-header">
                        <h5 class="fw-bold">{{ $name }}</h5>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="save">
                            @csrf
                            <div class="form-group">
                                <label class="fw-bold my-auto">@lang('Status')</label>
                                <br>
                                <label class="jdv-switch jdv-switch-success">
                                    <input type="checkbox" name="email_status" value="1" wire:model="email_status"
                                        @if ($email_status == 1) checked @endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="fw-bold">Email Subject <span class="text-danger">*</span></label>
                                <input type="text" class="common-input border @error('subject') is-invalid @enderror"
                                    id="subject" wire:model="subject" placeholder="@lang('Email subject')">
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="fw-bold" for="summernote">Email Content <span
                                        class="text-danger">*</span></label>
                                <textarea wire:model.defer="content" class="common-input border @error('content') is-invalid @enderror" id="summernote"
                                    rows="10">{{ $content }}</textarea>

                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group text-end">

                                <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled">
                                    <i class="fas fa-save me-1"></i> Update Template
                                    <span wire:loading wire:target="save" class="spinner-border spinner-border-sm ms-1"
                                        role="status"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


@section('scripts')
    <script>
        $('#summernote').summernote({
            height: 500,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onChange: function(contents) {
                    @this.set('content', contents, false);
                }
            }
        });
    </script>
@endsection

@include('layouts.meta')
