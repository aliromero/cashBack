<!-- bootstrap datepicker input -->

<?php
    // if the column has been cast to Carbon or Date (using attribute casting)
    // get the value as a date string
use Morilog\Jalali\jDate;
if (isset($field['value']) && ( $field['value'] instanceof \Carbon\Carbon || $field['value'] instanceof \Jenssegers\Date\Date )) {
        $field['value'] = $field['value']->format('Y-m-d');
    }

?>

<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')
    <div class="input-group date">


        <input
            type="text"
            name="{{ $field['name'] }}" value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
            @include('crud::inc.field_attributes')
            >
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </div>
    </div>

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif

    <?php
    $datetime_fa = jDate::forge('2017-09-27 10:42:20')->format('datetime');
    list($date,$time)=explode(" ",$datetime_fa);
    $date=explode("-",$date);
    $time=explode(":",$time);
    $timestamp=mktime($date[1],$date[2],$date[0],$time[0],$time[1],0);


//    $datetime_fa =  strtotime(jDate::forge('2017-09-27 10:42:20')->format('datetime'));

    echo $timestamp;


    ?>
</div>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    <link rel="stylesheet" href="{{ asset('vendor/pwt.datepicker-master/dist/css/persian-datepicker.min.css') }}">

    @endpush

    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
    <script src="{{ asset('vendor/pwt.datepicker-master/assets/persian-date.min.js') }}"></script>
    <script src="{{ asset('vendor/pwt.datepicker-master/dist/js/persian-datepicker.min.js') }}"></script>
    <script>
        var pd = $('.normal-example').persianDatepicker({
            inline: false,
//            altField: '#inlineExampleAlt',
            altFormat: 'LLLL',
//            initialValue : true,
//            maxDate: new persianDate().add('month', 12).valueOf(),
//            minDate: new persianDate().subtract('month', 0).valueOf(),
            timePicker: {
                enabled: true,
                meridiem: {
                    enabled: true
                }
            }
        });


        pd.setDate(1506902400);
    </script>
    @endpush

@endif

{{-- End of Extra CSS and JS --}}
