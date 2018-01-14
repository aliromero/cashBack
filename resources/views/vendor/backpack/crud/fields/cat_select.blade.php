<!-- select -->

<div @include('crud::inc.field_wrapper_attributes') >

    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    <?php $entity_model = $crud->model; ?>
    @foreach (\App\Models\Shop::all() as $shop)
        <div id="cats-{{$shop->id}}" class="cats" style="width: 100%">
            <div class="clearfix"></div>
            <select
                    id="cat-{{$shop->id}}"
                    name="{{ $field['name'] }}"
                    @include('crud::inc.field_attributes')
            >

                @if ($entity_model::isColumnNullable($field['name']))
                    <option value="">-</option>
                @endif

                    @if (isset($field['model']))

                        @foreach ($field['model']::where('shop_id',$shop->id)->get() as $connected_entity_entry)
                        <option value="{{ $connected_entity_entry->getKey() }}"

                                @if ( ( old($field['name']) && old($field['name']) == $connected_entity_entry->getKey() ) || (!old($field['name']) && isset($field['value']) && $connected_entity_entry->getKey()==$field['value']))

                                selected
                                @endif
                        >{{ $connected_entity_entry->{$field['attribute']} }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    @endforeach
    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif



</div>