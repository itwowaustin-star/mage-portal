<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

interface Service {
    title: string;
    slug: string;
    description: string;
    excerpt: string;
    tags: string[];
    image: string | null;
}

const props = defineProps<{
    services: Service[];
}>();

const packages = [
    {
        title: '园区 / 政府机关',
        detail: '围绕等保、住建、能源监管等检查场景，半年内完成诊断、整改、验收三步走。',
        items: [
            '安全评估+整改方案',
            '驻场支撑与材料准备',
            '监管反馈与跟踪复盘',
        ],
    },
    {
        title: '大型民企集团',
        detail: '总部统一信息化、弱电、安防标准，复制到二级单位并提供预算模板。',
        items: [
            '总部规划+分支落地手册',
            '统一采购/招投标文档',
            '季度巡检与董事会报告',
        ],
    },
    {
        title: '运维托管',
        detail: '7×24 运维值守 + 应急响应 + 顾问月报，让管理层随时掌握运行状态。',
        items: ['7×24 监控 & 值守', '应急演练与复盘', '可视化运营仪表盘'],
    },
];

const guarantees = [
    '所有工作节点、材料、验收清单均记录在案，可追溯、可复盘。',
    '驻场顾问 + 项目经理 + 执行团队三层协同，确保沟通对齐。',
    '提供预算、工期、风险提示，帮助客户内部汇报更顺畅。',
    '可选“培训+托管”模式，项目结束后仍能保持平稳运行。',
];
</script>

<template>
    <MarketingLayout>
        <Head title="服务体系 · 场景化解决方案" />

        <!-- Hero -->
        <section
            class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-50/30 py-20"
        >
            <div class="pointer-events-none absolute inset-0">
                <div
                    class="absolute top-1/3 left-1/4 h-80 w-80 rounded-full bg-blue-500/10 blur-3xl"
                ></div>
                <div
                    class="absolute right-1/4 bottom-1/4 h-72 w-72 rounded-full bg-blue-400/10 blur-3xl"
                ></div>
            </div>
            <div class="relative mx-auto w-full max-w-5xl px-6 text-center">
                <p
                    class="text-xs font-semibold tracking-[0.4em] text-blue-600 uppercase"
                >
                    Service Matrix
                </p>
                <h1 class="mt-5 text-4xl font-bold text-slate-900 drop-shadow">
                    我们用“场景+成果”定义服务，而不是堆砌技术名词
                </h1>
                <p class="mt-4 text-base leading-relaxed text-slate-600">
                    以下每项服务都关联真实项目、验收材料、预算模型，方便你和内部管理层快速确认“能做什么、多久完成、责任到谁”。
                </p>
                <div class="mt-8 flex flex-wrap justify-center gap-4 text-sm">
                    <Link
                        href="/contact"
                        class="rounded-full bg-gradient-to-r from-blue-600 to-blue-500 px-8 py-3 font-semibold text-white shadow-lg shadow-blue-400/40 transition hover:shadow-blue-400/80"
                    >
                        获取方案建议
                    </Link>
                    <Link
                        href="/team"
                        class="rounded-full border border-blue-200 px-8 py-3 font-semibold text-blue-600 hover:border-blue-400"
                    >
                        查看顾问团队
                    </Link>
                </div>
            </div>
        </section>

        <!-- Services -->
        <section class="bg-slate-50 py-20">
            <div class="mx-auto w-full max-w-6xl space-y-6 px-6">
                <article
                    v-for="service in props.services"
                    :key="service.slug"
                    class="grid gap-8 rounded-3xl border border-blue-100 bg-white/95 p-8 shadow-lg shadow-blue-100/60 lg:grid-cols-[2.5fr,2fr]"
                >
                    <div class="space-y-4">
                        <p
                            class="text-xs font-semibold tracking-[0.3em] text-blue-600 uppercase"
                        >
                            Service
                        </p>
                        <h2 class="text-2xl font-bold text-slate-900">
                            {{ service.title }}
                        </h2>
                        <p class="text-base leading-relaxed text-slate-700">
                            {{ service.excerpt }}
                        </p>
                        <div
                            class="rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-3 text-sm text-blue-700"
                        >
                            {{ service.description }}
                        </div>
                        <div class="flex flex-wrap gap-2 pt-2">
                            <span
                                v-for="tag in service.tags"
                                :key="`${service.slug}-${tag}`"
                                class="rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700"
                            >
                                {{ tag }}
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div
                            class="relative h-52 w-full overflow-hidden rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-100 to-blue-200"
                        >
                            <div
                                class="absolute inset-0 bg-cover bg-center blur-sm"
                                :style="
                                    service.image
                                        ? {
                                              backgroundImage: `url(${service.image})`,
                                          }
                                        : {}
                                "
                            ></div>
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-blue-900/60 to-blue-500/20"
                            ></div>
                            <div
                                class="relative z-10 flex h-full flex-col justify-end p-4 text-white"
                            >
                                <p
                                    class="text-xs tracking-[0.2em] uppercase opacity-80"
                                >
                                    真实案例
                                </p>
                                <p
                                    class="text-base leading-tight font-semibold"
                                >
                                    {{ service.title }}
                                </p>
                            </div>
                        </div>
                        <button
                            type="button"
                            class="w-full rounded-2xl bg-gradient-to-r from-blue-600 to-blue-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-400/40 transition hover:shadow-blue-400/80"
                            @click="router.visit(`/services/${service.slug}`)"
                        >
                            查看交付细节
                        </button>
                        <p class="text-xs text-slate-500">
                            包含任务书、验收清单、驻场顾问档案。如需示例材料请联系顾问。
                        </p>
                    </div>
                </article>
            </div>
        </section>

        <!-- Packages -->
        <section class="bg-white py-16">
            <div class="mx-auto w-full max-w-6xl px-6">
                <div class="mb-10 text-center">
                    <p
                        class="text-xs font-semibold tracking-[0.4em] text-blue-600 uppercase"
                    >
                        Solution Bundles
                    </p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">
                        常见组合与交付承诺
                    </h2>
                    <p class="mt-2 text-sm text-slate-600">
                        把客户最常问的“怎么做、多久、产出什么”写出来，方便内部评估。
                    </p>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    <article
                        v-for="pack in packages"
                        :key="pack.title"
                        class="rounded-2xl border border-blue-100 bg-blue-50/50 p-6 shadow-sm shadow-blue-100/60"
                    >
                        <h3 class="text-lg font-bold text-slate-900">
                            {{ pack.title }}
                        </h3>
                        <p class="mt-2 text-sm text-slate-600">
                            {{ pack.detail }}
                        </p>
                        <ul class="mt-4 space-y-2 text-sm text-slate-700">
                            <li v-for="item in pack.items" :key="item">
                                • {{ item }}
                            </li>
                        </ul>
                    </article>
                </div>
            </div>
        </section>

        <!-- Guarantees -->
        <section class="bg-gradient-to-b from-blue-50 to-white py-16">
            <div
                class="mx-auto w-full max-w-5xl rounded-3xl border border-blue-100 bg-white/95 p-10 shadow-xl shadow-blue-100/70"
            >
                <h2 class="text-center text-2xl font-bold text-slate-900">
                    交付保障
                </h2>
                <p class="mt-2 text-center text-sm text-slate-600">
                    让客户清楚知道我们的责任边界与可交付成果。
                </p>
                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    <div
                        v-for="item in guarantees"
                        :key="item"
                        class="rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-3 text-sm text-slate-700"
                    >
                        {{ item }}
                    </div>
                </div>
                <div
                    class="mt-6 flex flex-wrap justify-center gap-4 text-sm font-semibold"
                >
                    <Link
                        href="/contact"
                        class="rounded-full bg-gradient-to-r from-blue-600 to-blue-500 px-8 py-3 text-white shadow-lg shadow-blue-400/40 transition hover:shadow-blue-400/80"
                    >
                        与顾问沟通下一步
                    </Link>
                    <Link
                        href="/about"
                        class="rounded-full border border-blue-200 px-8 py-3 text-blue-600 hover:border-blue-400"
                    >
                        了解团队与资质
                    </Link>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
