<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

interface NewsArticle {
    id: number;
    title: string;
    description: string;
    content: string;
    image: string | null;
    created_at: number;
}

interface RelatedArticle {
    id: number;
    title: string;
    image: string | null;
    created_at: number;
}

defineProps<{
    article: NewsArticle;
    relatedNews: RelatedArticle[];
}>();
</script>

<template>
    <MarketingLayout>
        <Head :title="`${article.title} - 马格网络科技`" />

        <!-- Article Header -->
        <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-50/30 py-16">
            <div class="absolute inset-0">
                <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl opacity-40 animate-pulse"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl opacity-30 animate-pulse" style="animation-delay: 1s;"></div>
            </div>
            <div class="relative mx-auto w-full max-w-4xl px-6">
                <Link href="/news" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 mb-6">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    返回新闻列表
                </Link>
                <h1 class="text-4xl font-bold leading-tight text-slate-900 lg:text-5xl drop-shadow-lg">
                    {{ article.title }}
                </h1>
                <div class="mt-6 flex items-center gap-6 text-sm text-slate-500">
                    <span>{{ new Date(article.created_at * 1000).toLocaleDateString('zh-CN') }}</span>
                </div>
            </div>
        </section>

        <!-- Article Content -->
        <section class="bg-white py-16">
            <div class="mx-auto w-full max-w-4xl px-6">
                <article class="rounded-lg border border-blue-200 bg-gradient-to-br from-white to-blue-50 overflow-hidden shadow-lg shadow-blue-200/20 p-8">
                    <img
                        v-if="article.image"
                        :src="article.image"
                        :alt="article.title"
                        class="w-full rounded-lg object-cover border border-blue-200 mb-8"
                    />
                    <div class="prose max-w-none" v-html="article.content" />
                </article>
            </div>
        </section>

        <!-- Related Articles -->
        <section v-if="relatedNews.length" class="bg-white py-16 border-t border-blue-300/20">
            <div class="mx-auto w-full max-w-6xl px-6">
                <div class="mb-12">
                    <p class="text-xs font-semibold uppercase tracking-widest text-blue-600">相关资讯</p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">你可能感兴趣</h2>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    <article
                        v-for="news in relatedNews"
                        :key="news.id"
                        class="group rounded-lg border border-blue-200 bg-gradient-to-br from-white to-blue-50 overflow-hidden shadow-lg shadow-blue-200/20 hover:border-blue-300 hover:shadow-blue-300/30 transition-all cursor-pointer"
                    >
                        <Link :href="`/news/${news.id}`" class="flex flex-col h-full">
                            <div v-if="news.image" class="relative h-40 overflow-hidden bg-white">
                                <img
                                    :src="news.image"
                                    :alt="news.title"
                                    class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-300"
                                />
                            </div>
                            <div v-else class="h-40 bg-white flex items-center justify-center text-gray-500">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex flex-col flex-1 p-4">
                                <h3 class="line-clamp-2 text-base font-bold text-slate-900 group-hover:text-blue-700 transition">
                                    {{ news.title }}
                                </h3>
                                <p class="mt-3 text-xs text-slate-500">
                                    {{ new Date(news.created_at * 1000).toLocaleDateString('zh-CN') }}
                                </p>
                            </div>
                        </Link>
                    </article>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>

<style scoped>
:deep(.prose) {
    --tw-prose-body: rgb(51 65 85);
    --tw-prose-headings: rgb(15 23 42);
    --tw-prose-links: rgb(37 99 235);
    --tw-prose-bold: rgb(15 23 42);
    --tw-prose-code: rgb(37 99 235);
    --tw-prose-code-bg: rgb(239 246 255);
    --tw-prose-pre-bg: rgb(248 250 252);
    --tw-prose-pre-code: rgb(51 65 85);
    --tw-prose-th-borders: rgb(226 232 240);
    --tw-prose-td-borders: rgb(226 232 240);
}
</style>
