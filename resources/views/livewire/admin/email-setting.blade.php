@section('title', 'Email Settings')
<div>
    <div class="row">
        <div class="col-md-6">
            <div class="common-card card">
                <h5 class="card-header fw-bold">Email Gateway</h5>
                <div class="card-body">
                    <div class="form-group">
                        <label>Email Gateway</label>
                        <select wire:model="email_gateway" class="form-select common-input border">
                            <option value="php">PHP Mail</option>
                            <option value="smtp">SMTP</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="common-card card">
                <div class="card-body">
                    <form wire:submit.prevent="updateSettings">
                        @foreach ($settings as $key => $value)
                            <div class="form-group mb-3">
                                <label class="form-label">{{ str_replace('_', ' ', $key) }}</label>
                                <input type="{{ str_contains($key, 'PASSWORD') ? 'password' : 'text' }}"
                                    wire:model.defer="settings.{{ $key }}"
                                    class="common-input border"
                                    placeholder="{{ $key }}">
                            </div>
                        @endforeach
                        <div class="form-group mb-0">
                            <button class="btn btn-main w-100" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="common-card card">
                <h5 class="card-header fw-bold">Test Email</h5>
                <div class="card-body pb-1">
                    <form wire:submit.prevent="sendTestEmail" class="mb-3">
                        <div class="form-group mb-2">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" wire:model.defer="test_email" class="common-input border" required id="email">
                            @error('test_email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success text-end">Send Test Email</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="common-card card">
                <h4 class="card-header py-2">Instructions</h4>
                <div class="card-body">
                    <b>For Non-SSL:</b>
                    <ul class="list-group">
                        <li class="list-group-item">Set Mail Host according to your server’s Mail Client Manual Settings</li>
                        <li class="list-group-item">Set Mail Port as <code>587</code></li>
                        <li class="list-group-item">Set Mail Encryption as <code>tls</code> or <code>ssl</code> if tls fails</li>
                    </ul>
                    <br>
                    <b>For SSL:</b>
                    <ul class="list-group">
                        <li class="list-group-item">Set Mail Host according to your server’s Mail Client Manual Settings</li>
                        <li class="list-group-item">Set Mail Port as <code>465</code></li>
                        <li class="list-group-item">Set Mail Encryption as <code>ssl</code></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>



@include('layouts.meta')
