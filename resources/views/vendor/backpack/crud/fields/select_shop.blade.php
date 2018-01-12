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
                @foreach ($field['model']::join('shop_user','shop_user.shop_id' , '=' ,'shops.id')->select('shops.*')->where('shop_user.user_id',Auth::user()->id)->get() as $connected_entity_entry)
                    <option value="{{ $connected_entity_entry->getKey() }}"

                        @if ( ( old($field['name']) && old($field['name']) == $connected_entity_entry->getKey() ) || (!old($field['name']) && isset($field['value']) && $connected_entity_entry->getKey()==$field['value']) || Request::get('shop_id') == $connected_entity_entry->getKey())

                             selected
                        @endif
                    >{{ $connected_entity_entry->{$field['attribute']} }}</option>
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

@push('crud_fields_scripts')
<!-- include select2 js-->
<script type="text/javascript">




    var elem_vote = document.getElementsByName('vote_id');
    var elem2_vote = document.getElementsByClassName('votes');

    var elem_video = document.getElementsByName('video_id');
    var elem2_video = document.getElementsByClassName('videos');


    for (var i = 0; i<elem2_vote.length; i++) {
        elem2_vote[i].style.display = 'none';
    }

    for (var i = 0; i<elem_vote.length; i++) {
        elem_vote[i].style.display = 'none';
    }


    for (var i = 0; i<elem2_video.length; i++) {
        elem2_video[i].style.display = 'none';
    }

    for (var i = 0; i<elem_video.length; i++) {
        elem_video[i].style.display = 'none';
    }


    var e = document.getElementById('shop');
    var val = e.options[e.selectedIndex].value;

    document.getElementById('vote-' + val).disabled = false;
    document.getElementById('vote-' + val).style.display = 'block';
    document.getElementById('votes-' + val).style.display = 'block';

    document.getElementById('video-' + val).disabled = false;
    document.getElementById('video-' + val).style.display = 'block';
    document.getElementById('videos-' + val).style.display = 'block';

    function voteChanged(val) {

        if(val > 0) {
            for (var i = 0; i<elem_video.length; i++) {
                elem_video[i].selectedIndex = "0";
            }
        }


//        document.getElementById('video-' + val).disabled = true;


    }

    function videoChanged(val) {
        if(val > 0) {
            for (var i = 0; i < elem_vote.length; i++) {
                elem_vote[i].selectedIndex = "0";

            }
        }

//        document.getElementById('vote-' + val).disabled = true;


    }

    function getCategories(val) {
        for (var i = 0; i<elem2_vote.length; i++) {
            elem2_vote[i].style.display = 'none';
        }


        for (var i = 0; i<elem_vote.length; i++) {
            elem_vote[i].style.display = 'none';
            elem_vote[i].disabled = true;
        }


        document.getElementById('vote-' + val).disabled = false;
        document.getElementById('vote-' + val).style.display = 'block';
        document.getElementById('votes-' + val).style.display = 'block';



        for (var i = 0; i<elem2_video.length; i++) {
            elem2_video[i].style.display = 'none';
        }


        for (var i = 0; i<elem_video.length; i++) {
            elem_video[i].style.display = 'none';
            elem_video[i].disabled = true;
        }


        document.getElementById('video-' + val).disabled = false;
        document.getElementById('video-' + val).style.display = 'block';
        document.getElementById('videos-' + val).style.display = 'block';
    }
</script>
@endpush