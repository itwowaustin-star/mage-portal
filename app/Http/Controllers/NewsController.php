<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Support\PortalMedia;
use Inertia\Inertia;
use Inertia\Response;

class NewsController extends Controller
{
    public function index(): Response
    {
        $news = News::active()
            ->recent()
            ->paginate(9);

        $news->transform(function (News $article) {
            return [
                'id' => $article->id,
                'title' => $article->title,
                'description' => $article->description,
                'image' => $article->image ? PortalMedia::url($article->image) : null,
                'created_at' => $article->createtime,
            ];
        });

        return Inertia::render('News/Index', [
            'news' => $news,
        ]);
    }

    public function show(int $id): Response
    {
        $article = News::active()
            ->findOrFail($id);

        $relatedNews = News::active()
            ->where('id', '!=', $id)
            ->recent()
            ->limit(3)
            ->get()
            ->map(function (News $item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'image' => $item->image ? PortalMedia::url($item->image) : null,
                    'created_at' => $item->createtime,
                ];
            });

        return Inertia::render('News/Show', [
            'article' => [
                'id' => $article->id,
                'title' => $article->title,
                'description' => $article->description,
                'content' => $article->content,
                'image' => $article->image ? PortalMedia::url($article->image) : null,
                'created_at' => $article->createtime,
            ],
            'relatedNews' => $relatedNews,
        ]);
    }
}
