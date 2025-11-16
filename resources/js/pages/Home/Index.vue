<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

interface HeroStat {
    label: string;
    value: string;
}

interface HeroContent {
    title: string;
    subtitle: string;
    description: string;
    banner: string | null;
    stats: HeroStat[];
}

interface ServiceCard {
    title: string;
    slug: string;
    excerpt: string;
    description?: string;
    tags: string[];
    image: string | null;
}

interface IndustryBadge {
    name: string;
    category: string;
    logo_url: string | null;
}

interface AdvisorCard {
    name: string;
    title: string;
    phone: string | null;
    wechat: string | null;
    expertise: string;
}

interface NewsArticle {
    id: number;
    title: string;
    description: string;
    image: string | null;
    created_at: number;
}

interface FaqItem {
    id: number;
    title: string;
    content: string;
}

const props = defineProps<{
    hero: HeroContent;
    services: ServiceCard[];
    cases: ServiceCard[];
    industries: IndustryBadge[];
    team: AdvisorCard[];
    news: NewsArticle[];
    faqs: FaqItem[];
    contact: { phone: string; emails: string[] };
}>();

const expandedFaq = ref<number | null>(null);
const activeNewsTab = ref<string>('all');

const servicesWithImages = computed(() =>
    props.services.filter((service) => Boolean(service.image)),
);
const hasServicesWithImages = computed(
    () => servicesWithImages.value.length > 0,
);
</script>

<template>
    <MarketingLayout>
        <Head title="山西马格网络1 · TechOps 门户" />

        <!-- Hero Section -->
        <section
            class="relative overflow-hidden bg-gradient-to-br from-sky-50 via-white to-blue-50"
        >
            <!-- 背景光照效果 -->
            <div class="absolute inset-0">
                <div
                    class="absolute top-0 left-1/4 h-96 w-96 animate-pulse rounded-full bg-blue-300/30 opacity-40 blur-3xl"
                ></div>
                <div
                    class="absolute right-1/4 bottom-0 h-80 w-80 animate-pulse rounded-full bg-blue-100/40 opacity-30 blur-3xl"
                    style="animation-delay: 1s"
                ></div>
            </div>
            <div class="relative py-20">
                <div
                    class="mx-auto grid w-full max-w-6xl gap-12 px-6 lg:grid-cols-[1fr,1fr] lg:items-center"
                >
                    <div>
                        <p
                            class="text-xs font-semibold tracking-[0.45em] text-blue-600 uppercase"
                        >
                            网络安全 · 开发运维
                        </p>
                        <h1
                            class="mt-5 text-4xl leading-tight font-bold text-slate-900 drop-shadow-lg lg:text-5xl"
                        >
                            {{ props.hero.title }}
                        </h1>
                        <p class="mt-4 text-lg text-slate-700">
                            {{ props.hero.subtitle }}
                        </p>
                        <p class="mt-3 text-base leading-relaxed text-gray-600">
                            {{ props.hero.description }}
                        </p>
                        <div class="mt-8 flex flex-wrap gap-4">
                            <Link
                                href="/services"
                                class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 px-8 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-400/50 transition hover:scale-105 hover:shadow-blue-400/80"
                            >
                                查看能力矩阵
                            </Link>
                            <Link
                                href="/contact"
                                class="rounded-lg border border-blue-200/80 bg-white/80 px-8 py-3 text-sm font-semibold text-blue-700 shadow-sm transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-800"
                            >
                                安排顾问对接
                            </Link>
                        </div>
                        <dl
                            class="mt-10 grid gap-6 rounded-2xl border border-blue-100 bg-white/80 p-6 shadow-xl shadow-blue-100/70 backdrop-blur sm:grid-cols-3"
                        >
                            <div
                                v-for="stat in props.hero.stats"
                                :key="stat.label"
                            >
                                <dt
                                    class="text-xs tracking-widest text-slate-500 uppercase"
                                >
                                    {{ stat.label }}
                                </dt>
                                <dd
                                    class="mt-2 text-3xl font-bold text-blue-600"
                                >
                                    {{ stat.value }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                    <div
                        class="rounded-2xl border border-blue-100 bg-white/85 p-6 shadow-2xl shadow-blue-100/60 backdrop-blur"
                    >
                        <img
                            v-if="props.hero.banner"
                            :src="props.hero.banner"
                            alt="Hero Banner"
                            class="h-80 w-full rounded-xl border border-blue-100 object-cover"
                        />
                        <div
                            v-else
                            class="flex h-80 items-center justify-center rounded-xl bg-blue-50 text-blue-500"
                        >
                            正在同步最新战报…
                        </div>
                        <p class="mt-4 text-sm text-gray-600">
                            情报、方案、迭代计划都由统一平台驱动，任何外部展示都能追溯到同一份事实源。
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Project Gallery -->
        <section
            class="bg-gradient-to-b from-white via-blue-50/60 to-blue-100/30 py-20"
        >
            <div
                class="mx-auto flex w-full max-w-6xl flex-col gap-4 px-6 lg:flex-row lg:items-end lg:justify-between"
            >
                <div>
                    <p
                        class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                    >
                        项目展示
                    </p>
                    <h2 class="mt-2 text-3xl font-bold text-slate-900">
                        高光项目图集
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        仅展示带有现场视觉素材的项目，体现我们在能源、政务、文旅等行业的真实落地能力。
                    </p>
                </div>
                <Link
                    href="/services"
                    class="text-sm font-semibold text-blue-600 hover:text-blue-700"
                    >全部项目 →</Link
                >
            </div>
            <div
                v-if="hasServicesWithImages"
                class="mx-auto mt-10 grid w-full max-w-6xl gap-6 px-6 lg:grid-cols-3"
            >
                <article
                    v-for="service in servicesWithImages"
                    :key="service.slug"
                    class="flex h-full flex-col rounded-2xl border border-blue-100 bg-white/95 p-5 shadow-lg shadow-blue-100/80 transition hover:-translate-y-1 hover:shadow-xl"
                >
                    <img
                        :src="service.image!"
                        :alt="service.title"
                        class="h-44 w-full rounded-xl border border-blue-100 object-cover"
                    />
                    <div class="mt-4 flex flex-1 flex-col">
                        <p
                            class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                        >
                            PROJECT
                        </p>
                        <h3 class="mt-2 text-xl font-bold text-slate-900">
                            {{ service.title }}
                        </h3>
                        <p class="mt-2 flex-1 text-sm text-gray-600">
                            {{ service.excerpt }}
                        </p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span
                                v-for="tag in service.tags"
                                :key="`${service.slug}-${tag}`"
                                class="rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700"
                            >
                                {{ tag }}
                            </span>
                        </div>
                        <Link
                            :href="`/services/${service.slug}`"
                            class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700"
                        >
                            查看详情
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </Link>
                    </div>
                </article>
            </div>
            <p
                v-else
                class="mx-auto mt-10 w-full max-w-6xl px-6 text-center text-sm text-slate-500"
            >
                当前暂无带图片的项目案例，欢迎稍后再来查看。
            </p>
        </section>

        <!-- Value Proposition Section -->
        <section class="bg-white py-20">
            <div class="mx-auto w-full max-w-6xl px-6">
                <div class="mb-16 text-center">
                    <p
                        class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                    >
                        为什么选择我们
                    </p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">
                        让您的业务更安全、更高效
                    </h2>
                </div>

                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Card 1: Security -->
                    <article
                        class="group rounded-2xl border border-blue-100 bg-white/95 p-6 shadow-lg shadow-blue-100/70 transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="w-fit rounded-2xl bg-blue-50 p-3 text-blue-600 ring-1 ring-blue-100"
                        >
                            <svg
                                class="h-6 w-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                />
                            </svg>
                        </div>
                        <h3
                            class="mt-4 text-lg font-bold text-slate-900 transition group-hover:text-blue-700"
                        >
                            全方位安全保护
                        </h3>
                        <p class="mt-2 text-sm text-slate-500">
                            从网络边界到数据中心，从威胁检测到应急响应，提供一站式网络安全解决方案
                        </p>
                    </article>

                    <!-- Card 2: Reliability -->
                    <article
                        class="group rounded-2xl border border-blue-100 bg-white/95 p-6 shadow-lg shadow-blue-100/70 transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="w-fit rounded-2xl bg-blue-50 p-3 text-blue-600 ring-1 ring-blue-100"
                        >
                            <svg
                                class="h-6 w-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"
                                />
                            </svg>
                        </div>
                        <h3
                            class="mt-4 text-lg font-bold text-slate-900 transition group-hover:text-blue-700"
                        >
                            7×24 可靠保障
                        </h3>
                        <p class="mt-2 text-sm text-slate-500">
                            全天候现场值守和云端支援，确保您的业务连续性和数据安全无忧
                        </p>
                    </article>

                    <!-- Card 3: Efficiency -->
                    <article
                        class="group rounded-2xl border border-blue-100 bg-white/95 p-6 shadow-lg shadow-blue-100/70 transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="w-fit rounded-2xl bg-blue-50 p-3 text-blue-600 ring-1 ring-blue-100"
                        >
                            <svg
                                class="h-6 w-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"
                                />
                            </svg>
                        </div>
                        <h3
                            class="mt-4 text-lg font-bold text-slate-900 transition group-hover:text-blue-700"
                        >
                            提升运维效率
                        </h3>
                        <p class="mt-2 text-sm text-slate-500">
                            自动化管理工具和数据驾驶舱，让您的团队专注于战略发展而非日常运维
                        </p>
                    </article>

                    <!-- Card 4: Compliance -->
                    <article
                        class="group rounded-2xl border border-blue-100 bg-white/95 p-6 shadow-lg shadow-blue-100/70 transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="w-fit rounded-2xl bg-blue-50 p-3 text-blue-600 ring-1 ring-blue-100"
                        >
                            <svg
                                class="h-6 w-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                        <h3
                            class="mt-4 text-lg font-bold text-slate-900 transition group-hover:text-blue-700"
                        >
                            合规性认证
                        </h3>
                        <p class="mt-2 text-sm text-slate-500">
                            通过 CCRC
                            安全认证，满足等保、行业监管等多项要求，让合规建设有据可循
                        </p>
                    </article>

                    <!-- Card 5: Support -->
                    <article
                        class="group rounded-2xl border border-blue-100 bg-white/95 p-6 shadow-lg shadow-blue-100/70 transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="w-fit rounded-2xl bg-blue-50 p-3 text-blue-600 ring-1 ring-blue-100"
                        >
                            <svg
                                class="h-6 w-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"
                                />
                            </svg>
                        </div>
                        <h3
                            class="mt-4 text-lg font-bold text-slate-900 transition group-hover:text-blue-700"
                        >
                            专业顾问支持
                        </h3>
                        <p class="mt-2 text-sm text-slate-500">
                            由资深安全专家组成的顾问团队，为您的业务规划提供专业建议和技术指导
                        </p>
                    </article>

                    <!-- Card 6: Results -->
                    <article
                        class="group rounded-2xl border border-blue-100 bg-white/95 p-6 shadow-lg shadow-blue-100/70 transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="w-fit rounded-2xl bg-blue-50 p-3 text-blue-600 ring-1 ring-blue-100"
                        >
                            <svg
                                class="h-6 w-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                />
                            </svg>
                        </div>
                        <h3
                            class="mt-4 text-lg font-bold text-slate-900 transition group-hover:text-blue-700"
                        >
                            可量化成果
                        </h3>
                        <p class="mt-2 text-sm text-slate-500">
                            从安全事件预防率、系统可用性到成本节省，我们用数据说话，让投资回报清晰可见
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <!-- Certifications -->
        <section class="bg-white py-16">
            <div class="mx-auto w-full max-w-6xl px-6">
                <div class="text-center">
                    <p
                        class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                    >
                        安全认证
                    </p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">
                        安全资质一目了然
                    </h2>
                    <p class="mt-2 text-sm text-gray-600">
                        我们在安全集成与安全运维方向具备成熟交付能力，欢迎随时查阅官方认证。
                    </p>
                </div>
                <div class="mt-10 grid gap-8 md:grid-cols-2">
                    <article
                        class="rounded-2xl border border-blue-100 bg-white/95 p-10 shadow-xl shadow-blue-100/70 transition hover:-translate-y-1 hover:shadow-2xl"
                    >
                        <div
                            class="flex flex-col items-center gap-6 text-center"
                        >
                            <img
                                src="/security-integration.png"
                                alt="CCRC 安全集成资质"
                                class="h-96 w-full rounded-xl border border-blue-50 bg-white object-contain"
                            />
                            <p class="text-xl font-bold text-blue-700">
                                CCRC 安全集成资质
                            </p>
                            <p class="text-sm text-gray-600">
                                通过中国网络安全审查技术与认证中心（CCRC）的安全集成认证，证明我们具备端到端的规划与落地能力。
                            </p>
                        </div>
                    </article>
                    <article
                        class="rounded-2xl border border-blue-100 bg-white/95 p-10 shadow-xl shadow-blue-100/70 transition hover:-translate-y-1 hover:shadow-2xl"
                    >
                        <div
                            class="flex flex-col items-center gap-6 text-center"
                        >
                            <img
                                src="/security-operations.png"
                                alt="CCRC 安全运维资质"
                                class="h-96 w-full rounded-xl border border-blue-50 bg-white object-contain"
                            />
                            <p class="text-xl font-bold text-blue-700">
                                CCRC 安全运维资质
                            </p>
                            <p class="text-sm text-gray-600">
                                获得 CCRC
                                安全运维专业能力认证，意味着我们能为长期托管、应急响应等场景提供权威保障。
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-white py-16 text-slate-900">
            <div
                class="mx-auto flex w-full max-w-5xl flex-col items-center gap-5 px-6 text-center"
            >
                <p
                    class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                >
                    联系我们
                </p>
                <h2 class="text-3xl font-bold text-slate-900 lg:text-4xl">
                    让网络安全与软件研发同频共振
                </h2>
                <p class="max-w-3xl text-gray-600">
                    告诉我们你正在推进的场景，我们会基于统一的数据底座提供攻防策略、运维方案与软件迭代蓝图。
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <Link
                        href="/contact"
                        class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 px-8 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-400/50 transition hover:scale-105 hover:shadow-blue-400/80"
                    >
                        填写需求
                    </Link>
                    <Link
                        href="/services"
                        class="rounded-lg border border-blue-200 bg-white/80 px-8 py-3 text-sm font-semibold text-blue-700 shadow-sm transition hover:bg-blue-50 hover:text-blue-800"
                    >
                        查看项目图谱
                    </Link>
                </div>
            </div>
        </section>
        <!-- News & Resources Section -->
        <section class="bg-white py-20">
            <div class="mx-auto w-full max-w-6xl px-6">
                <!-- Header -->
                <div class="mb-12">
                    <div
                        class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between"
                    >
                        <div>
                            <p
                                class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                            >
                                资讯动态
                            </p>
                            <h2 class="mt-3 text-3xl font-bold text-slate-900">
                                新闻 · 技术 · 观点
                            </h2>
                        </div>
                        <Link
                            href="/news"
                            class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-2 text-sm font-semibold text-white shadow-lg shadow-blue-400/50 transition hover:scale-105 hover:shadow-blue-400/80"
                        >
                            查看全部 →
                        </Link>
                    </div>
                </div>

                <!-- Tabbar Navigation -->
                <div
                    class="mb-8 flex gap-2 overflow-x-auto border-b border-blue-300/20 pb-4"
                >
                    <button
                        @click="activeNewsTab = 'all'"
                        :class="[
                            'relative px-4 py-2 text-sm font-semibold whitespace-nowrap transition-all',
                            activeNewsTab === 'all'
                                ? 'text-blue-600'
                                : 'text-slate-500 hover:text-gray-600',
                        ]"
                    >
                        全部资讯
                        <div
                            v-if="activeNewsTab === 'all'"
                            class="absolute right-0 bottom-0 left-0 h-0.5 bg-gradient-to-r from-blue-600 to-blue-500"
                        />
                    </button>
                    <button
                        @click="activeNewsTab = 'news'"
                        :class="[
                            'relative px-4 py-2 text-sm font-semibold whitespace-nowrap transition-all',
                            activeNewsTab === 'news'
                                ? 'text-blue-600'
                                : 'text-slate-500 hover:text-gray-600',
                        ]"
                    >
                        公司动态
                        <div
                            v-if="activeNewsTab === 'news'"
                            class="absolute right-0 bottom-0 left-0 h-0.5 bg-gradient-to-r from-blue-600 to-blue-500"
                        />
                    </button>
                    <button
                        @click="activeNewsTab = 'tech'"
                        :class="[
                            'relative px-4 py-2 text-sm font-semibold whitespace-nowrap transition-all',
                            activeNewsTab === 'tech'
                                ? 'text-blue-600'
                                : 'text-slate-500 hover:text-gray-600',
                        ]"
                    >
                        技术分享
                        <div
                            v-if="activeNewsTab === 'tech'"
                            class="absolute right-0 bottom-0 left-0 h-0.5 bg-gradient-to-r from-blue-600 to-blue-500"
                        />
                    </button>
                    <button
                        @click="activeNewsTab = 'insight'"
                        :class="[
                            'relative px-4 py-2 text-sm font-semibold whitespace-nowrap transition-all',
                            activeNewsTab === 'insight'
                                ? 'text-blue-600'
                                : 'text-slate-500 hover:text-gray-600',
                        ]"
                    >
                        行业观点
                        <div
                            v-if="activeNewsTab === 'insight'"
                            class="absolute right-0 bottom-0 left-0 h-0.5 bg-gradient-to-r from-blue-600 to-blue-500"
                        />
                    </button>
                </div>

                <!-- News Grid -->
                <div
                    v-if="news.length"
                    class="grid gap-6 md:grid-cols-2 lg:grid-cols-3"
                >
                    <article
                        v-for="article in news"
                        :key="article.id"
                        class="group relative flex h-full cursor-pointer flex-col overflow-hidden rounded-2xl border border-blue-100 bg-white/95 shadow-lg shadow-blue-100/70 transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <Link
                            :href="`/news/${article.id}`"
                            class="flex h-full flex-col"
                        >
                            <!-- Image Container -->
                            <div
                                v-if="article.image"
                                class="relative h-40 overflow-hidden bg-white/50"
                            >
                                <img
                                    :src="article.image"
                                    :alt="article.title"
                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                />
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-blue-50 via-transparent to-transparent opacity-60"
                                />
                            </div>
                            <div
                                v-else
                                class="flex h-40 items-center justify-center border border-blue-100 bg-blue-50"
                            >
                                <svg
                                    class="h-10 w-10 text-blue-300"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    />
                                </svg>
                            </div>

                            <!-- Content -->
                            <div class="flex flex-1 flex-col p-5">
                                <div
                                    class="flex items-start justify-between gap-2"
                                >
                                    <span
                                        class="inline-block rounded-full border border-blue-100 bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700"
                                        >新闻</span
                                    >
                                    <span class="text-xs text-slate-500">{{
                                        new Date(
                                            article.created_at * 1000,
                                        ).toLocaleDateString('zh-CN')
                                    }}</span>
                                </div>
                                <h3
                                    class="mt-3 line-clamp-2 text-base font-bold text-slate-900 transition group-hover:text-blue-700"
                                >
                                    {{ article.title }}
                                </h3>
                                <p
                                    class="mt-2 line-clamp-2 flex-1 text-sm text-slate-500"
                                >
                                    {{ article.description }}
                                </p>
                                <div
                                    class="mt-3 flex items-center gap-1 text-blue-600 opacity-0 transition-opacity group-hover:opacity-100"
                                >
                                    <span class="text-xs font-semibold"
                                        >阅读更多</span
                                    >
                                    <svg
                                        class="h-3 w-3"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </Link>
                    </article>
                </div>

                <!-- Empty State -->
                <div
                    v-else
                    class="rounded-2xl border border-blue-100 bg-blue-50 py-16 text-center text-blue-600"
                >
                    <svg
                        class="mx-auto h-12 w-12 text-blue-300"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m0 0h6m-6-6h-6m0 0H6"
                        />
                    </svg>
                    <p class="mt-3 text-sm text-blue-700">暂无资讯内容</p>
                </div>
            </div>
        </section>

        <!-- Contact Quick Info -->
        <section class="border-t border-blue-300/20 bg-white py-16">
            <div class="mx-auto w-full max-w-6xl px-6">
                <div class="grid gap-8 md:grid-cols-2">
                    <!-- Phone -->
                    <article
                        class="rounded-2xl border border-blue-100 bg-white/95 p-8 shadow-lg shadow-blue-100/70 transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div class="flex items-start gap-4">
                            <div
                                class="rounded-2xl bg-blue-50 p-4 text-blue-600 ring-1 ring-blue-100"
                            >
                                <svg
                                    class="h-6 w-6 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                    />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-slate-900">
                                    电话咨询
                                </h3>
                                <p class="mt-2 text-sm text-gray-600">
                                    联系我们的客服团队，获取专业的技术支持与方案咨询
                                </p>
                                <a
                                    :href="`tel:${contact.phone}`"
                                    class="mt-4 inline-flex items-center gap-2 rounded-lg border border-blue-100 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                        />
                                    </svg>
                                    {{ contact.phone }}
                                </a>
                            </div>
                        </div>
                    </article>

                    <!-- Email -->
                    <article
                        class="rounded-2xl border border-blue-100 bg-white/95 p-8 shadow-lg shadow-blue-100/70 transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div class="flex items-start gap-4">
                            <div
                                class="rounded-2xl bg-blue-50 p-4 text-blue-600 ring-1 ring-blue-100"
                            >
                                <svg
                                    class="h-6 w-6 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-slate-900">
                                    电子邮箱
                                </h3>
                                <p class="mt-2 text-sm text-gray-600">
                                    发送邮件至我们的业务邮箱，我们会在24小时内回复
                                </p>
                                <div class="mt-4 space-y-2">
                                    <a
                                        v-for="email in contact.emails"
                                        :key="email"
                                        :href="`mailto:${email}`"
                                        class="flex w-full items-start gap-2 rounded-lg border border-blue-100 bg-blue-50 px-4 py-2 text-left text-sm font-semibold text-blue-700 transition hover:bg-blue-100"
                                    >
                                        <svg
                                            class="h-4 w-4 flex-shrink-0"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                            />
                                        </svg>
                                        <span class="break-words">{{
                                            email
                                        }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section
            class="border-t border-blue-300/20 bg-white py-16"
            v-if="faqs.length"
        >
            <div class="mx-auto w-full max-w-5xl px-6">
                <div class="mb-12 text-center">
                    <p
                        class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                    >
                        常见问题
                    </p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">
                        了解更多服务细节
                    </h2>
                </div>
                <div class="space-y-3">
                    <button
                        v-for="(faq, index) in faqs"
                        :key="faq.id"
                        @click="
                            expandedFaq = expandedFaq === index ? null : index
                        "
                        class="w-full rounded-2xl border border-blue-100 bg-white/95 px-6 py-4 text-left shadow-lg shadow-blue-100/70 transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-slate-900">
                                {{ faq.title }}
                            </p>
                            <svg
                                :class="[
                                    'h-5 w-5 text-blue-600 transition-transform',
                                    { 'rotate-180': expandedFaq === index },
                                ]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3"
                                />
                            </svg>
                        </div>
                        <div
                            v-if="expandedFaq === index"
                            class="prose mt-4 max-w-none border-t border-blue-100 pt-4 text-gray-600"
                            v-html="faq.content"
                        />
                    </button>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
