<?php

namespace App\Http\Controllers\Admin\Traits;

use App\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait AjaxUploadImagesTrait
{

    /**
     * Upload an image with AJAX to the disk
     * and store its path in the database.
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function ajaxUploadImages(Request $request)
    {


        $attribute_name = "photo";
        $disk = "uploads";
        $destination_path = "photos";


        $files = $request->file('photo');
        $file_count = count($files);

        $request = \Request::instance();


        // if a new file is uploaded, store it on disk and its filename in the database
        if ($request->hasFile($attribute_name)) {
            foreach ($request->file($attribute_name) as $file) {
                if ($file->isValid()) {
                    // 1. Generate a new file name
                    $new_file_name = md5($file->getClientOriginalName() . time()) . '.' . $file->getClientOriginalExtension();

                    // 2. Move the new file to the correct path
                    $file_path = $file->storeAs($destination_path, $new_file_name, $disk);

                    // 3. Add the public path to the database
                    $attribute_value[] = $file_path;
                }
            }
        }


        return response()->json([
            'success' => true,
            'message' => ($file_count > 1) ? 'Uploaded ' . $file_count . ' images.' : 'Image uploaded',
            'images' => $attribute_value
        ]);
    }


    /**
     * Delete an image from the database and disk.
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function ajaxDeleteImage(Request $request)
    {
        $image_path = $request->input('image_path');

        $photo = Photo::where('photo', $image_path)->first();
        if ($photo)
            $photo->delete();
        // delete the image from the folder


        return response()->json([
            'success' => true,
            'message' => 'Image deleted.',

        ]);
    }


}