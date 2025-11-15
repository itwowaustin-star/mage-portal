<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

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
        <Head title="整体安全与研发服务矩阵" />

        <!-- Header -->
        <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-50/30 py-16">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-1/3 left-1/3 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl opacity-40 animate-pulse"></div>
                <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-blue-400/10 rounded-full blur-3xl opacity-30 animate-pulse" style="animation-delay: 1.5s;"></div>
            </div>
            <div class="relative mx-auto w-full max-w-5xl px-6 text-center">
                <p class="text-xs font-semibold uppercase tracking-widest text-blue-600">SERVICE GRAPH</p>
                <h1 class="mt-4 text-4xl font-bold text-slate-900 drop-shadow-lg">一份数据源 · 全栈交付矩阵</h1>
                <p class="mt-3 text-sm text-gray-600">
                    所有卡片均与后台数据实时联动，涵盖网络安全、弱电系统、机房运维与软件研发等多条战线。
                </p>
            </div>
        </section>

        <!-- Services Grid -->
        <section class="bg-white py-16">
            <div class="mx-auto w-full max-w-6xl space-y-8 px-6">
                <article
                    v-for="service in services"
                    :key="service.slug"
                    class="rounded-lg border border-blue-200 bg-gradient-to-br from-white to-blue-50 p-8 shadow-lg shadow-blue-200/20 transition hover:border-blue-300 hover:shadow-blue-300/40"
                >
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="flex-1">
                            <p class="text-xs uppercase tracking-widest font-semibold text-blue-600">SERVICE</p>
                            <h2 class="mt-2 text-3xl font-bold text-slate-900">{{ service.title }}</h2>
                            <p class="mt-3 text-base text-slate-700">{{ service.excerpt }}</p>
                            
                            <!-- Description with better readability -->
                            <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50/50 p-4">
                                <p class="text-sm leading-relaxed text-gray-700">{{ service.description }}</p>
                            </div>

                            <!-- Tags -->
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span
                                    v-for="tag in service.tags"
                                    :key="`${service.slug}-${tag}`"
                                    class="rounded-full bg-blue-100 border border-blue-300 px-3 py-1 text-xs font-semibold text-blue-700"
                                >
                                    {{ tag }}
                                </span>
                            </div>
                        </div>

                        <!-- Image & CTA -->
                        <div class="flex flex-col gap-4 lg:w-96 flex-shrink-0">
                            <div class="flex items-center justify-center rounded-lg border border-blue-200 bg-white">
                                <img
                                    v-if="service.image"
                                    :src="service.image"
                                    :alt="service.title"
                                    class="h-48 w-full rounded-lg object-cover"
                                />
                                <p v-else class="py-10 text-sm text-gray-500">暂无视觉素材</p>
                            </div>
                            <Link
                                :href="`/services/${service.slug}`"
                                class="w-full rounded-lg border-2 border-blue-300 bg-blue-600 px-6 py-3 text-center text-sm font-semibold text-white transition hover:bg-blue-700 hover:border-blue-400 hover:shadow-lg"
                            >
                                查看详情 →
                            </Link>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <!-- Bottom CTA -->
        <section class="bg-white py-12">
            <div class="mx-auto flex w-full max-w-5xl flex-col items-center gap-5 px-6 text-center">
                <h2 class="text-2xl font-bold text-slate-900">
                    找到适合的解决方案？
                </h2>
                <p class="max-w-2xl text-gray-600">
                    联系我们的技术团队，讨论如何将这些能力应用到你的业务场景。
                </p>
                <Link
                    href="/contact"
                    class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 px-8 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-400/50 transition hover:shadow-blue-400/80 hover:scale-105"
                >
                    安排对接 →
                </Link>
            </div>
        </section>
    </MarketingLayout>
</template>
