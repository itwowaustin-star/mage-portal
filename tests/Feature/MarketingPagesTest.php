<?php

use App\Mail\ContactSubmissionReceived;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed();
    seedPortalData();
});

it('renders the home page with portal sourced data', function (): void {
    $response = $this->get('/');

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Home/Index')
            ->has('hero')
            ->has('services', 2)
            ->where('services.0.title', '麻家梁煤矿机房网络防护项目')
            ->has('cases', 2)
            ->has('industries')
            ->has('team', 2));
});

it('stores contact submissions and queues a notification email', function (): void {
    Mail::fake();
    config(['mail.from.address' => 'ops@example.com']);

    $payload = [
        'name' => '示例客户',
        'phone' => '0351-000-0000',
        'company' => '测试单位',
        'email' => 'guest@example.com',
        'content' => '需要了解机房改造与弱电联动方案。',
    ];

    $response = $this->post('/contact', $payload);

    $response->assertRedirect();

    $this->assertDatabaseHas('contact_submissions', [
        'name' => '示例客户',
        'phone' => '0351-000-0000',
        'company' => '测试单位',
    ]);

    Mail::assertQueued(ContactSubmissionReceived::class, function (ContactSubmissionReceived $mail): bool {
        return $mail->submission->name === '示例客户';
    });
});

function seedPortalData(): void
{
    Schema::connection('portal')->dropIfExists('mg_services');
    Schema::connection('portal')->create('mg_services', function (Blueprint $table): void {
        $table->id();
        $table->string('title');
        $table->string('tags')->nullable();
        $table->string('image')->nullable();
        $table->string('description');
        $table->text('content')->nullable();
        $table->integer('createtime')->nullable();
        $table->integer('updatetime')->nullable();
        $table->integer('deletetime')->nullable();
    });

    Schema::connection('portal')->dropIfExists('mg_personal');
    Schema::connection('portal')->create('mg_personal', function (Blueprint $table): void {
        $table->id();
        $table->string('name')->nullable();
        $table->string('phone')->nullable();
        $table->string('wechat')->nullable();
        $table->string('otherInfo')->nullable();
        $table->longText('content')->nullable();
        $table->integer('createtime')->nullable();
        $table->integer('updatetime')->nullable();
        $table->integer('deletetime')->nullable();
    });

    Schema::connection('portal')->dropIfExists('mg_banner');
    Schema::connection('portal')->create('mg_banner', function (Blueprint $table): void {
        $table->id();
        $table->string('image')->nullable();
        $table->string('linkhref')->nullable();
    });

    Schema::connection('portal')->dropIfExists('mg_config');
    Schema::connection('portal')->create('mg_config', function (Blueprint $table): void {
        $table->string('name')->primary();
        $table->string('value')->nullable();
    });

    DB::connection('portal')->table('mg_config')->insert([
        ['name' => 'name', 'value' => '山西马格网络科技有限公司'],
    ]);

    DB::connection('portal')->table('mg_banner')->insert([
        ['image' => '/uploads/banner.png'],
    ]);

    DB::connection('portal')->table('mg_services')->insert([
        [
            'title' => '山阴县医疗集团人民医院网络安全等保项目',
            'tags' => '等保,网络安全,医院',
            'image' => null,
            'description' => '项目帮助医院完成等保整改。',
            'content' => '<p>真实来源：mg_services 第一条。</p>',
            'createtime' => now()->timestamp,
        ],
        [
            'title' => '麻家梁煤矿机房网络防护项目',
            'tags' => '煤矿,网络安全,机房',
            'image' => null,
            'description' => '煤矿网络防护能力建设。',
            'content' => '<p>真实来源：mg_services 第二条。</p>',
            'createtime' => now()->subDays(10)->timestamp,
        ],
    ]);

    DB::connection('portal')->table('mg_personal')->insert([
        [
            'name' => '杨丽军',
            'phone' => '18200000000',
            'wechat' => 'itaustin',
            'otherInfo' => '产品技术部部长',
            'content' => '<p>擅长网络安全</p>',
        ],
        [
            'name' => '田瑞国',
            'phone' => '18500000000',
            'wechat' => 'undo-1030',
            'otherInfo' => '信息安全部部长',
            'content' => '<p>擅长渗透测试</p>',
        ],
    ]);
}
