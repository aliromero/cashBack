<!-- select2 multiple -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <select
            name="{{ $field['name'] }}[]"
            @include('crud::inc.field_attributes', ['default_class' =>  'form-control custom_select2'])
            multiple>

        @if (isset($field['model']))

            @foreach ($field['model']::all() as $connected_entity_entry)



                <option value="{{ $connected_entity_entry->{$field['attribute']} }}"
                        @if ( (isset($field['value']) && in_array($connected_entity_entry->getKey(), $field['value']->pluck($connected_entity_entry->getKeyName(), $connected_entity_entry->getKeyName())->toArray())) || ( old( $field["name"] ) && in_array($connected_entity_entry->{$field['attribute']}, old( $field["name"])) ) )
                        selected
                        @endif
                >{{ $connected_entity_entry->{$field['attribute']} }}</option>

            @endforeach





            @if( (old($field["name"])) )
                <?php
                function is_not_exist($val)
                {
                    $tags = array_pluck(App\Models\Tag::get(['name']), 'name');
                    return !in_array($val, $tags, true);
                }
                $olds = old($field["name"]);
                $af = array_filter($olds, 'is_not_exist');
                ?>
                @foreach($af as $old)
                    <option value="{{ $old }}" selected>{{ $old }}</option>
                @endforeach
            @endif


        @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>


@push('crud_fields_scripts')
<!-- include select2 js-->
<script src="{{ asset('vendor/backpack/select2/select2.min.js') }}"></script>
<script>
    jQuery(document).ready(function($) {
        // trigger select2 for each untriggered select2_multiple box
        $('.custom_select2').each(function (i, obj) {
            if (!$(obj).data("select2"))
            {
                $(obj).select2({
                    tags:true,
                    language: "fa",
                    dir: "rtl"
                });
            }
        });
    });
</script>
@endpush



