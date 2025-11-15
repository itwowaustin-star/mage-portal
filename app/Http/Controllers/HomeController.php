<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\News;
use App\Models\PortalAdvisor;
use App\Models\PortalProject;
use App\Support\PortalMedia;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __invoke(): Response
    {
        $settings = DB::connection('portal')
            ->table('mg_config')
            ->pluck('value', 'name')
            ->all();

        $companyName = $settings['name'] ?? '山西马格网络科技有限公司';
        $projectQuery = PortalProject::query()->visible();

        $services = (clone $projectQuery)
            ->latest('id')
            ->limit(6)
            ->get()
            ->map(fn (PortalProject $project) => [
                'title' => $project->title,
                'slug' => $project->slug,
                'excerpt' => $project->excerpt,
                'tags' => $project->tag_list,
                'image' => $project->image_url,
            ]);

        $cases = (clone $projectQuery)
            ->latest('id')
            ->limit(4)
            ->get()
            ->map(fn (PortalProject $project) => [
                'title' => $project->title,
                'slug' => $project->slug,
                'excerpt' => $project->excerpt,
                'tags' => $project->tag_list,
                'image' => $project->image_url,
            ]);

        $industries = $this->uniqueTags($projectQuery->pluck('tags'))
            ->map(fn (string $tag) => [
                'name' => $tag,
                'category' => '核心关键词',
                'logo_url' => null,
            ])
            ->take(8);

        $advisorQuery = PortalAdvisor::query()->visible();

        $team = (clone $advisorQuery)
            ->orderBy('id')
            ->limit(4)
            ->get()
            ->map(fn (PortalAdvisor $advisor) => [
                'name' => $advisor->name,
                'title' => $advisor->otherInfo,
                'phone' => $advisor->phone,
                'wechat' => $advisor->wechat,
                'expertise' => $advisor->expertise,
            ]);

        $banner = DB::connection('portal')
            ->table('mg_banner')
            ->orderByDesc('id')
            ->first();

        $bannerUrl = $banner?->image ? PortalMedia::url($banner->image) : null;

        // Get news articles
        $news = News::active()
            ->recent()
            ->limit(3)
            ->get()
            ->map(fn (News $article) => [
                'id' => $article->id,
                'title' => $article->title,
                'description' => $article->description,
                'image' => $article->image ? PortalMedia::url($article->image) : null,
                'created_at' => $article->createtime,
            ]);

        // Get FAQs
        $faqs = Faq::active()
            ->recent()
            ->limit(6)
            ->get()
            ->map(fn (Faq $faq) => [
                'id' => $faq->id,
                'title' => $faq->title,
                'content' => $faq->content,
            ]);

        return Inertia::render('Home/Index', [
            'hero' => [
                'title' => $companyName,
                'subtitle' => '网络安全、弱电工程、软件开发与机房运维一体化交付',
                'description' => '所有展示内容与后台实时同步，确保项目标签、服务描述与联系人信息保持统一。',
                'banner' => $bannerUrl,
                'stats' => [
                    ['label' => '典型项目', 'value' => $projectQuery->count().' 个'],
                    ['label' => '顾问团队', 'value' => (clone $advisorQuery)->count().' 位'],
                    ['label' => '行业标签', 'value' => $industries->count().' 个'],
                ],
            ],
            'services' => $services,
            'cases' => $cases,
            'industries' => $industries,
            'team' => $team,
            'news' => $news,
            'faqs' => $faqs,
            'contact' => [
                'phone' => '0349-2288789',
                'emails' => ['sxmgwl@163.com', 'itaustin@163.com'],
            ],
        ]);
    }

    /**
     * @param  Collection<int, string|null>  $rawTags
     * @return Collection<int, string>
     */
    protected function uniqueTags(Collection $rawTags): Collection
    {
        return $rawTags
            ->flatMap(function (?string $tags) {
                return collect(explode(',', (string) $tags))
                    ->map(fn (string $tag) => trim($tag))
                    ->filter();
            })
            ->unique()
            ->values();
    }
}
