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

defineProps<{
    services: Service[];
}>();
</script>

<template>
    <MarketingLayout>
        <Head title="服务矩阵 · 聚焦客户成果" />

        <!-- Hero -->
        <section
            class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-50/40 py-20"
        >
            <div class="pointer-events-none absolute inset-0">
                <div
                    class="absolute top-1/3 left-1/3 h-80 w-80 rounded-full bg-blue-500/10 blur-3xl"
                ></div>
                <div
                    class="absolute right-1/4 bottom-1/4 h-72 w-72 rounded-full bg-blue-400/10 blur-3xl"
                ></div>
            </div>
            <div class="relative mx-auto w-full max-w-4xl px-6 text-center">
                <p
                    class="text-xs font-semibold tracking-[0.4em] text-blue-600 uppercase"
                >
                    Service Matrix
                </p>
                <h1 class="mt-5 text-4xl font-bold text-slate-900 drop-shadow">
                    围绕客户成果拆分能力，而不是堆砌技术
                </h1>
                <p class="mt-4 text-base leading-relaxed text-slate-600">
                    每一项服务卡片都与后台项目数据实时同步，并附带“适用场景 +
                    预期结果 + 交付承诺”，方便客户内部决策。
                </p>
            </div>
        </section>

        <!-- Services List -->
        <section class="bg-slate-50 py-20">
            <div class="mx-auto w-full max-w-6xl space-y-8 px-6">
                <article
                    v-for="service in services"
                    :key="service.slug"
                    class="grid gap-8 rounded-3xl border border-blue-100 bg-white/95 p-8 shadow-lg shadow-blue-100/70 lg:grid-cols-[3fr,2fr]"
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
                        <p class="text-sm text-slate-500">
                            {{ service.description }}
                        </p>
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
                    <div class="space-y-5">
                        <img
                            v-if="service.image"
                            :src="service.image"
                            :alt="service.title"
                            class="h-52 w-full rounded-2xl border border-blue-100 object-cover"
                        />
                        <div
                            v-else
                            class="grid h-52 place-items-center rounded-2xl border border-dashed border-blue-100 text-sm text-slate-400"
                        >
                            暂无项目视觉
                        </div>
                        <button
                            type="button"
                            class="w-full rounded-2xl bg-gradient-to-r from-blue-600 to-blue-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-400/50 transition hover:shadow-blue-400/80"
                            @click="router.visit(`/services/${service.slug}`)"
                        >
                            查看交付详情
                        </button>
                    </div>
                </article>
            </div>
        </section>

        <!-- Process -->
        <section class="bg-white py-16">
            <div class="mx-auto w-full max-w-6xl px-6">
                <div class="mb-10 text-center">
                    <p
                        class="text-xs font-semibold tracking-[0.4em] text-blue-600 uppercase"
                    >
                        Cooperation Flow
                    </p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">
                        我们如何与客户共创成果
                    </h2>
                    <p class="mt-2 text-sm text-slate-600">
                        把顾问话术转换成项目负责人听得懂的里程碑、材料和责任清单。
                    </p>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    <article
                        v-for="step in steps"
                        :key="step.title"
                        class="rounded-2xl border border-blue-100 bg-blue-50/50 p-6 text-sm leading-relaxed text-slate-700 shadow-sm shadow-blue-100/60"
                    >
                        <p class="text-xs font-semibold text-blue-600">
                            {{ step.title }}
                        </p>
                        <p class="mt-2 text-base font-bold text-slate-900">
                            {{ step.detail.split('，')[0] }}
                        </p>
                        <p class="mt-1 text-sm text-slate-600">
                            {{ step.detail.split('，').slice(1).join('，') }}
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <!-- Bottom CTA -->
        <section class="bg-gradient-to-b from-blue-50 to-white py-16">
            <div
                class="mx-auto w-full max-w-4xl rounded-3xl border border-blue-100 bg-white/95 p-10 text-center shadow-xl shadow-blue-100/70"
            >
                <h2 class="text-2xl font-bold text-slate-900">
                    需要更贴近业务的方案？
                </h2>
                <p class="mt-3 text-sm text-slate-600">
                    我们可以先为你梳理现状 + 目标 +
                    关键验收项，再匹配合适的项目组合与顾问团队。
                </p>
                <div
                    class="mt-6 flex flex-wrap justify-center gap-4 text-sm font-semibold"
                >
                    <Link
                        href="/contact"
                        class="rounded-full bg-gradient-to-r from-blue-600 to-blue-500 px-8 py-3 text-white shadow-lg shadow-blue-400/40 transition hover:shadow-blue-400/80"
                    >
                        预约方案沟通
                    </Link>
                    <Link
                        href="/services"
                        class="rounded-full border border-blue-200 px-8 py-3 text-blue-600 hover:border-blue-400"
                    >
                        下载服务能力简表
                    </Link>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
