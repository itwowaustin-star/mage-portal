<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

interface Service {
    title: string;
    slug: string;
    description: string;
    content: string | null;
    tags: string[];
    image: string | null;
}

defineProps<{
    service: Service;
}>();
</script>

<template>
    <MarketingLayout>
        <Head :title="service.title" />

        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-50/30 py-16">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-1/3 -left-24 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl opacity-40 animate-pulse"></div>
                <div class="absolute bottom-0 right-1/3 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
            </div>
            <div class="relative mx-auto w-full max-w-5xl px-6">
                <p class="text-xs font-semibold uppercase tracking-widest text-blue-600">SERVICE DETAIL</p>
                <div class="mt-4 grid gap-8 lg:grid-cols-[3fr,2fr]">
                    <div>
                        <h1 class="text-4xl font-bold text-slate-900 drop-shadow-lg">{{ service.title }}</h1>
                        <p class="mt-4 text-base text-gray-600">{{ service.description }}</p>
                        <div class="mt-6 flex flex-wrap gap-2">
                            <span
                                v-for="tag in service.tags"
                                :key="`${service.slug}-${tag}`"
                                class="rounded-full bg-blue-100 border border-blue-300 px-3 py-1 text-xs font-semibold text-blue-700"
                            >
                                {{ tag }}
                            </span>
                        </div>
                    </div>
                    <div class="rounded-lg border border-blue-200 bg-gradient-to-br from-white to-blue-50 p-4 shadow-lg shadow-blue-200/20 backdrop-blur">
                        <img
                            v-if="service.image"
                            :src="service.image"
                            :alt="service.title"
                            class="h-64 w-full rounded-lg object-cover"
                        />
                        <div
                            v-else
                            class="flex h-64 items-center justify-center rounded-lg bg-white text-sm text-gray-500"
                        >
                            暂无图片
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Content Section -->
        <section class="bg-white py-16">
            <div class="mx-auto w-full max-w-5xl px-6">
                <div class="rounded-lg border border-blue-200 bg-gradient-to-br from-white to-blue-50 p-8 shadow-lg shadow-blue-200/20">
                    <h2 class="text-2xl font-bold text-slate-900">实施细节</h2>
                    <div
                        v-if="service.content"
                        class="rich-text mt-6 text-gray-700"
                        v-html="service.content"
                    />
                    <p v-else class="mt-6 text-sm text-gray-600">暂无详细说明。</p>
                </div>
                <div class="mt-10 flex flex-wrap items-center justify-between gap-4 rounded-lg border border-blue-200 bg-gradient-to-r from-blue-50 to-white p-8 shadow-lg shadow-blue-200/20">
                    <div>
                        <p class="text-xs uppercase tracking-widest text-blue-600 font-semibold">下一步</p>
                        <p class="mt-2 text-lg font-semibold text-slate-900">想了解场景匹配或需要 PoC？</p>
                    </div>
                    <div class="flex gap-3">
                        <Link
                            href="/contact"
                            class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-2 text-sm font-semibold text-white shadow-md shadow-blue-400/50 transition hover:shadow-blue-400/80 hover:scale-105"
                        >
                            联系顾问
                        </Link>
                        <Link
                            href="/services"
                            class="rounded-lg border-2 border-blue-300 bg-white px-6 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-50 hover:border-blue-400"
                        >
                            返回列表
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
