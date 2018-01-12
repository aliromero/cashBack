<!-- select2 multiple -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    @foreach (\App\Models\Shop::all() as $shop)
        <div id="cats-{{$shop->id}}" class="cats" style="width: 100%">
            <div class="clearfix"></div>
            <select
                    id="cat-{{$shop->id}}"
                    name="{{ $field['name'] }}[]"
                    style="width: 100%"
                    @include('crud::inc.field_attributes', ['default_class' =>  'form-control select2'])
                    multiple>

                @if (isset($field['model']))

                    @foreach ($field['model']::where('shop_id',$shop->id)->get() as $connected_entity_entry)
                        <option value="{{ $connected_entity_entry->getKey() }}"
                                @if ( (isset($field['value']) && in_array($connected_entity_entry->getKey(), $field['value']->pluck($connected_entity_entry->getKeyName(), $connected_entity_entry->getKeyName())->toArray())) || ( old( $field["name"] ) && in_array($connected_entity_entry->getKey(), old( $field["name"])) ) )
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


