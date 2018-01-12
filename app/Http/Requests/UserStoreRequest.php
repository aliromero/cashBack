<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Backpack\CRUD\app\Http\Requests\CrudRequest;

class UserStoreRequest extends CrudRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|unique:'.config('laravel-permission.table_names.users', 'users').',email',
            'name'     => 'required',
            'password' => 'required|confirmed',
        ];
    }
}