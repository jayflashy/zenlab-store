@section('title', $metaTitle)
<div class="container">

    <div class="common-card card">
        <div class="card-header">
            <h5 class="fw-bold mb-0">Edit Profile</h5>
        </div>
        <div class="card-body">

            <form wire:submit.prevent="save">
                <div class="row gy-4">
                    <div class="col-sm-6">
                        <label for="name" class="form-label mb-2 font-18 font-heading fw-600">
                            Full Name
                        </label>
                        <input type="text" class="common-input border" id="name" wire:model="name" required
                            placeholder="Full Name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="username" class="form-label mb-2 font-18 font-heading fw-600">
                            Email
                        </label>
                        <input type="email" class="common-input border" id="email" wire:model="email"
                            placeholder="Email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="phone" class="form-label mb-2 font-18 font-heading fw-600">
                            Phone Number</label>
                        <input type="tel" class="common-input border" id="phone" wire:model="phone"
                            placeholder="Phone Number">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="password" class="form-label mb-2 font-18 font-heading fw-600">
                            Password
                        </label>
                        <input type="password" class="common-input border" id="password" wire:model="password"
                            placeholder="Password">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-sm-12 text-end">
                        <button type="submit" class="btn btn-main btn-lg pill mt-4">Update
                            Profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
