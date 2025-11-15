<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Calendar } from '@element-plus/icons-vue';

interface CompanyInfo {
    name: string;
    description: string;
    vision: string;
    mission: string;
    positioning: string[];
}

interface TimelineItem {
    year: string;
    title: string;
    description: string;
}

interface Advantage {
    title: string;
    description: string;
}

const props = defineProps<{
    company: CompanyInfo;
    timeline: TimelineItem[];
    advantages: Advantage[];
}>();

const cleanText = (text: string | null): string => {
    if (!text) return '';
    return text
        .replace(/&nbsp;/g, '')
        .replace(/&amp;/g, '&')
        .replace(/&lt;/g, '<')
        .replace(/&gt;/g, '>')
        .replace(/&quot;/g, '"')
        .replace(/&#39;/g, "'")
        .trim();
};

const cleanedCompany = computed(() => ({
    ...props.company,
    name: cleanText(props.company.name),
    description: cleanText(props.company.description),
    vision: cleanText(props.company.vision),
    mission: cleanText(props.company.mission),
    positioning: props.company.positioning.map((p) => cleanText(p)),
}));

const cleanedTimeline = computed(() =>
    props.timeline.map((item) => ({
        ...item,
        year: cleanText(item.year),
        title: cleanText(item.title),
        description: cleanText(item.description),
    })),
);

const cleanedAdvantages = computed(() =>
    props.advantages.map((adv) => ({
        ...adv,
        title: cleanText(adv.title),
        description: cleanText(adv.description),
    })),
);
</script>

<template>
    <MarketingLayout>
        <Head title="关于我们 · 数据驱动" />

        <!-- Company Info -->
        <section
            class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-50/30 py-16"
        >
            <div class="absolute inset-0 overflow-hidden">
                <div
                    class="absolute top-1/4 -left-32 h-80 w-80 animate-pulse rounded-full bg-blue-500/10 opacity-40 blur-3xl"
                ></div>
                <div
                    class="absolute right-1/4 bottom-1/3 h-96 w-96 animate-pulse rounded-full bg-blue-400/10 opacity-30 blur-3xl"
                    style="animation-delay: 1.5s"
                ></div>
            </div>
            <div class="relative mx-auto w-full max-w-5xl px-6">
                <el-text type="primary" class="text-xs uppercase tracking-widest font-semibold">
                    ABOUT
                </el-text>
                <h1 class="mt-3 text-4xl font-bold drop-shadow-lg">
                    {{ cleanedCompany.name }}
                </h1>
                <el-text class="block mt-3 text-base leading-relaxed">
                    {{ cleanedCompany.description }}
                </el-text>
                
                <el-row :gutter="24" class="mt-8">
                    <el-col :xs="24" :md="12">
                        <el-card shadow="hover">
                            <template #header>
                                <el-text type="primary" class="text-xs uppercase tracking-widest font-semibold">
                                    愿景
                                </el-text>
                            </template>
                            <el-text class="text-xl font-bold text-blue-700">
                                {{ cleanedCompany.vision }}
                            </el-text>
                        </el-card>
                    </el-col>
                    <el-col :xs="24" :md="12" class="mt-6 md:mt-0">
                        <el-card shadow="hover">
                            <template #header>
                                <el-text type="primary" class="text-xs uppercase tracking-widest font-semibold">
                                    使命
                                </el-text>
                            </template>
                            <el-text class="text-xl font-bold text-blue-700">
                                {{ cleanedCompany.mission }}
                            </el-text>
                        </el-card>
                    </el-col>
                </el-row>
                
                <el-card shadow="hover" class="mt-6">
                    <template #header>
                        <el-text type="primary" class="text-xs uppercase tracking-widest font-semibold">
                            定位关键词
                        </el-text>
                    </template>
                    <div class="flex flex-wrap gap-3">
                        <el-tag
                            v-for="item in cleanedCompany.positioning"
                            :key="item"
                            type="primary"
                            size="large"
                            effect="light"
                        >
                            {{ item }}
                        </el-tag>
                    </div>
                </el-card>
            </div>
        </section>

        <!-- Timeline -->
        <section
            v-if="cleanedTimeline.length"
            class="bg-gray-50 py-16"
        >
            <div class="mx-auto w-full max-w-5xl px-6">
                <el-text type="primary" class="text-xs uppercase tracking-widest font-semibold">
                    MILESTONES
                </el-text>
                <h2 class="mt-3 text-2xl font-bold">
                    项目历程与关键节点
                </h2>
                <el-timeline class="mt-8">
                    <el-timeline-item
                        v-for="item in cleanedTimeline"
                        :key="`${item.year}-${item.title}`"
                        :timestamp="item.year"
                        placement="top"
                        :icon="Calendar"
                        type="primary"
                        size="large"
                    >
                        <el-card shadow="hover">
                            <h3 class="text-lg font-bold">
                                {{ item.title }}
                            </h3>
                            <el-text class="block mt-2 text-sm leading-relaxed">
                                {{ item.description }}
                            </el-text>
                        </el-card>
                    </el-timeline-item>
                </el-timeline>
            </div>
        </section>

        <!-- Team Capabilities -->
        <section class="bg-white py-16">
            <div class="mx-auto w-full max-w-5xl px-6">
                <el-text type="primary" class="text-xs uppercase tracking-widest font-semibold">
                    TEAM CAPABILITIES
                </el-text>
                <h2 class="mt-3 text-2xl font-bold">
                    驻场部门的职责说明
                </h2>
                <el-row :gutter="24" class="mt-8">
                    <el-col
                        v-for="item in cleanedAdvantages"
                        :key="item.title"
                        :xs="24"
                        :md="8"
                        class="mb-6"
                    >
                        <el-card shadow="hover" class="h-full">
                            <template #header>
                                <h3 class="text-lg font-bold text-blue-600">
                                    {{ item.title }}
                                </h3>
                            </template>
                            <el-text class="leading-relaxed">
                                {{ item.description }}
                            </el-text>
                        </el-card>
                    </el-col>
                </el-row>
            </div>
        </section>
    </MarketingLayout>
</template>
