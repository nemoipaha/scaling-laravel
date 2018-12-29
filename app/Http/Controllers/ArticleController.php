<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show($id)
    {
        $article = Article::findOrFail($id);

        return response()
            ->json($article)
            ->header('ETag', md5($article->title . $article->body));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        $article = Article::findOrFail($id);

        // Check Article Version Given
        $clientVersion = $request->header('If-Match');
        $currentVersion = md5($article->title . $article->body);

        if ($clientVersion !== $currentVersion) {
            return abort(412, "Precondition Failed");
        }

        // Update the article
        $article->title = request('title');
        $article->body = request('body');
        $article->save();

        return $article;
    }
}
