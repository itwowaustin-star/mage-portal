<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Mail\ContactSubmissionReceived;
use App\Models\ContactSubmission;
use App\Models\PortalAdvisor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        $primaryAdvisor = PortalAdvisor::query()
            ->visible()
            ->orderBy('id')
            ->first();

        $advisors = PortalAdvisor::query()
            ->visible()
            ->orderBy('id')
            ->get()
            ->map(fn (PortalAdvisor $advisor) => [
                'name' => $advisor->name,
                'title' => $advisor->otherInfo,
                'phone' => $advisor->phone,
                'wechat' => $advisor->wechat,
                'expertise' => $advisor->expertise,
            ]);

        return Inertia::render('Contact/Index', [
            'contact' => [
                'phone' => $primaryAdvisor?->phone ?? '暂无',
                'email' => 'contact@magenetwork.cn',
                'address' => '山西省朔州市开发区恒晟大厦 1204/1304/1703',
                'hours' => '数据维护与关键任务支持 7×24',
                'wechat' => $primaryAdvisor?->wechat ?? '',
                'advisor' => $primaryAdvisor?->name,
            ],
            'cta' => [
                'title' => '有项目需求或想要方案？',
                'description' => '提交后将同步给驻场顾问，确保需求状态在各渠道保持一致。',
            ],
            'advisors' => $advisors,
        ]);
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        $submission = ContactSubmission::create($request->validated());

        if ($address = config('mail.from.address')) {
            Mail::to($address)->queue(new ContactSubmissionReceived($submission));
        }

        return redirect()
            ->back()
            ->with('flash', [
                'type' => 'success',
                'message' => '信息提交成功，我们的顾问会尽快与您取得联系。',
            ]);
    }
}
