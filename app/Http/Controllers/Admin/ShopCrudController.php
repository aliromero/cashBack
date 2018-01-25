<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ShopRequest as StoreRequest;
use App\Http\Requests\ShopRequest as UpdateRequest;

class ShopCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Shop');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/shop');
        $this->crud->setEntityNameStrings('فروشگاه', 'فروشگاه ها');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->addField([
            'name' => 'name',
            'label' => 'نام فروشگاه',
            'type' => 'text',
            'placeholder' => 'مثال : جانبو شعبه پیروزی'
        ]);


        $this->crud->addField([
            'name' => 'manager_name',
            'label' => 'نام مدیریت',
            'type' => 'text',

        ]);


        $this->crud->addField([ // image
            'name' => 'logo',
            'label' => 'نماد فروشگاه(لوگو)',
            'type' => 'image',
            'upload' => true,
            'disk' => 'uploads',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
            'prefix' => 'uploads/'
        ]);



        $this->crud->addField(
            [
                'label' => 'انتخاب شهر یا شهرهای تحت پوشش',
                'type' => 'city_select2_multiple',
                'name' => 'cities', // the method that defines the relationship in your Model
                'entity' => 'cities', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\City", // foreign key model
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            ]
        );


        $this->crud->addField(
            [
                'label' => 'انتخاب محله های تحت پوشش',
                'type' => 'custom_select2_multiple',
                'name' => 'areas', // the method that defines the relationship in your Model
                'entity' => 'areas', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Area", // foreign key model
                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            ]
        );




        $this->crud->addField([
            'name' => 'address',
            'label' => 'نشانی فروشگاه',
            'type' => 'custom_address',
            'placeholder' => 'نشانی فروشگاه را وارد کنید',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12'
            ],

        ]);


        $this->crud->addField([
            'name' => 'latitude',
            'id'=>'latitude',
            'label' => 'عرض جغرافیایی',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],'attributes' => [
                'readonly' => '',
                'id' => 'latitude'
            ]
        ]);

        $this->crud->addField([
            'name' => 'longitude',
            'id'=>'longitude',
            'label' => 'طول جغرافیایی',
            'type' => 'text',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6',
            ],'attributes' => [
                'readonly' => '',
                'id' => 'longitude'
            ]
        ]);


        $this->crud->addField([
            'name' => 'tell',
            'label' => 'شماره تماس',
            'type' => 'text',
            'placeholder' => 'شماره تماس را وارد کنید'
        ]);

        $this->crud->addField([
            'name' => 'contract_number',
            'label' => 'شماره قرارداد',
            'type' => 'text'
        ]);

        $this->crud->addField([
            'name' => 'contract_src',
            'label' => 'فایل ضمیمه قرارداد',
            'type' => 'upload',
            'upload' => 'true',
            'prefix' => 'uploads/'
        ]);




        $this->crud->addField([
            'name' => 'status',
            'label' => 'وضعیت',
            'type' => 'checkbox',
        ]);

        $this->crud->addField([
            'name' => 'show_tell',
            'label' => 'نمایش شماره تماس برای کابران',
            'type' => 'checkbox',
        ]);


        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'نام فروشگاه',
        ]);




        $this->crud->addButtonFromModelFunction('line', 'reports', 'getReportsButton', 'beginning');
        $this->crud->addButtonFromModelFunction('line', 'factors', 'getFactorsButton', 'beginning');
        $this->crud->enableAjaxTable();




    }



    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
