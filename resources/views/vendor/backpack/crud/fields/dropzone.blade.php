<div class="form-group col-md-12">
    <strong>{{ $field['label'] }}</strong> <br>
    <div class="btn-group" role="group" aria-label="..." style="margin-top: 3px;">
        <button type="button" data-inputid="all_images" class="btn btn-default popup_selector">
            <i class="fa fa-cloud-upload"></i> انتخاب تصویر</button>
    </div>
    <div class="dropzone">
        <div class="dz-message">
            برای آپلود تصاویر میتوانید تصاویر را اینجا بکشید و یا از دکمه انتخاب تصویر استفاده کنید
        </div>


        @if(isset($entry))
            @if ($entry->photos())
                @foreach($entry->photos() as $key => $image)
                    <div class="dz-preview" data-id="{{ $key }}" data-path="{{ $image }}">
                        <img class="dropzone-thumbnail" src={{ asset($image) }}>
                        <a class="dz-remove" href="javascript:void(0);" data-remove="{{ $key }}"
                           data-path="{{ $image }}">حذف</a>
                    </div>
                @endforeach
            @endif
        @endif

    </div>
</div>


@if(isset($entry))
    @if ($entry->photos())


        <input type="text" id="all_images" name="all_images"
               value="@foreach($entry->photos as $photo){{ $photo->photo }}<?php if(!$loop->last) { echo ",";} ?>@endforeach" class="hidden"/>
    @endif
@else
    <input type="text" id="all_images" name="all_images" value="{{ old('all_images') ? old('all_images') : '' }}" class="hidden"/>
@endif
<div id="inputs_image">

</div>







@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))
    {{-- FIELD EXTRA CSS  --}}
    {{-- push things in the after_styles section --}}

    {{-- FIELD CSS - will be loaded in the after_styles section --}}
    @push('crud_fields_styles')
    <!-- include browse server css -->
    <link href="{{ asset('vendor/backpack/colorbox/example2/colorbox.css') }}" rel="stylesheet" type="text/css" />
    <style>
        #cboxContent, #cboxLoadedContent, .cboxIframe {
            background: transparent;
        }
    </style>
    @endpush

    @push('crud_fields_scripts')
    <!-- include browse server js -->
    <script src="{{ asset('vendor/backpack/colorbox/jquery.colorbox-min.js') }}"></script>
    @endpush



    @push('crud_fields_styles')
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css">

    <style>

        .dropzone-thumbnail {
            width: 105px;
            border:1px solid #E8E8E8;
            padding: 5px;
        }

        .dropzone {
            border:1px solid #E8E8E8 !important;
            margin-top:10px;
        }
    </style>
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}

    @push('crud_fields_scripts')

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>

    <script>

        var all_images = $('#all_images').val().split(",");

                all_images.reverse();

                var longWords = all_images.filter(function(word){
                    return word.length > 1;
                });


        $('.dropzone').empty();
        for (i = 0; i < longWords.length; i++) {
            $('.dropzone').append('<div class="dz-preview" data-id="' + i + '" data-path="' + longWords[i] + '"><img class="dropzone-thumbnail" src="{{ url('uploads') }}/' + longWords[i] + '" /><a class="dz-remove" href="javascript:void(0);" data-remove="' + i + '" data-path="' + longWords[i] + '">حذف</a></div>');
            addField(longWords[i], i);

        }


        Dropzone.autoDiscover = false;
        var uploaded = false;


        var dropzone = new Dropzone(".dropzone", {
            url: "{{ url($crud->route.'/'.$field['upload_route']) }}",
            paramName: '{{ $field['name'] }}',
            uploadMultiple: true,
            acceptedFiles: "{{ $field['mimes'] }}",
            addRemoveLinks: true,
            // autoProcessQueue: false,
            maxFilesize: {{ $field['filesize'] }},
            parallelUploads: 10,
            // previewTemplate:
            sending: function (file, xhr, formData) {
                formData.append("_token", $('[name=_token').val());
            },
            error: function (file, response) {
                console.log('error');
                console.log(file);
                console.log(response);

                $(file.previewElement).find('.dz-error-message').remove();
                $(file.previewElement).remove();

                $(function () {
                    new PNotify({
                        title: file.name + " was not uploaded!",
                        text: response,
                        type: "error",
                        icon: false
                    });
                });

            },

            success: function (file, status) {
                console.log('success');

                // clear the images in the dropzone
                $('.dropzone').empty();

                // repopulate the dropzone with all images (new and old)


//                addFields(status.images);

                var notification_type;

                if (status.success) {
                    notification_type = 'success';
                } else {
                    notification_type = 'error';
                }

                new PNotify({
                    text: status.message,
                    type: notification_type,
                    icon: false
                });
            }
        });


        dropzone.on("successmultiple", function (file, status) {
                addFields(status.images);
                var all_images = $('#all_images').val().split(",");
                all_images.reverse();

            var longWords = all_images.filter(function(word){
                return word.length > 1;
            });


                for (i = 0; i < longWords.length; i++) {
                        $('.dropzone').append('<div class="dz-preview" data-id="' + i + '" data-path="' + longWords[i] + '"><img class="dropzone-thumbnail" src="{{ url('uploads') }}/' + longWords[i] + '" /><a class="dz-remove" href="javascript:void(0);" data-remove="' + i + '" data-path="' + longWords[i] + '">حذف</a></div>');
                }


            }
        );


        // Delete image
        $(document).on('click', '.dz-remove', function () {

            var image_id = $(this).data('remove');
            var image_path = $(this).data('path');

            var images = document.getElementsByName("images[]");
            for (i = 0; i < images.length; i++) {
                if (images[i].value === image_path) {
//                    alert(images[i].id);
                    removeField(images[i].id);
                }

            }


            $.ajax({
                url: '{{ url($crud->route.'/'.$field['delete_route']) }}',
                type: 'POST',
                data: {
                    image_path: image_path
                }
            })
                .done(function (status) {
                    var notification_type;

                    if (status.success) {
                        notification_type = 'success';
                        $('div.dz-preview[data-id="' + image_id + '"]').remove();
                    } else {
                        notification_type = 'error';
                    }

                    new PNotify({
                        text: status.message,
                        type: notification_type,
                        icon: false
                    });
                });
        });


        function removeField(id) {
            $("#" + id).remove();

            var all_images_field = $('#all_images');
            var all_images = $('#all_images').val().split(",");
            all_images_field.val("");
            var images = document.getElementsByName("images[]");
            for (i = 0; i < images.length; i++) {
//                all_images_field.val("");


                all_images_field.val(all_images_field.val() + "," + images[i].value);
            }


        }


        function addField(value, i) {
            var container = document.getElementById("inputs_image");
            var input = document.createElement("input");
            input.type = "text";
            input.name = "images[]";
            input.id = "imageId-" + i;
            input.value = value;
            input.className = "hidden";
            container.appendChild(input);
        }


        function addFields(values) {
            var all_images = document.getElementsByName("all_images");
            var res = document.getElementsByName("images[]");

            var size = res.length;
            var container = document.getElementById("inputs_image");
            for (i = 0; i < values.length; i++) {
                var input = document.createElement("input");
                input.type = "text";
                input.name = "images[]";
                input.id = "imageId-" + (size + i);
                input.className = "hidden";
                input.value = values[i];
                container.appendChild(input);
                all_images[0].value = values[i] + "," + all_images[0].value;

            }


        }



                $(document).on('click','.popup_selector[data-inputid=all_images]',function (event) {
                    event.preventDefault();

                    // trigger the reveal modal with elfinder inside
                    var triggerUrl = "{{ url(config('elfinder.route.prefix').'/popup/'."photos-filemanager") }}";
                    $.colorbox({
                        href: triggerUrl,
                        fastIframe: true,
                        iframe: true,
                        width: '70%',
                        height: '70%'
                    });
                });

                // function to update the file selected by elfinder
                function processSelectedFile(filePath, requestingField) {

                    var res = filePath.replace("uploads\\","");
                    res = res.replace("uploads/","");
                    res = res.replace("\\","/");
                    $('#all_images').val($('#all_images').val() + "," + res);


                    var all_images = $('#all_images').val().split(",");

                    all_images.reverse();

                    var longWords = all_images.filter(function(word){
                        return word.length > 1;
                    });

                    $('.dropzone').empty();
                    $('#inputs_image').empty();

                    for (i = 0; i < longWords.length; i++) {
                        $('.dropzone').append('<div class="dz-preview" data-id="' + i + '" data-path="' + longWords[i] + '"><img class="dropzone-thumbnail" src="{{ url('uploads') }}/' + longWords[i] + '" /><a class="dz-remove" href="javascript:void(0);" data-remove="' + i + '" data-path="' + longWords[i] + '">حذف</a></div>');
                        addField(longWords[i], i);

                    }

                }



    </script>

    @endpush
@endif





