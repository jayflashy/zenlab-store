@props([
    'label' => '',
    'model' => '',
    'type' => 'success',
    'live' => false,
])

<div class="form-group mb-3">
    <label for="{{ $model }}" class="form-label">{{ $label }}</label>
    <br>
    <label class="jdv-switch jdv-switch-{{ $type }}" style="margin-top: 10px;" role="switch" >
        <input type="checkbox" name="{{ $model }}"
            @if ($live) wire:model.live="{{ $model }}" @else
            wire:model="{{ $model }}" @endif
            id="{{ $model }}">
        <span class="slider round"></span>
    </label>
</div>
