<?php $x++ ?>
@foreach($childs as $child)

    <option value="{{$child->id}}"
            @if ( ( old($active_name) && old($active_name) == $child->id ) || (!old($active_name) && isset($active_id) && $child->id==$active_id))
            selected
            @endif>

        @if($x == 1) {{ "--" }} @endif
        @if($x == 2) {{ "----" }} @endif
        @if($x == 3) {{ "------" }} @endif
        @if($x == 4) {{ "--------" }} @endif
        @if($x == 5) {{ "----------" }} @endif
        {{ $child->name }}
    </option>
    @if(count($child->children))
        @include('crud::manageChild',['childs' => $child->children, 'x' => $x])
    @endif
@endforeach