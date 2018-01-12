<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Backpack Crud Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used by the CRUD interface.
    | You are free to change them to anything
    | you want to customize your views to better match your application.
    |
    */

    // Forms
    'save_action_save_and_new' => 'ذخیره و افزودن مورد جدید',
    'save_action_save_and_edit' => 'ذخیره و ویرایش همین مورد',
    'save_action_save_and_back' => 'ذخیره و برگشت',
    'save_action_changed_notification' => 'Default behaviour after saving has been changed.',

    // Create form
    'add' => 'افزودن',
    'back_to_all' => 'برگشت به همه ',
    'cancel' => 'انصراف',
    'add_a_new' => 'اضافه کردن ',

    // Edit form
    'edit' => 'ویرایش',
    'save' => 'ذخیره',

    // Revisions
    'revisions' => 'بازنگری',
    'no_revisions' => 'بازنگری موجود نیست',
    'created_this' => 'ایجاد',
    'changed_the' => 'ویرایش شده',
    'restore_this_value' => 'بازیابی مقدار',
    'from' => 'از',
    'to' => 'به',
    'undo' => 'برگشت',
    'revision_restored' => 'بازنگری با موفیت بازیابی شد',

    // CRUD table view
    'all' => 'همه ',
    'in_the_database' => 'داخل بانک اطلاعاتی',
    'list' => 'لیست',
    'actions' => 'عملیات',
    'preview' => 'پیش نمایش',
    'delete' => 'حذف',
    'admin' => 'مدیر',
    'details_row' => 'این ردیف جزییات میباشد . ویراش کنید برای خودتان',
    'details_row_loading_error' => 'خطایی رخ داد لطفا مجدد تلاش کنید .',

    // Confirmation messages and bubbles
    'delete_confirm' => 'آیا از حذف این مورد اطمینان دارید؟',
    'delete_confirmation_title' => 'حذف مورد',
    'delete_confirmation_message' => 'این مورد با موفقیت حذف شد.',
    'delete_confirmation_not_title' => 'حذف نشد!',
    'delete_confirmation_not_message' => "احتمالا مشکلی وجود دارد! این مورد قابل حذف نیست.",
    'delete_confirmation_not_deleted_title' => 'حذف نشد!',
    'delete_confirmation_not_deleted_message' => 'هیچ اتفاقی نیفتاد. مورد شما امن است.',


    // Confirmation messages and bubbles
    'read_confirm' => 'آیا از تغییر وضعیت این مورد اطمینان دارید؟',
    'read_confirmation_title' => 'ویرایش مورد',
    'read_confirmation_message' => 'این مورد با موفقیت ویرایش شد.',
    'read_confirmation_not_title' => 'ویرایش نشد!',
    'read_confirmation_not_message' => "احتمالا مشکلی وجود دارد! این مورد قابل ویرایش نیست.",
    'read_confirmation_not_read_title' => 'ویرایش نشد!',
    'read_confirmation_not_read_message' => 'هیچ اتفاقی نیفتاد. مورد شما امن است.',

    // DataTables translation
    'emptyTable' => 'اطلاعاتی در جدول موجود نیست',
    'info' => 'نمایش _START_ تا _END_ از _TOTAL_ ورودی',
    'infoEmpty' => 'نمایش 0 تا 0 از 0 ورودی',
    'infoFiltered' => '(فیلترشده از _MAX_ کل ورودی)',
    'infoPostFix' => '',
    'thousands' => ',',
    'lengthMenu' => '_MENU_ رکوردها در هر صفحه',
    'loadingRecords' => 'منتظر باشید...',
    'processing' => 'درحال پردازش...',
    'search' => 'جستجو: ',
    'zeroRecords' => 'رکوردی یافت نشد.',
    'paginate' => [
        'first' => 'ابتدا',
        'last' => 'انتها',
        'next' => 'بعدی',
        'previous' => 'قبلی',
    ],
    'aria' => [
        'sortAscending' => ': فعال شدن ستون ترتیب صعودی ',
        'sortDescending' => ': فعال شدن ستون ترتیب نزولی',
    ],

    // global crud - errors
    'unauthorized_access' => 'دسترسی غیر مجاز . برای دسترسی به این صفحه مجوز لازم را ندارید.',
    'please_fix' => 'برای رفع خطا دنبال کنید:',

    // global crud - success / error notification bubbles
    'insert_success' => 'این مورد با موفقیت افزوده شد.',
    'update_success' => 'این مورد با موفقیت ویرایش شد.',


    // CRUD filters navbar view
    'filters' => 'فیلترها',
    'toggle_filters' => 'Toggle filters',
    'remove_filters' => 'حذف فیلترها',


    // CRUD reorder view
    'reorder' => 'مرتب کردن',
    'reorder_text' => 'استفاده از کشیدن و رها کردن برای مرتب سازی',
    'reorder_success_title' => 'انجام شد',
    'reorder_success_message' => 'ترتیب شما ذخیره شد.',
    'reorder_error_title' => 'خطا',
    'reorder_error_message' => 'خطا! ترتیب شما ذخیره نشد.',

    // CRUD yes/no
    'yes' => 'بله',
    'no' => 'خیر',

    // Fields
    'browse_uploads' => 'انتخاب فایل',
    'clear' => 'پاک',
    'page_link' => 'لینک صفحه',
    'page_link_placeholder' => 'http://example.com/your-desired-page',
    'internal_link' => 'لینک داخلی',
    'internal_link_placeholder' => 'Internal slug. مثال: \'admin/page\' (no quotes) for \':url\'',
    'external_link' => 'لینک خارجی',
    'choose_file' => 'انتخاب فایل',

    //Table field
    'table_cant_add' => 'قابل اضافه شدن نیست :entity',
    'table_max_reached' => 'بیشترین تعداد از :max reached',

    // File manager
    'file_manager' => 'مدیریت فایل',
];
