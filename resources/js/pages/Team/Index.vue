<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

interface TeamMember {
    name: string;
    title: string;
    expertise: string;
    phone: string | null;
    wechat: string | null;
}

interface Pillar {
    title: string;
    body: string;
}

const props = defineProps<{
    members: TeamMember[];
    pillars: Pillar[];
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

const cleanedMembers = computed(() => 
    props.members.map(member => ({
        ...member,
        name: cleanText(member.name),
        title: cleanText(member.title),
        expertise: cleanText(member.expertise),
        phone: cleanText(member.phone),
        wechat: cleanText(member.wechat),
    }))
);

const cleanedPillars = computed(() => 
    props.pillars.map(pillar => ({
        ...pillar,
        title: cleanText(pillar.title),
        body: cleanText(pillar.body),
    }))
);
</script>

<template>
    <MarketingLayout>
        <Head title="顾问团队" />

        <!-- Header -->
        <section class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-50/30 py-16">
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl opacity-40 animate-pulse"></div>
                <div class="absolute bottom-1/3 right-1/3 w-80 h-80 bg-blue-400/10 rounded-full blur-3xl opacity-30 animate-pulse" style="animation-delay: 1.5s;"></div>
            </div>
            <div class="relative mx-auto w-full max-w-5xl px-6 text-center">
                <p class="text-xs font-semibold uppercase tracking-widest text-blue-600">ADVISORS</p>
                <h1 class="mt-4 text-4xl font-bold text-slate-900 drop-shadow-lg">驻场顾问信息实时同步</h1>
                <p class="mt-3 text-gray-600">
                    后台录入的联系人会直接展示在这里，确保所有渠道使用同一组电话与微信。
                </p>
            </div>
        </section>

        <!-- Team Members Grid -->
        <section class="bg-white py-16">
            <div class="mx-auto grid w-full max-w-6xl gap-6 px-6 md:grid-cols-2">
                <article
                    v-for="member in cleanedMembers"
                    :key="member.name"
                    class="rounded-lg border border-blue-200 bg-gradient-to-br from-white to-blue-50 p-8 shadow-lg shadow-blue-200/20 transition hover:border-blue-300 hover:shadow-blue-300/30"
                >
                    <p class="text-xs uppercase tracking-widest font-semibold text-blue-600">ADVISOR</p>
                    <h2 class="mt-2 text-2xl font-bold text-slate-900">{{ member.name }}</h2>
                    <p class="text-sm text-gray-600">{{ member.title }}</p>
                    <p class="mt-3 text-sm text-blue-700 font-medium">{{ member.expertise }}</p>
                    <div class="mt-4 space-y-2 text-sm text-gray-600">
                        <p v-if="member.phone">
                            <span class="font-semibold text-blue-600">电话</span>：<a :href="`tel:${member.phone}`" class="text-blue-600 hover:text-blue-700 hover:underline">{{ member.phone }}</a>
                        </p>
                        <p v-if="member.wechat">
                            <span class="font-semibold text-blue-600">微信</span>：{{ member.wechat }}
                        </p>
                    </div>
                </article>
            </div>
        </section>

        <!-- Team Pillars -->
        <section class="bg-white py-16">
            <div class="mx-auto w-full max-w-5xl px-6">
                <p class="text-xs font-semibold uppercase tracking-widest text-blue-600">TEAM PILLARS</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">部门职责清晰透明</h2>
                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    <article
                        v-for="pillar in cleanedPillars"
                        :key="pillar.title"
                        class="rounded-lg border border-blue-200 bg-gradient-to-br from-white to-blue-50 p-6 shadow-lg shadow-blue-200/20 hover:border-blue-300 hover:shadow-blue-300/30 transition-all"
                    >
                        <h3 class="text-lg font-bold text-blue-700">{{ pillar.title }}</h3>
                        <p class="mt-3 leading-relaxed text-gray-600">{{ pillar.body }}</p>
                    </article>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
