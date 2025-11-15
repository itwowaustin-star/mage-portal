<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Calendar, Picture } from '@element-plus/icons-vue';

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
                <el-text type="primary" class="text-xs uppercase tracking-[0.45em] font-semibold">新闻资讯</el-text>
                <h1 class="mt-5 text-4xl font-bold leading-tight lg:text-5xl drop-shadow-lg">
                    最新动态与行业洞察
                </h1>
                <el-text class="block mt-4 text-base">
                    关注马格网络科技的最新动态、技术分享与行业观点
                </el-text>
            </div>
        </section>

        <!-- News Grid -->
        <section class="bg-gray-50 py-20">
            <div class="mx-auto w-full max-w-6xl px-6">
                <el-row :gutter="24">
                    <el-col
                        v-for="article in news.data"
                        :key="article.id"
                        :xs="24"
                        :sm="12"
                        :lg="8"
                        class="mb-8"
                    >
                        <el-card
                            shadow="hover"
                            :body-style="{ padding: '0' }"
                            class="h-full cursor-pointer transition-all hover:-translate-y-2 hover:shadow-xl"
                            @click="router.visit(`/news/${article.id}`)"
                        >
                            <div class="relative overflow-hidden">
                                <el-image
                                    v-if="article.image"
                                    :src="article.image"
                                    :alt="article.title"
                                    fit="cover"
                                    class="w-full h-48 transition-transform duration-300 hover:scale-110"
                                >
                                    <template #error>
                                        <div class="h-48 flex items-center justify-center bg-gray-100">
                                            <el-icon :size="48" color="#dcdfe6"><Picture /></el-icon>
                                        </div>
                                    </template>
                                </el-image>
                                <div v-else class="h-48 flex items-center justify-center bg-gray-100">
                                    <el-icon :size="48" color="#dcdfe6"><Picture /></el-icon>
                                </div>
                            </div>
                            <div class="p-6">
                                <el-tag type="primary" size="small" class="mb-3">新闻</el-tag>
                                <h3 class="text-lg font-bold line-clamp-2 hover:text-blue-600 transition min-h-[56px]">
                                    {{ article.title }}
                                </h3>
                                <el-text class="block mt-4 text-sm text-gray-600 line-clamp-3 min-h-[60px]">
                                    {{ article.description }}
                                </el-text>
                                <div class="mt-4 pt-4 border-t border-gray-100 flex items-center gap-2">
                                    <el-icon color="#909399"><Calendar /></el-icon>
                                    <el-text type="info" size="small">
                                        {{ new Date(article.created_at * 1000).toLocaleDateString('zh-CN') }}
                                    </el-text>
                                </div>
                            </div>
                        </el-card>
                    </el-col>
                </el-row>

                <!-- Pagination -->
                <div v-if="news.links.next || news.links.prev" class="mt-12 flex items-center justify-center">
                    <el-space>
                        <el-button
                            v-if="news.links.prev"
                            @click="router.visit(news.links.prev!)"
                        >
                            上一页
                        </el-button>
                        <el-button
                            v-if="news.links.next"
                            type="primary"
                            @click="router.visit(news.links.next!)"
                        >
                            下一页
                        </el-button>
                    </el-space>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
