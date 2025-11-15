<?php

namespace App\Http\Controllers;

use App\Models\PortalProject;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        $services = PortalProject::query()
            ->visible()
            ->latest('id')
            ->get()
            ->map(fn (PortalProject $project) => [
                'title' => $project->title,
                'slug' => $project->slug,
                'description' => $project->description,
                'excerpt' => $project->excerpt,
                'tags' => $project->tag_list,
                'image' => $project->image_url,
            ]);

        return Inertia::render('Services/Index', [
            'services' => $services,
        ]);
    }

    public function show(PortalProject $service): Response
    {
        return Inertia::render('Services/Show', [
            'service' => [
                'title' => $service->title,
                'slug' => $service->slug,
                'description' => $service->description,
                'content' => $service->content,
                'tags' => $service->tag_list,
                'image' => $service->image_url,
            ],
        ]);
    }
}
