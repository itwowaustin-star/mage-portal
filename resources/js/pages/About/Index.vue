<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

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
                <p
                    class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                >
                    ABOUT
                </p>
                <h1
                    class="mt-3 text-4xl font-bold text-slate-900 drop-shadow-lg"
                >
                    {{ cleanedCompany.name }}
                </h1>
                <p class="mt-3 text-base leading-relaxed text-gray-600">
                    {{ cleanedCompany.description }}
                </p>
                <div class="mt-8 grid gap-6 md:grid-cols-2">
                    <article
                        class="rounded-lg border border-blue-200 bg-gradient-to-br from-white to-blue-50 p-6 shadow-lg shadow-blue-200/20"
                    >
                        <p
                            class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                        >
                            愿景
                        </p>
                        <p class="mt-3 text-xl font-bold text-blue-700">
                            {{ cleanedCompany.vision }}
                        </p>
                    </article>
                    <article
                        class="rounded-lg border border-blue-200 bg-gradient-to-br from-blue-50 to-white p-6 shadow-lg shadow-blue-200/20"
                    >
                        <p
                            class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                        >
                            使命
                        </p>
                        <p class="mt-3 text-xl font-bold text-blue-700">
                            {{ cleanedCompany.mission }}
                        </p>
                    </article>
                </div>
                <div
                    class="mt-8 rounded-lg border border-blue-200 bg-gradient-to-br from-white to-blue-50 p-6 shadow-lg shadow-blue-200/20"
                >
                    <p
                        class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                    >
                        定位关键词
                    </p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <span
                            v-for="item in cleanedCompany.positioning"
                            :key="item"
                            class="rounded-full border border-blue-300 bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700"
                        >
                            {{ item }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Timeline -->
        <section
            v-if="cleanedTimeline.length"
            class="border-t border-blue-100 bg-white py-16"
        >
            <div class="mx-auto w-full max-w-5xl px-6">
                <p
                    class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                >
                    MILESTONES
                </p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">
                    项目历程与关键节点
                </h2>
                <div class="mt-8 space-y-4">
                    <article
                        v-for="item in cleanedTimeline"
                        :key="`${item.year}-${item.title}`"
                        class="flex items-start gap-4 rounded-2xl border border-blue-100 bg-blue-50/40 px-6 py-5 shadow-sm shadow-blue-100/50"
                    >
                        <div
                            class="rounded-full bg-white px-5 py-2 text-lg font-semibold text-blue-700 shadow-inner shadow-blue-200"
                        >
                            {{ item.year }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">
                                {{ item.title }}
                            </h3>
                            <p
                                class="mt-2 text-sm leading-relaxed text-gray-600"
                            >
                                {{ item.description }}
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Team Capabilities -->
        <section class="bg-white py-16">
            <div class="mx-auto w-full max-w-5xl px-6">
                <p
                    class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                >
                    TEAM CAPABILITIES
                </p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">
                    驻场部门的职责说明
                </h2>
                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    <article
                        v-for="item in cleanedAdvantages"
                        :key="item.title"
                        class="rounded-lg border border-blue-200 bg-gradient-to-br from-white to-blue-50 p-6 shadow-lg shadow-blue-200/20 transition-all hover:border-blue-300 hover:shadow-blue-300/30"
                    >
                        <h3 class="text-lg font-bold text-blue-700">
                            {{ item.title }}
                        </h3>
                        <p class="mt-3 leading-relaxed text-gray-600">
                            {{ item.description }}
                        </p>
                    </article>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
