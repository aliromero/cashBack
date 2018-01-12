<?php
$value = old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : null));
?>

<div @include('crud::inc.field_wrapper_attributes') >

    <div><label>{!! $field['label'] !!}</label></div>
    @include('crud::inc.field_translatable_icon')
    @foreach((array)$value as $v)
        @if ($v)
            <div class="input-group">
                <input type="text" name="{{ $field['name'] }}[]" value="{{ $v }}" @include('crud::inc.field_attributes') readonly>
                <div class="input-group-btn">
                    <button type="button" class="browse_{{ $field['name'] }} remove btn btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        @endif
    @endforeach

    <div class="btn-group" role="group" aria-label="..." style="margin-top: 3px;">
        <button type="button" class="browse_{{ $field['name'] }} popup btn btn-default">
            <i class="fa fa-cloud-upload"></i>
            {{ trans('backpack::crud.browse_uploads') }}
        </button>
        <button type="button" class="browse_{{ $field['name'] }} clear btn btn-default">
            <i class="fa fa-eraser"></i>
            {{ trans('backpack::crud.clear') }}
        </button>
    </div>

    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif

</div>

<script type="text/html" id="browse_multiple_template_{{ $field['name'] }}">
    <div class="input-group">
        <input type="text" name="{{ $field['name'] }}[]" @include('crud::inc.field_attributes') readonly>
        <div class="input-group-btn">
            <button type="button" class="browse_{{ $field['name'] }} remove btn btn-danger">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </div>
</script>

{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))
    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    <!-- include browse server css -->
    <link rel="stylesheet" type="text/css"
          href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('packages/barryvdh/elfinder/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('packages/barryvdh/elfinder/css/theme.css') }}">
    <link href="{{ asset('vendor/backpack/colorbox/example2/colorbox.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        #cboxContent, #cboxLoadedContent, .cboxIframe {
            background: transparent;
        }
    </style>
    @endpush

    @push('crud_fields_scripts')
    <!-- include browse server js -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('vendor/backpack/colorbox/jquery.colorbox-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('packages/barryvdh/elfinder/js/elfinder.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('vendor/studio-42/elfinder/js/extras/editors.default.min.js') }}"></script>
    @if (($locale = \App::getLocale()) != 'en')
        <script type="text/javascript"
                src="{{ asset("packages/barryvdh/elfinder/js/i18n/elfinder.fa.js") }}"></script>
    @endif
    @endpush
@endif

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
<script>
    $(function () {
        var template = document.getElementById('browse_multiple_template_{{ $field['name'] }}').innerHTML;
        $(document).on('click', '.popup.browse_{{ $field['name'] }}', function (event) {
            event.preventDefault();
            var element = $(this);
            var div = $('<div>');
            div.elfinder({
                lang: '{{ \App::getLocale() }}',
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                url: '{{ route("elfinder.connector") }}',
                soundPath: '{{ asset('/packages/barryvdh/elfinder/sounds') }}',
                dialog: {width: 900, modal: true, title: 'Select a file'},
                resizable: false,
                @if ($mimes = array_get($field, 'mime_types'))
                onlyMimes: {!! json_encode($mimes) !!},
                @endif
                commandsOptions: {
                    getfile: {
                        @if (array_get($field, 'multiple'))
                        multiple: true,
                        @endif
                        oncomplete: 'destroy'
                    }
                },
                getFileCallback: function (files) {
                    files.forEach(function (file) {
                        var input = $(template);
                        input.find('input').val(file.path);
                        element.parent().before(input);
                    });
                    $.colorbox.close();
                }
            }).elfinder('instance');
            // trigger the reveal modal with elfinder inside
            $.colorbox({
                href: div,
                inline: true,
                width: '80%',
                height: '80%'
            });
        });
        $(document).on('click', '.clear.browse_{{ $field['name'] }}', function (event) {
            event.preventDefault();
            $('input[name=\'{{ $field['name'] }}[]\']').parents('.input-group').remove();
        });
        // function to update the file selected by elfinder
        function processSelectedFile(filePath, requestingField) {
            $('#' + requestingField).val(filePath);
        }
        $(document).on('click', '.remove.browse_{{ $field['name'] }}', function (event) {
            event.preventDefault();
            $(this).parents('.input-group').remove();
        });
    });
</script>
@endpush

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}