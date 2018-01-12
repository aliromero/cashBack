<!-- text input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

    @if(isset($field['prefix']) || isset($field['suffix']))
        <div class="input-group"> @endif
            @if(isset($field['prefix']))
                <div class="input-group-addon">{!! $field['prefix'] !!}</div> @endif
            <input

                    type="text"
                    name="{{ $field['name'] }}"
                    @if(isset($field['placeholder']))
                    placeholder="{{ $field['placeholder'] }}"
                    @endif
                    value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
                    @include('crud::inc.field_attributes')
            >

            @if(isset($field['suffix']))
                <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif
            @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
<div class="col-md-12">
    <input id="pac-input" class="form-control" type="text" placeholder="مکان فروشگاه را در نقشه جستجو کنید">
</div>
<div class="clearfix"></div>
<div class="col-md-12">

    <div id="map" style="height: 400px;"></div>


</div>

{{-- FIELD EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

@push('crud_fields_styles')
<style>


    #pac-input {
        margin-left: 0 !important;
        left: 0 !important;
        font: 13px 'IRANSans', 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

</style>

<!-- no styles -->
@endpush


{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

@push('crud_fields_scripts')


<script>


    function initAutocomplete() {


        var lat_input = parseFloat(document.getElementById('latitude').value);
        var lng_input = parseFloat(document.getElementById('longitude').value);
        var latitude = (lat_input > 0) ? lat_input : 0;
        var longitude = (lng_input > 0) ? lng_input : 0;


        var image = "{{ asset("home/assets/images/loc.png") }}";
        var markers = [];


        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: {lat: latitude, lng: longitude},
            mapTypeId: 'roadmap'

        });

        var cityCircle = new google.maps.Circle({
            strokeColor: '#78CC6E',
            strokeOpacity: 0.5,
            strokeWeight: 2,
            fillColor: '#C9EBC5',
            fillOpacity: 0.15,
            map: map,
            radius: 1500
        });

        markers[0] = new google.maps.Marker({
            position: {lat: latitude, lng: longitude},
            map: map,
            icon: image,
            draggable: true,
            animation: google.maps.Animation.DROP
        });







        var shop = "{{ asset("home/assets/images/shop.png") }}";
        var locations = [
                <?php
                $addresses = \App\Models\Shop::all();
                $i = 0;
                if(count($addresses) > 0)
                foreach ($addresses as $address) {
                $i++;
                ?>
            ['<?=$address->name?>', <?=$address->latitude?>, <?=$address->longitude?>, <?=$i?>],
            <?php } ?>

        ];

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
                icon: shop
            });
        }

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function () {
            searchBox.setBounds(map.getBounds());


        });


        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function () {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function (marker) {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function (place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                var shop = "{{ asset("home/assets/images/shop.png") }}";
                var locations = [
                        <?php
                            $addresses = \App\Models\Shop::all();
                            $i = 0;
                        if(count($addresses) > 0)
                        foreach ($addresses as $address) {
                            $i++;
                            ?>
                            ['<?=$address->name?>', <?=$address->latitude?>, <?=$address->longitude?>, <?=$i?>],
                    <?php } ?>

                ];

                for (i = 0; i < locations.length; i++) {
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                        map: map,
                        icon: shop
                    });
                }

                var image = "{{ asset("home/assets/images/loc.png") }}";

                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    icon: image,
                    title: place.name,
                    position: place.geometry.location,
                    draggable: true,
                    animation: google.maps.Animation.DROP
                }));

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);

                }


                google.maps.event.addListener(map, 'rightclick', function(event) {
                    markers[0].setPosition(event.latLng);
                    document.getElementById('latitude').value = event.latLng.lat().toFixed(7);
                    document.getElementById('longitude').value = event.latLng.lng().toFixed(7);
                });


                google.maps.event.addListener(markers[0], 'dragend', function (evt) {
                    document.getElementById('latitude').value = evt.latLng.lat().toFixed(7);
                    document.getElementById('longitude').value = evt.latLng.lng().toFixed(7);
                });


                document.getElementById('latitude').value = place.geometry.location.lat();
                document.getElementById('longitude').value = place.geometry.location.lng();
            });
            cityCircle.setMap(null);
            cityCircle.setMap(map);
            cityCircle.bindTo('center', markers[0], 'position');
            map.fitBounds(bounds);

        });





        google.maps.event.addListener(map, 'rightclick', function(event) {
            markers[0].setPosition(event.latLng);
            document.getElementById('latitude').value = event.latLng.lat().toFixed(7);
            document.getElementById('longitude').value = event.latLng.lng().toFixed(7);
        });


        google.maps.event.addListener(markers[0], 'dragend', function (evt) {
            document.getElementById('latitude').value = evt.latLng.lat().toFixed(7);
            document.getElementById('longitude').value = evt.latLng.lng().toFixed(7);
        });

        cityCircle.setMap(null);
        cityCircle.setMap(map);
        cityCircle.bindTo('center', markers[0], 'position');


    }


</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDA0rvN2kMxQfXXE6lUqXhV_4QkWtzL-xk&language=fa&region=IR&libraries=places&callback=initAutocomplete"></script>


<!-- no scripts -->
@endpush


{{-- Note: you can use @if ($crud->checkIfFieldIsFirstOfItsType($field, $fields)) to only load some CSS/JS once, even though there are multiple instances of it --}}