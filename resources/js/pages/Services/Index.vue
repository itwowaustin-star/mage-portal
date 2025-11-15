<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ArrowRight } from '@element-plus/icons-vue';

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
                <el-text type="primary" class="text-xs uppercase tracking-widest font-semibold">SERVICE GRAPH</el-text>
                <h1 class="mt-4 text-4xl font-bold drop-shadow-lg">一份数据源 · 全栈交付矩阵</h1>
                <el-text class="block mt-3 text-sm">
                    所有卡片均与后台数据实时联动，涵盖网络安全、弱电系统、机房运维与软件研发等多条战线。
                </el-text>
            </div>
        </section>

        <!-- Services Grid -->
        <section class="bg-gray-50 py-20">
            <div class="mx-auto w-full max-w-6xl px-6">
                <div class="space-y-8">
                    <el-card
                        v-for="service in services"
                        :key="service.slug"
                        shadow="hover"
                        class="overflow-hidden transition-all hover:-translate-y-1"
                    >
                        <el-row :gutter="32" align="middle">
                            <el-col :xs="24" :lg="16">
                                <el-text type="primary" class="text-xs uppercase tracking-widest font-semibold">SERVICE</el-text>
                                <h2 class="mt-3 text-2xl font-bold">{{ service.title }}</h2>
                                <el-text class="block mt-4 text-base leading-relaxed">{{ service.excerpt }}</el-text>
                                
                                <!-- Description with better readability -->
                                <el-alert
                                    :title="service.description"
                                    type="info"
                                    :closable="false"
                                    class="mt-6"
                                    effect="light"
                                />

                                <!-- Tags -->
                                <div class="mt-6 flex flex-wrap gap-2">
                                    <el-tag
                                        v-for="tag in service.tags"
                                        :key="`${service.slug}-${tag}`"
                                        type="primary"
                                        effect="light"
                                        size="large"
                                    >
                                        {{ tag }}
                                    </el-tag>
                                </div>
                            </el-col>

                            <!-- Image & CTA -->
                            <el-col :xs="24" :lg="8" class="mt-8 lg:mt-0">
                                <div class="space-y-4">
                                    <el-image
                                        v-if="service.image"
                                        :src="service.image"
                                        :alt="service.title"
                                        fit="cover"
                                        class="w-full h-56 rounded-lg border border-blue-100"
                                    >
                                        <template #error>
                                            <div class="flex items-center justify-center h-full bg-gray-100 rounded-lg">
                                                <el-text type="info">暂无图片</el-text>
                                            </div>
                                        </template>
                                    </el-image>
                                    <div v-else class="flex items-center justify-center h-56 bg-gray-100 rounded-lg border border-gray-200">
                                        <el-text type="info">暂无视觉素材</el-text>
                                    </div>
                                    <el-button
                                        type="primary"
                                        size="large"
                                        class="w-full"
                                        @click="router.visit(`/services/${service.slug}`)"
                                    >
                                        查看详情
                                        <el-icon class="ml-2"><ArrowRight /></el-icon>
                                    </el-button>
                                </div>
                            </el-col>
                        </el-row>
                    </el-card>
                </div>
            </div>
        </section>

        <!-- Bottom CTA -->
        <section class="bg-white py-12">
            <div class="mx-auto w-full max-w-5xl px-6">
                <el-card shadow="never" class="text-center bg-gradient-to-br from-blue-50 to-white">
                    <h2 class="text-2xl font-bold">
                        找到适合的解决方案？
                    </h2>
                    <el-text class="block max-w-2xl mx-auto mt-4">
                        联系我们的技术团队，讨论如何将这些能力应用到你的业务场景。
                    </el-text>
                    <el-button
                        type="primary"
                        size="large"
                        class="mt-6"
                        :icon="ArrowRight"
                        @click="router.visit('/contact')"
                    >
                        安排对接
                    </el-button>
                </el-card>
            </div>
        </section>
    </MarketingLayout>
</template>
