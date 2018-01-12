<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 5/22/2017
 * Time: 8:06 PM
 */

function my_public_path($path = '')
{
    return app()->make('path.public').($path ? '/../'.$path : $path);
}