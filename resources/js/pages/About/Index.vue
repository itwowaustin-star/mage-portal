<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
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
        .replace(/&nbsp;/g, ' ')
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
        <Head title="关于我们 · 为客户交付看得见的结果" />

        <section
            class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-50/40 py-20"
        >
            <div class="pointer-events-none absolute inset-0">
                <div
                    class="absolute top-1/4 left-1/3 h-80 w-80 rounded-full bg-blue-400/10 blur-3xl"
                ></div>
                <div
                    class="absolute right-1/4 bottom-1/3 h-72 w-72 rounded-full bg-blue-500/10 blur-3xl"
                ></div>
            </div>
            <div class="relative mx-auto w-full max-w-5xl px-6 text-center">
                <p
                    class="text-xs font-semibold tracking-[0.4em] text-blue-600 uppercase"
                >
                    About Us
                </p>
                <h1 class="mt-5 text-4xl font-bold text-slate-900 drop-shadow">
                    {{ cleanedCompany.name }}
                </h1>
                <p class="mt-4 text-base leading-relaxed text-slate-600">
                    {{ cleanedCompany.description }}
                </p>
                <div class="mt-8 grid gap-4 md:grid-cols-2">
                    <article
                        class="rounded-2xl border border-blue-100 bg-white/95 px-6 py-5 shadow-lg shadow-blue-100/60"
                    >
                        <p
                            class="text-xs font-semibold tracking-[0.3em] text-blue-600 uppercase"
                        >
                            愿景
                        </p>
                        <p
                            class="mt-2 text-lg leading-relaxed font-bold text-slate-900"
                        >
                            {{ cleanedCompany.vision }}
                        </p>
                    </article>
                    <article
                        class="rounded-2xl border border-blue-100 bg-white/95 px-6 py-5 shadow-lg shadow-blue-100/60"
                    >
                        <p
                            class="text-xs font-semibold tracking-[0.3em] text-blue-600 uppercase"
                        >
                            使命
                        </p>
                        <p
                            class="mt-2 text-lg leading-relaxed font-bold text-slate-900"
                        >
                            {{ cleanedCompany.mission }}
                        </p>
                    </article>
                </div>
                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    <span
                        v-for="item in cleanedCompany.positioning"
                        :key="item"
                        class="rounded-full border border-blue-100 bg-blue-50 px-4 py-2 text-xs font-semibold text-blue-700"
                    >
                        {{ item }}
                    </span>
                </div>
            </div>
        </section>

        <section class="bg-white py-16">
            <div class="mx-auto w-full max-w-5xl px-6">
                <div class="mb-10 text-center">
                    <p
                        class="text-xs font-semibold tracking-[0.4em] text-blue-600 uppercase"
                    >
                        What We Promise
                    </p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">
                        客户选择我们的原因
                    </h2>
                    <p class="mt-2 text-sm text-slate-600">
                        我们把复杂的技术语言翻译成“可以交付、可追踪、好对内汇报”的成果。
                    </p>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    <article
                        v-for="advantage in cleanedAdvantages"
                        :key="advantage.title"
                        class="rounded-2xl border border-blue-100 bg-blue-50/50 p-6 shadow-sm shadow-blue-100/60"
                    >
                        <h3 class="text-lg font-bold text-slate-900">
                            {{ advantage.title }}
                        </h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">
                            {{ advantage.description }}
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section v-if="cleanedTimeline.length" class="bg-slate-50 py-16">
            <div class="mx-auto w-full max-w-5xl px-6">
                <div class="mb-8 text-center">
                    <p
                        class="text-xs font-semibold tracking-[0.4em] text-blue-600 uppercase"
                    >
                        Milestones
                    </p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">
                        关键节点与代表项目
                    </h2>
                </div>
                <div class="space-y-4">
                    <article
                        v-for="item in cleanedTimeline"
                        :key="`${item.year}-${item.title}`"
                        class="rounded-2xl border border-blue-100 bg-white/90 px-6 py-4 shadow-sm shadow-blue-100/60"
                    >
                        <p
                            class="text-xs font-semibold tracking-[0.2em] text-blue-600 uppercase"
                        >
                            {{ item.year }}
                        </p>
                        <h3 class="mt-1 text-lg font-bold text-slate-900">
                            {{ item.title }}
                        </h3>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">
                            {{ item.description }}
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-white py-16">
            <div
                class="mx-auto flex w-full max-w-5xl flex-col gap-6 rounded-3xl border border-blue-100 bg-blue-50/50 p-10 px-6 text-center shadow-inner shadow-blue-100/60"
            >
                <h2 class="text-2xl font-bold text-slate-900">
                    我们期待与你一起完成的，是业务成果而不是 PPT
                </h2>
                <p class="text-sm text-slate-600">
                    提供行业参考案例、预算模板、验收材料样板，协助你在内部快速推动项目立项与上线。
                </p>
                <div
                    class="flex flex-wrap justify-center gap-4 text-sm font-semibold"
                >
                    <Link
                        href="/services"
                        class="rounded-full bg-gradient-to-r from-blue-600 to-blue-500 px-8 py-3 text-white shadow-lg shadow-blue-400/40 transition hover:shadow-blue-400/80"
                    >
                        查看服务矩阵
                    </Link>
                    <Link
                        href="/contact"
                        class="rounded-full border border-blue-200 px-8 py-3 text-blue-600 hover:border-blue-400"
                    >
                        安排顾问对接
                    </Link>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
