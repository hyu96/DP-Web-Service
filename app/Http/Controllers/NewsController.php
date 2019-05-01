<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function index()
    {
        $newsList = News::all();
    	return view('admin.news.index')->with([
            'newsList' => $newsList
        ]);
    }

    public function create()
    {
    	return view('admin.news.create');
    }

    public function store(Request $request)
    {
    	$messages = [
    		'title.required' => 'Tiêu đề không được để trống',
    		'image.required' => 'Ảnh hoạt động không được để trống',
    		'image.image' => 'Ảnh không hợp lệ',
    		'link.required' => 'Đường dẫn không được để trống',
    		'publish.required' => 'Tiêu đề không được để trống'
    	];

    	$validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image'],
            'link' => ['required', 'string', 'max:255'],
            'publish' => ['required', 'boolean'],
        ], $messages)->validate();
        $path = Storage::disk('news')->put($request->file('image')->getClientOriginalName(). '-'. Carbon::now()->timestamp, $request->file('image'));
    	News::create([
    		'title' => $request->title,
    		'image' => $path,
    		'link' => $request->link,
    		'publish' => $request->publish
    	]);

    	return redirect()->route('admin.news.index');
    }

    public function show($id)
    {
        $news = News::find($id);
        return view('admin.news.show')->with([
            'news' => $news
        ]);
    }
}
