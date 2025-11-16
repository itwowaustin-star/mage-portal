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
        .replace(/&nbsp;/g, ' ')
        .replace(/&amp;/g, '&')
        .replace(/&lt;/g, '<')
        .replace(/&gt;/g, '>')
        .replace(/&quot;/g, '"')
        .replace(/&#39;/g, "'")
        .trim();
};

const cleanedMembers = computed(() =>
    props.members.map((member) => ({
        ...member,
        name: cleanText(member.name),
        title: cleanText(member.title),
        expertise: cleanText(member.expertise),
        phone: cleanText(member.phone),
        wechat: cleanText(member.wechat),
    })),
);

const cleanedPillars = computed(() =>
    props.pillars.map((pillar) => ({
        ...pillar,
        title: cleanText(pillar.title),
        body: cleanText(pillar.body),
    })),
);

const isDialable = (phone: string | null): boolean => {
    if (!phone) {
        return false;
    }

    if (phone.includes('*')) {
        return false;
    }

    return /\d/.test(phone);
};

const advisorInitial = (name: string): string => {
    return name?.trim().charAt(0) ?? '顾';
};
</script>

<template>
    <MarketingLayout>
        <Head title="顾问团队 · 让客户只有一个联系人" />

        <section
            class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-white to-blue-50/40 py-20"
        >
            <div class="pointer-events-none absolute inset-0">
                <div
                    class="absolute top-1/4 left-1/3 h-72 w-72 rounded-full bg-blue-400/10 blur-3xl"
                ></div>
                <div
                    class="absolute right-1/3 bottom-1/3 h-80 w-80 rounded-full bg-blue-500/10 blur-3xl"
                ></div>
            </div>
            <div class="relative mx-auto w-full max-w-4xl px-6 text-center">
                <p
                    class="text-xs font-semibold tracking-[0.4em] text-blue-600 uppercase"
                >
                    Advisors
                </p>
                <h1 class="mt-4 text-4xl font-bold text-slate-900 drop-shadow">
                    “一号对接人”背后是多专业混编团队
                </h1>
                <p class="mt-4 text-base text-slate-600">
                    每位顾问都与后台项目、巡检、合规材料实时同步，确保你在不同沟通渠道得到的是同一份信息和承诺。
                </p>
            </div>
        </section>

        <section class="bg-slate-50 py-20">
            <div class="mx-auto w-full max-w-6xl px-6">
                <div class="mb-10">
                    <p
                        class="text-xs font-semibold tracking-[0.4em] text-blue-600 uppercase"
                    >
                        Key Contacts
                    </p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">
                        驻场顾问卡片
                    </h2>
                    <p class="mt-2 text-sm text-slate-600">
                        直接展示擅长领域、联系方式与服务承诺，方便你快速匹配。
                    </p>
                </div>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <article
                        v-for="member in cleanedMembers"
                        :key="member.name"
                        class="flex h-full flex-col rounded-3xl border border-blue-100 bg-white/95 p-6 shadow-lg shadow-blue-100/60"
                    >
                        <div class="flex items-center gap-4">
                            <div
                                class="grid h-12 w-12 place-items-center rounded-full bg-blue-100 text-lg font-semibold text-blue-700"
                            >
                                {{ advisorInitial(member.name) }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">
                                    {{ member.name }}
                                </h3>
                                <p class="text-sm text-slate-500">
                                    {{ member.title }}
                                </p>
                            </div>
                        </div>
                        <p
                            class="mt-4 rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm leading-relaxed text-blue-700"
                        >
                            {{ member.expertise }}
                        </p>
                        <div class="mt-4 space-y-3 text-sm">
                            <div
                                v-if="member.phone"
                                class="flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-3"
                            >
                                <svg
                                    class="h-4 w-4 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.4"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.69l1.35 4.06a1 1 0 01-.46 1.18l-2.07 1.13a11 11 0 005.51 5.51l1.13-2.07a1 1 0 011.18-.46l4.06 1.35a1 1 0 01.69.95V19a2 2 0 01-2 2h-1C9.16 21 3 14.84 3 7V5z"
                                    />
                                </svg>
                                <div>
                                    <p class="text-xs text-slate-500">电话</p>
                                    <template v-if="isDialable(member.phone)">
                                        <a
                                            :href="`tel:${member.phone}`"
                                            class="font-semibold text-blue-600 hover:underline"
                                        >
                                            {{ member.phone }}
                                        </a>
                                    </template>
                                    <p
                                        v-else
                                        class="font-semibold text-slate-900"
                                    >
                                        {{ member.phone }}
                                    </p>
                                </div>
                            </div>
                            <div
                                v-if="member.wechat"
                                class="flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-3"
                            >
                                <svg
                                    class="h-4 w-4 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.4"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M8 9h8m-8 4h5m7-1a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <div>
                                    <p class="text-xs text-slate-500">微信</p>
                                    <p
                                        class="font-semibold break-all text-slate-900"
                                    >
                                        {{ member.wechat }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <section class="bg-white py-16">
            <div class="mx-auto w-full max-w-6xl px-6">
                <div class="mb-10 text-center">
                    <p
                        class="text-xs font-semibold tracking-[0.4em] text-blue-600 uppercase"
                    >
                        Delivery Pillars
                    </p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">
                        背后支撑部门
                    </h2>
                    <p class="mt-2 text-sm text-slate-600">
                        顾问负责沟通，而这些部门确保从方案到施工、从安全到运维都有人负责。
                    </p>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    <article
                        v-for="pillar in cleanedPillars"
                        :key="pillar.title"
                        class="rounded-2xl border border-blue-100 bg-blue-50/50 p-6 shadow-sm shadow-blue-100/60"
                    >
                        <h3 class="text-lg font-bold text-slate-900">
                            {{ pillar.title }}
                        </h3>
                        <p class="mt-3 text-sm leading-relaxed text-slate-600">
                            {{ pillar.body }}
                        </p>
                    </article>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
