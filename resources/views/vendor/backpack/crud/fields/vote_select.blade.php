<!-- select2 multiple -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    @foreach (\App\Models\Shop::all() as $shop)
        <div id="votes-{{$shop->id}}" class="votes" style="width: 100%">
            <div class="clearfix"></div>
            <select
                    id="vote-{{$shop->id}}"
                    name="{{ $field['name'] }}"
                    class="form-control"
                    disabled="true"
                    onchange="voteChanged(this.value)"
                    >

                @if (isset($field['model']))
                    <option value="0">هیچ کدام</option>
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


