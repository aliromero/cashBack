<?php

namespace App\Http\Controllers;

use App\Models\Battery;
use App\Models\News;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function sitemap()
    {
        // create new sitemap object
        $sitemap = App::make("sitemap");

        // set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
        // by default cache is disabled
//        $sitemap->setCache('laravel.sitemap', 60);

        // check if there is cached sitemap and build new only if is not
        if (!$sitemap->isCached())
        {
            // add item to the sitemap (url, date, priority, freq)
            $sitemap->add(URL::to('/'), Setting::orderBy('updated_at', 'desc')->first()->getLastUpdate2(), '0.8', 'yearly');
            $sitemap->add(URL::to('page/about'), Page::where('slug', 'about')->first()->getLastUpdate2(), '0.9', 'monthly');
            $sitemap->add(URL::to('batteries'), Battery::orderBy('updated_at', 'desc')->first()->getLastUpdate2(), '0.9', 'daily');
            $sitemap->add(URL::to('news'), News::orderBy('updated_at', 'desc')->first()->getLastUpdate2(), '1.0', 'daily');


            // add item with images


            // get all posts from db
            $posts = DB::table('news')->orderBy('created_at', 'desc')->get();

            // add every post to the sitemap
            foreach ($posts as $post)
            {
                $sitemap->add($post->slug, $post->updated_at, "1.0", "daily");
            }
        }

        // show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $sitemap->render('html');
    }
}
