@push('scripts')
  <script src="/js/ckeditor/ckeditor.js"></script>
@endpush

@props([
    'name' => '',
    'label' => '',
    'required' => false
])

@if ($label == '')
    @php
        //remove underscores from name
        $label = str_replace('_', ' ', $name);
        //detect subsequent letters starting with a capital
        $label = preg_split('/(?=[A-Z])/', $label);
        //display capital words with a space
        $label = implode(' ', $label);
        //uppercase first letter and lower the rest of a word
        $label = ucwords(strtolower($label));
    @endphp
@endif
<div wire:ignore class="mt-5">
    @if ($label !='none')
        <x-form.label :$label :$required :$name />
    @endif
    <textarea
        id="{{ $name }}"
        x-data
        x-init="
            editor = CKEDITOR.replace($refs.item);
            editor.on('change', function(event){
                @this.set('{{ $name }}', event.editor.getData());
            })
        "
        x-ref="item"
        {{ $attributes }}
        @error($name)
            aria-invalid="true"
            aria-description="{{ $message }}"
        @enderror
    >{{ $slot }}</textarea>
</div>
@error($name)
    <p class="error" aria-live="assertive">{{ $message }}</p>
@enderror
