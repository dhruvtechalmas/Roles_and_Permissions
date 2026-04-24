<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;



class ArticleController extends Controller implements HasMiddleware
{

    public static  function middleware(): array
    {
        return [
            new Middleware('permission:view articles', only: ['articles.index']),
            new Middleware('permission:view articles', only: ['articles.edit']),
            new Middleware('permission:view articles', only: ['articles.create']),
            new Middleware('permission:view articles', only: ['articles.destroy'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::latest()->paginate(25); //  latest() Means Order BY Created_at DESC
        return view('articles.list', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'title' => 'required|min:3',
            'author' => 'required|min:3'
        ]);

        if ($validator->passes()) {

            $article = new Article();
            $article->title = $request->title;
            $article->text = $request->text;
            $article->author = $request->author;
            $article->save();

            return redirect()->route('articles.index')->with('success', 'Article Added Successfully');
        } else {

            return redirect()->route('articles.create')->withInput()->withErrors($validator);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::findorfail($id);

        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $article = Article::findorfail($id);

        $validator = Validator::make($request->all(), [

            'title' => 'required|min:3',
            'author' => 'required|min:3'
        ]);

        if ($validator->passes()) {

            $article->title = $request->title;
            $article->text = $request->text;
            $article->author = $request->author;
            $article->save();

            return redirect()->route('articles.index')->with('success', 'Article Update Successfully');
        } else {

            return redirect()->route('articles.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $article = Article::find($request->id);

        if ($article == null) {
            session()->flash('error', 'Article Not Found');
            return response()->json([
                'status' => false
            ]);
        }

        $article->delete();

        session()->flash('success', 'Article Deleted SuccessFully');
        return response()->json([
            'status' => true
        ]);
    }
}
