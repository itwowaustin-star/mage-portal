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

    Schema::connection('portal')->dropIfExists('mg_news');
    Schema::connection('portal')->create('mg_news', function (Blueprint $table): void {
        $table->id();
        $table->string('title');
        $table->string('description')->nullable();
        $table->longText('content')->nullable();
        $table->string('image')->nullable();
        $table->string('status')->default('normal');
        $table->integer('weigh')->default(0);
        $table->integer('createtime')->nullable();
        $table->integer('updatetime')->nullable();
        $table->integer('deletetime')->nullable();
    });

    Schema::connection('portal')->dropIfExists('mg_faq');
    Schema::connection('portal')->create('mg_faq', function (Blueprint $table): void {
        $table->id();
        $table->string('title');
        $table->text('content');
        $table->boolean('isOpen')->default(true);
        $table->integer('createtime')->nullable();
        $table->integer('updatetime')->nullable();
        $table->integer('deletetime')->nullable();
    });

    Schema::connection('portal')->dropIfExists('mg_team');
    Schema::connection('portal')->create('mg_team', function (Blueprint $table): void {
        $table->id();
        $table->string('department_name');
        $table->string('leader_name')->nullable();
        $table->string('leader_cert')->nullable();
        $table->string('tags')->nullable();
        $table->text('content')->nullable();
        $table->text('summary')->nullable();
        $table->integer('deletetime')->nullable();
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

    DB::connection('portal')->table('mg_news')->insert([
        [
            'title' => '攻防演练圆满收官',
            'description' => '与多家央企联合完成攻防演练。',
            'content' => '<p>实战演练数据来源 portal.</p>',
            'status' => 'normal',
            'weigh' => 10,
            'createtime' => now()->subDays(2)->timestamp,
        ],
        [
            'title' => '零信任平台发布',
            'description' => '推出零信任防护平台。',
            'content' => '<p>零信任产品发布。</p>',
            'status' => 'normal',
            'weigh' => 8,
            'createtime' => now()->subWeek()->timestamp,
        ],
        [
            'title' => '政务云安全升级',
            'description' => '完成政务云关键区安全固化。',
            'content' => '<p>政务云安全升级。</p>',
            'status' => 'normal',
            'weigh' => 6,
            'createtime' => now()->subWeeks(2)->timestamp,
        ],
    ]);

    DB::connection('portal')->table('mg_faq')->insert([
        [
            'title' => '如何对接门户系统？',
            'content' => '<p>填写 API 凭证即可实时同步。</p>',
            'isOpen' => 1,
            'createtime' => now()->timestamp,
        ],
        [
            'title' => '项目多久更新一次？',
            'content' => '<p>每日凌晨自动同步。</p>',
            'isOpen' => 1,
            'createtime' => now()->subDay()->timestamp,
        ],
    ]);

    DB::connection('portal')->table('mg_team')->insert([
        [
            'department_name' => '网络安全运营中心',
            'leader_name' => '李强',
            'leader_cert' => 'CISP',
            'tags' => '安全运营,攻防演练',
            'summary' => '负责攻防演练、蓝队巡检与 SOC 运营。',
            'content' => '<p>核心团队负责 SOC 与攻防演练。</p>',
        ],
        [
            'department_name' => '弱电工程部',
            'leader_name' => '王敏',
            'leader_cert' => 'PMP',
            'tags' => '弱电,机房建设',
            'summary' => '聚焦机房改造与弱电一体化交付。',
            'content' => '<p>负责弱电施工。</p>',
        ],
    ]);
}
