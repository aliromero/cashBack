<!-- select -->

<div @include('crud::inc.field_wrapper_attributes') >




    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <?php $entity_model = $crud->model; ?>


    <select
        name="{{ $field['name'] }}"
        onChange="getCategories(value);"
        @include('crud::inc.field_attributes')
        >

        @if ($entity_model::isColumnNullable($field['name']))
            <option value="">-</option>
        @endif

            @if (isset($field['model']))
                @foreach ($field['model']::
                join('shop_user','shop_user.shop_id' , '=' ,'products.shop_id')
                ->select('products.*')
                ->where('shop_user.user_id',Auth::user()->id)->get() as $connected_entity_entry)
                    <option value="{{ $connected_entity_entry->getKey() }}"

                        @if ( ( old($field['name']) && old($field['name']) == $connected_entity_entry->getKey() ) || (!old($field['name']) && isset($field['value']) && $connected_entity_entry->getKey()==$field['value']) || Request::get('product_id') == $connected_entity_entry->getKey())
                             selected
                        @endif
                    >{{ $connected_entity_entry->{$field['attribute']} }} </option>
                @endforeach
            @endif
    </select>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif



</div>


@push('crud_fields_styles')

@endpush

{{-- FIELD JS - will be loaded in the after_scripts section --}}
{{--@push('crud_fields_scripts')--}}
{{--<!-- include select2 js-->--}}
{{--<script type="text/javascript">--}}




    {{--var elem = document.getElementsByName('categories[]');--}}
    {{--var elem2 = document.getElementsByClassName('cats');--}}

    {{--for (var i = 0; i<elem2.length; i++) {--}}
        {{--elem2[i].style.display = 'none';--}}
    {{--}--}}

    {{--for (var i = 0; i<elem.length; i++) {--}}
        {{--elem[i].style.display = 'none';--}}
    {{--}--}}

    {{--var e = document.getElementById('shop');--}}
    {{--var val = e.options[e.selectedIndex].value;--}}

    {{--document.getElementById('cat-' + val).disabled = false;--}}
    {{--document.getElementById('cat-' + val).style.display = 'block';--}}
    {{--document.getElementById('cats-' + val).style.display = 'block';--}}

    {{--function getCategories(val) {--}}
        {{--for (var i = 0; i<elem2.length; i++) {--}}
            {{--elem2[i].style.display = 'none';--}}
        {{--}--}}


        {{--for (var i = 0; i<elem.length; i++) {--}}
            {{--elem[i].style.display = 'none';--}}
            {{--elem[i].disabled = true;--}}
        {{--}--}}


        {{--document.getElementById('cat-' + val).disabled = false;--}}
        {{--document.getElementById('cat-' + val).style.display = 'block';--}}
        {{--document.getElementById('cats-' + val).style.display = 'block';--}}
    {{--}--}}
{{--</script>--}}
{{--@endpush--}}