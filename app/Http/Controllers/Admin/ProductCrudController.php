<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Traits\AjaxUploadImagesTrait;
use App\Models\Category;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Tag;
use App\Models\Photo;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ProductRequest as StoreRequest;
use App\Http\Requests\ProductRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;


class ProductCrudController extends CrudController
{
    use AjaxUploadImagesTrait;

    public function getCategories($shop_id)
    {

        return Category::where('shop_id', $shop_id)->get();


    }

    public function setup()
    {


        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Product');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/product');
        $this->crud->setEntityNameStrings('محصول', 'محصولات');
        $this->crud->enableAjaxTable();


//        $this->data['entries'] = Product::Published()->get();


        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

//        $this->crud->setFromDb();

        $this->crud->addField([  // Select
            'name' => 'shop_id',
            'label' => 'فروشگاه',
            'type' => 'select_shop',
            'entity' => 'shop', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Shop",// foreign key model
            'wrapperAttributes' => [
                'class' => 'form-group col-md-4'
            ],
            'attributes' => ['required' => '', 'id' => 'shop'],
        ]);

        $this->crud->addField(
            [
                'label' => 'دسته بندی',
                'type' => 'cat_select',
                'name' => 'category_id', // the method that defines the relationship in your Model
                'entity' => 'categories', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-8'
                ],

                'hint' => 'یک دسته مربوط به محصول خود را انتخاب کنید',
            ]
        );

        $this->crud->addField([
            'name' => 'name',
            'label' => 'نام محصول',
            'type' => 'text',
            'hint' => 'نام محصول را مختصر و مفید حداکثر در 1 سطر وارد کنید',
        ]);


        $this->crud->addField([
            'name' => 'image',
            'label' => 'تصویر محصول',
            'type' => 'image',
            'upload' => true,
            'disk' => 'uploads',
            'crop' => true, // set to true to allow cropping, false to disable
            'aspect_ratio' => 1, // ommit or set to 0 to allow any aspect ratio
             'prefix' => 'uploads/'
        ]);


        $this->crud->addField([
            'name' => 'description',
            'label' => 'توضیحات محصول',
            'type' => 'textarea',
            'attributes' => ['rows' => '10']
        ]);





        $this->crud->addField([   // Upload
            'name' => 'photo',
            'label' => 'تصویرهای محصول',
            'type' => 'dropzone',
            'upload_route' => 'upload_images',
            'delete_route' => 'delete_image',
            'hint' => 'عکس های خود را به صورت چندگانه انتخاب کنید',
            'mimes' => 'image/*', //allowed mime types separated by comma. eg. image/*, application/*, etc
            'filesize' => 5, // maximum file size in MB
        ]);


        $this->crud->addField(
            [
                'label' => 'برچسب های محصول',
                'type' => 'tag_select2_multiple',
                'name' => 'tags', // the method that defines the relationship in your Model
                'entity' => 'tags', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => "App\Models\Tag", // foreign key model
                'pivot' => false, // on create&update, do you need to add/delete pivot table entries?
                'hint' => 'شما علاوه بر تایپ و فشردن دکمه Enter بعد از تایپ با استفاده از کاراکتر جدا کننده ویرگول "," میتوانید هشتگ اضافه کنید',
            ]
        );


        $this->crud->addField([
            'name' => 'price',
            'label' => 'قیمت محصول',
            'type' => 'number',
            'hint' => ' قیمت را به تومان وارد کنید',

        ]);


        $this->crud->addField([
            'name' => 'discount_type',
            'label' => 'نوع تخفیف',
            'type' => 'enum',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
            'hint' => 'percent : اعمال تخفیف به صورت درصد <br/> value : اعمال تخفیف به صورت یک مقدار ثابت به تومان',
        ]);

        $this->crud->addField([
            'name' => 'discount',
            'label' => 'میزان تخفیف (درصد/تومان)',
            'type' => 'number',
            'hint' => 'در صورت انتخاب value تخفیف را به تومان وارد کنید <br/> در غیر این صورت تخفیف را به صورت درصد وارد کنید',
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);





        $this->crud->addField([
            'name' => 'vote_id',
            'label' => 'نظر سنجی',
            'type' => 'vote_select',
            'entity' => 'votes', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Vote", // foreign key model
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'name' => 'video_id',
            'label' => 'کلیپ تبلیغاتی',
            'type' => 'video_select',
            'entity' => 'videos', // the method that defines the relationship in your Model
            'attribute' => 'src', // foreign key attribute that is shown to user
            'model' => "App\Models\Video", // foreign key model
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ]);

        $this->crud->addField([
            'name' => 'status',
            'label' => 'وضعیت',
            'type' => 'checkbox',
            'hint' => 'در صورتی که تیک این قسمت را نزنید این محصول به کاربران نمایش داده نمیشود',
        ]);


        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'نام محصول',
            'type' => 'text'
        ]);

        $this->crud->addColumn([
            'name' => 'shop_id',
            'label' => 'فروشگاه',
            'type' => 'select',
            'entity' => 'shop', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Shop"// foreign key model
        ]);


        $this->crud->addColumn([
            'name' => 'discount',
            'label' => ' تخفیف',
            'type' => 'discount_text',

        ]);

        $this->crud->addColumn([
            'name' => 'discount_exp',
            'label' => 'انقضای تخفیف',
            'type' => 'text',

        ]);


        $this->crud->addColumn([
            'name' => 'price',
            'label' => 'قیمت محصول',
            'type' => 'price_text',

        ]);
        $this->crud->addColumn([
            'name' => 'status',
            'label' => ' وضعیت',
            'type' => 'check',

        ]);


        $this->crud->addColumn(
            [
                'label' => "تاریخ افزودن",
                'type' => 'model_function',
                'function_name' => 'getCreatedAt', // the method in your Model
            ]
        );



//        dd($this->crud->getEntries());
//        dd($this->crud->getEntries());
//        dd(Product::rep()->get());

//        $this->crud->addClause('rep');

        $shops = Auth::user()->shops;
        $this->crud->query = $this->crud->query->join('shops','shops.id','products.shop_id')->join('shop_user','shop_user.shop_id','shops.id')->where('shop_user.user_id',Auth::user()->id)->select('products.*');
        $this->crud->addFilter([ // simple filter
            'type' => 'dropdown',
            'name' => 'shop_id',
            'label' => 'فروشگاه'
        ], function () use ($shops) {
            return $shops->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'products.shop_id', $value);
        });


//        dd($this->crud->query);











    }




    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        $this->syncTags($this->crud->entry, $request);
        $this->syncPhotos($this->crud->entry, $request);
        return $redirect_location;
    }


    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud();
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        $this->syncTags($this->crud->entry, $request);
        $this->syncPhotos($this->crud->entry, $request);
        return $redirect_location;
    }


    private function syncPhotos($product, $request)
    {
        if (!$request->has('images')) {
            $product->photos()->detach();
            return;
        }

        $allPhotoIds = array();
        if ($request->images > 0)

            foreach ($request->images as $photo) {

                $my_photo = Photo::where('photo', $photo)->first();
                if (!isset($my_photo)) {
                    $newPhoto = Photo::create(['photo' => $photo]);
                    $allPhotoIds[] = $newPhoto->id;
                } else {
                    $allPhotoIds[] = $my_photo->id;
                }

                $product->photos()->sync($allPhotoIds);
            }
    }


    private function syncTags($product, $request)
    {
        if (!$request->has('tags')) {
            $product->tags()->detach();
            return;
        }

        $allTagIds = array();
        if ($request->tags > 0)
            foreach ($request->tags as $tag) {
                $my_tag = Tag::where('name', $tag)->first();
                if (!isset($my_tag)) {
                    $newTag = Tag::create(['name' => $tag, 'slug' => $tag]);
                    $allTagIds[] = $newTag->id;
                } else {
                    $allTagIds[] = $my_tag->id;
                }

            }

        $product->tags()->sync($allTagIds);
    }
}
