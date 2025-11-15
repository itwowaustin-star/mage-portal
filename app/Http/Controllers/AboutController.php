<?php

namespace App\Http\Controllers;

use App\Models\PortalProject;
use App\Models\PortalTeamDepartment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function __invoke(): Response
    {
        $settings = DB::connection('portal')
            ->table('mg_config')
            ->pluck('value', 'name')
            ->all();

        $projects = PortalProject::query()->visible()->orderByDesc('createtime')->get();

        $timeline = $projects
            ->filter(fn (PortalProject $project) => $project->createtime !== null)
            ->groupBy(fn (PortalProject $project) => $project->createtime?->format('Y') ?? '近期')
            ->map(fn (Collection $group, string $year) => [
                'year' => $year,
                'title' => $group->first()?->title ?? '典型案例',
                'description' => $group->first()?->description ?? $group->first()?->excerpt,
            ])
            ->sortKeys()
            ->values()
            ->take(6);

        $positioning = $this->uniqueTags($projects->pluck('tags'))->take(6);

        $advantages = PortalTeamDepartment::query()
            ->visible()
            ->orderBy('id')
            ->get()
            ->map(fn (PortalTeamDepartment $department) => [
                'title' => $department->department_name,
                'description' => $department->summary !== '' ? $department->summary : ($department->leader_name.' · '.$department->leader_cert),
            ]);

        return Inertia::render('About/Index', [
            'company' => [
                'name' => $settings['name'] ?? '山西马格网络科技有限公司',
                'description' => '数据来自公司后台，覆盖网络安全、弱电工程、软件开发与机房运维项目。',
                'vision' => '让真实的数据驱动每一份交付，实现可验证、可运营、可持续的技术服务。',
                'mission' => '同步后台交付数据，保持现场项目信息与门户展示一致。',
                'positioning' => $positioning,
            ],
            'timeline' => $timeline,
            'advantages' => $advantages,
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
