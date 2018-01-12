<!-- text input -->
<div @include('crud::inc.field_wrapper_attributes') >
    @include('crud::inc.field_translatable_icon')

    @if(isset($field['prefix']) || isset($field['suffix']))
        <div class="input-group"> @endif
            @if(isset($field['prefix']))
                <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif
            {{-- HINT --}}


            <{{ $field['tag'] }}>
            @if(isset($field['value']))
                {{ $field['value'] }}
            @endif
        </{{ $field['tag'] }}>


</div>


{{-- FIELD EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

{{-- @push('crud_fields_styles')
    <!-- no styles -->
@endpush --}}


{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

{{-- @push('crud_fields_scripts')
    <!-- no scripts -->
@endpush --}}


{{-- Note: you can use @if ($crud->checkIfFieldIsFirstOfItsType($field, $fields)) to only load some CSS/JS once, even though there are multiple instances of it --}}