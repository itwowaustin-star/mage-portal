<?php

namespace App\Http\Controllers;

use App\Models\PortalAdvisor;
use App\Models\PortalTeamDepartment;
use Inertia\Inertia;
use Inertia\Response;

class TeamController extends Controller
{
    public function __invoke(): Response
    {
        $members = PortalAdvisor::query()
            ->visible()
            ->orderBy('id')
            ->get()
            ->map(fn (PortalAdvisor $advisor) => [
                'name' => $advisor->name,
                'title' => $advisor->otherInfo,
                'expertise' => $advisor->expertise,
                'phone' => $advisor->phone,
                'wechat' => $advisor->wechat,
            ]);

        $pillars = PortalTeamDepartment::query()
            ->visible()
            ->orderBy('id')
            ->get()
            ->map(fn (PortalTeamDepartment $department) => [
                'title' => $department->department_name,
                'body' => trim($department->summary) !== '' ? $department->summary : $department->leader_cert,
            ]);

        return Inertia::render('Team/Index', [
            'members' => $members,
            'pillars' => $pillars,
        ]);
    }
}
