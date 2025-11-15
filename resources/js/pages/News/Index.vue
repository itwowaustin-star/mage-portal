<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

interface NewsArticle {
    id: number;
    title: string;
    description: string;
    image: string | null;
    created_at: number;
}

interface Pagination {
    data: NewsArticle[];
    links: { first: string | null; last: string | null; next: string | null; prev: string | null };
}

defineProps<{
    news: Pagination;
}>();
</script>

<template>
    <MarketingLayout>
        <Head title="新闻资讯 - 马格网络科技" />

        <!-- Hero Section -->
        <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-50/30 py-16">
            <div class="absolute inset-0">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl opacity-40 animate-pulse"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
            </div>
            <div class="relative mx-auto w-full max-w-6xl px-6 text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.45em] text-blue-600">新闻资讯</p>
                <h1 class="mt-5 text-4xl font-bold leading-tight text-slate-900 lg:text-5xl drop-shadow-lg">
                    最新动态与行业洞察
                </h1>
                <p class="mt-4 text-base text-gray-600">
                    关注马格网络科技的最新动态、技术分享与行业观点
                </p>
            </div>
        </section>

        <!-- News Grid -->
        <section class="bg-white py-20">
            <div class="mx-auto w-full max-w-6xl px-6">
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <article
                        v-for="article in news.data"
                        :key="article.id"
                        class="group flex h-full flex-col rounded-lg border border-blue-200 bg-gradient-to-br from-white to-blue-50 overflow-hidden shadow-lg shadow-blue-200/20 hover:border-blue-300 hover:shadow-blue-300/40 transition-all cursor-pointer"
                    >
                        <Link :href="`/news/${article.id}`" class="flex flex-col h-full">
                            <div v-if="article.image" class="relative h-48 overflow-hidden bg-white">
                                <img
                                    :src="article.image"
                                    :alt="article.title"
                                    class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-300"
                                />
                            </div>
                            <div v-else class="h-48 bg-white flex items-center justify-center text-gray-500">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex flex-col flex-1 p-6">
                                <p class="text-xs uppercase tracking-widest text-blue-600 font-semibold">新闻</p>
                                <h3 class="mt-2 line-clamp-2 text-lg font-bold text-slate-900 group-hover:text-blue-700 transition">
                                    {{ article.title }}
                                </h3>
                                <p class="mt-3 line-clamp-3 flex-1 text-sm text-gray-600">
                                    {{ article.description }}
                                </p>
                                <p class="mt-4 text-xs text-slate-500">
                                    {{ new Date(article.created_at * 1000).toLocaleDateString('zh-CN') }}
                                </p>
                            </div>
                        </Link>
                    </article>
                </div>

                <!-- Pagination -->
                <div v-if="news.links.next || news.links.prev" class="mt-12 flex items-center justify-center gap-2">
                    <Link
                        v-if="news.links.prev"
                        :href="news.links.prev"
                        class="rounded-lg border border-blue-300 bg-white px-4 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-50 transition"
                    >
                        上一页
                    </Link>
                    <Link
                        v-if="news.links.next"
                        :href="news.links.next"
                        class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700 transition"
                    >
                        下一页
                    </Link>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
