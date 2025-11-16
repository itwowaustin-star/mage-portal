<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { store as contactStore } from '@/routes/contact';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface ContactInfo {
    phone: string;
    email: string;
    address: string;
    hours: string;
    wechat: string;
    advisor: string | null;
}

interface CtaInfo {
    title: string;
    description: string;
}

interface AdvisorCard {
    name: string;
    title: string;
    phone: string | null;
    wechat: string | null;
    expertise: string;
}

const props = defineProps<{
    contact: ContactInfo;
    cta: CtaInfo;
    advisors: AdvisorCard[];
}>();

const form = useForm({
    name: '',
    phone: '',
    company: '',
    email: '',
    content: '',
});

const flash = computed(
    () => usePage().props.flash as { type?: string; message?: string } | null,
);

const submitForm = (): void => {
    form.post(contactStore().url, {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

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

const cleanedAdvisors = computed(() =>
    props.advisors.map((advisor) => ({
        ...advisor,
        name: cleanText(advisor.name),
        title: cleanText(advisor.title),
        expertise: cleanText(advisor.expertise),
        phone: cleanText(advisor.phone),
        wechat: cleanText(advisor.wechat),
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
        <Head title="联系顾问" />

        <section
            class="bg-gradient-to-b from-blue-50/60 via-white to-blue-50/30 py-16"
        >
            <div class="mx-auto w-full max-w-5xl px-6">
                <div class="grid gap-10 lg:grid-cols-2">
                    <article
                        class="rounded-3xl border border-blue-100 bg-white/95 p-8 shadow-xl shadow-blue-100/70"
                    >
                        <p
                            class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                        >
                            CONTACT
                        </p>
                        <h1 class="mt-3 text-3xl font-bold text-slate-900">
                            {{ cta.title }}
                        </h1>
                        <p class="mt-3 text-sm leading-relaxed text-gray-600">
                            {{ cta.description }}
                        </p>

                        <div class="mt-8 space-y-4">
                            <div
                                class="flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-3"
                            >
                                <div
                                    class="rounded-xl bg-white px-3 py-2 text-sm font-semibold text-blue-600 shadow-inner shadow-blue-100"
                                >
                                    顾
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">
                                        负责顾问
                                    </p>
                                    <p
                                        class="text-base font-semibold text-slate-900"
                                    >
                                        {{ contact.advisor ?? '待分配' }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-3"
                            >
                                <svg
                                    class="h-5 w-5 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.6"
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
                                    <template v-if="isDialable(contact.phone)">
                                        <a
                                            :href="`tel:${contact.phone}`"
                                            class="text-base font-semibold text-blue-600 hover:underline"
                                        >
                                            {{ contact.phone }}
                                        </a>
                                    </template>
                                    <p
                                        v-else
                                        class="text-base font-semibold text-slate-900"
                                    >
                                        {{ contact.phone }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-3"
                            >
                                <svg
                                    class="h-5 w-5 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500">邮箱</p>
                                    <a
                                        :href="`mailto:${contact.email}`"
                                        class="text-base font-semibold break-words text-blue-600 hover:underline"
                                    >
                                        {{ contact.email }}
                                    </a>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-3"
                            >
                                <svg
                                    class="h-5 w-5 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 11c1.105 0 2-.672 2-1.5S13.105 8 12 8s-2 .672-2 1.5.895 1.5 2 1.5z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 13c-2.33 0-7 1.17-7 3.5V19h14v-2.5C19 14.17 14.33 13 12 13z"
                                    />
                                </svg>
                                <div>
                                    <p class="text-xs text-slate-500">微信</p>
                                    <p
                                        class="text-base font-semibold text-slate-900"
                                    >
                                        {{ contact.wechat }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-start gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-3"
                            >
                                <svg
                                    class="h-5 w-5 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 2c4.418 0 8 3.134 8 7 0 5.25-8 13-8 13S4 14.25 4 9c0-3.866 3.582-7 8-7z"
                                    />
                                </svg>
                                <div class="min-w-0">
                                    <p class="text-xs text-slate-500">地址</p>
                                    <p
                                        class="text-base leading-relaxed font-semibold text-slate-900"
                                    >
                                        {{ contact.address }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-3"
                            >
                                <svg
                                    class="h-5 w-5 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <div>
                                    <p class="text-xs text-slate-500">
                                        响应时间
                                    </p>
                                    <p
                                        class="text-base font-semibold text-slate-900"
                                    >
                                        {{ contact.hours }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article
                        class="rounded-3xl border border-blue-100 bg-white/95 p-8 shadow-xl shadow-blue-100/70"
                    >
                        <p
                            class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                        >
                            SUBMIT
                        </p>
                        <h2 class="mt-2 text-2xl font-bold text-slate-900">
                            提交需求信息
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">
                            表单同步至后台联系人，与驻场顾问共享状态。
                        </p>

                        <div
                            v-if="flash?.message"
                            class="mt-4 rounded-2xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm text-emerald-800"
                        >
                            {{ flash.message }}
                        </div>

                        <form
                            class="mt-6 space-y-5"
                            @submit.prevent="submitForm"
                        >
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label
                                        class="text-sm font-medium text-slate-700"
                                    >
                                        姓名
                                        <input
                                            v-model="form.name"
                                            type="text"
                                            placeholder="请输入姓名"
                                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                                            required
                                        />
                                    </label>
                                    <p
                                        v-if="form.errors.name"
                                        class="mt-1 text-xs text-rose-600"
                                    >
                                        {{ form.errors.name }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="text-sm font-medium text-slate-700"
                                    >
                                        电话
                                        <input
                                            v-model="form.phone"
                                            type="text"
                                            placeholder="请输入电话"
                                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                                            required
                                        />
                                    </label>
                                    <p
                                        v-if="form.errors.phone"
                                        class="mt-1 text-xs text-rose-600"
                                    >
                                        {{ form.errors.phone }}
                                    </p>
                                </div>
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label
                                        class="text-sm font-medium text-slate-700"
                                    >
                                        公司
                                        <input
                                            v-model="form.company"
                                            type="text"
                                            placeholder="请输入公司名称"
                                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                                        />
                                    </label>
                                    <p
                                        v-if="form.errors.company"
                                        class="mt-1 text-xs text-rose-600"
                                    >
                                        {{ form.errors.company }}
                                    </p>
                                </div>
                                <div>
                                    <label
                                        class="text-sm font-medium text-slate-700"
                                    >
                                        邮箱
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            placeholder="请输入邮箱地址"
                                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                                        />
                                    </label>
                                    <p
                                        v-if="form.errors.email"
                                        class="mt-1 text-xs text-rose-600"
                                    >
                                        {{ form.errors.email }}
                                    </p>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="text-sm font-medium text-slate-700"
                                >
                                    需求内容
                                    <textarea
                                        v-model="form.content"
                                        rows="5"
                                        placeholder="请详细描述您的场景或项目，我们将安排顾问尽快联系。"
                                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:outline-none"
                                        required
                                    ></textarea>
                                </label>
                                <p
                                    v-if="form.errors.content"
                                    class="mt-1 text-xs text-rose-600"
                                >
                                    {{ form.errors.content }}
                                </p>
                            </div>

                            <div
                                class="flex flex-wrap items-center gap-3 text-sm text-slate-600"
                            >
                                <button
                                    type="submit"
                                    class="rounded-2xl bg-gradient-to-r from-blue-600 to-blue-500 px-8 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-400/50 transition hover:scale-[1.01] hover:shadow-blue-400/80 disabled:cursor-not-allowed disabled:opacity-70"
                                    :disabled="form.processing"
                                >
                                    {{
                                        form.processing ? '提交中…' : '提交需求'
                                    }}
                                </button>
                                <span class="whitespace-nowrap">
                                    或直接拨打
                                    <template v-if="isDialable(contact.phone)">
                                        <a
                                            :href="`tel:${contact.phone}`"
                                            class="font-semibold text-blue-600 hover:underline"
                                        >
                                            {{ contact.phone }}
                                        </a>
                                    </template>
                                    <span
                                        v-else
                                        class="font-semibold text-slate-900"
                                        >{{ contact.phone }}</span
                                    >
                                </span>
                            </div>
                        </form>
                    </article>
                </div>
            </div>
        </section>

        <section
            class="border-t border-blue-50 bg-white py-16"
            v-if="advisors.length"
        >
            <div class="mx-auto w-full max-w-5xl px-6">
                <p
                    class="text-xs font-semibold tracking-widest text-blue-600 uppercase"
                >
                    ADVISORS
                </p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">
                    联系人列表
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    门户后台录入的顾问信息实时同步，确保电话与微信渠道一致。
                </p>

                <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <article
                        v-for="advisor in cleanedAdvisors"
                        :key="advisor.name"
                        class="flex h-full flex-col rounded-3xl border border-blue-100 bg-white/95 p-6 shadow-lg shadow-blue-100/60"
                    >
                        <div class="flex items-center gap-4">
                            <div
                                class="grid h-14 w-14 place-items-center rounded-full bg-blue-100 text-xl font-semibold text-blue-700"
                            >
                                {{ advisorInitial(advisor.name) }}
                            </div>
                            <div>
                                <p class="text-lg font-bold text-slate-900">
                                    {{ advisor.name }}
                                </p>
                                <p class="text-sm text-slate-500">
                                    {{ advisor.title }}
                                </p>
                            </div>
                        </div>

                        <div
                            class="mt-5 rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3 text-sm leading-relaxed text-blue-700"
                        >
                            {{ advisor.expertise }}
                        </div>

                        <div class="mt-5 space-y-3">
                            <div
                                v-if="advisor.phone"
                                class="flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-3"
                            >
                                <svg
                                    class="h-4 w-4 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.69l1.35 4.06a1 1 0 01-.46 1.18l-2.07 1.13a11 11 0 005.51 5.51l1.13-2.07a1 1 0 011.18-.46l4.06 1.35a1 1 0 01.69.95V19a2 2 0 01-2 2h-1C9.16 21 3 14.84 3 7V5z"
                                    />
                                </svg>
                                <div class="text-sm">
                                    <p class="text-xs text-slate-500">电话</p>
                                    <template v-if="isDialable(advisor.phone)">
                                        <a
                                            :href="`tel:${advisor.phone}`"
                                            class="font-semibold text-blue-600 hover:underline"
                                        >
                                            {{ advisor.phone }}
                                        </a>
                                    </template>
                                    <p
                                        v-else
                                        class="font-semibold text-slate-900"
                                    >
                                        {{ advisor.phone }}
                                    </p>
                                </div>
                            </div>

                            <div
                                v-if="advisor.wechat"
                                class="flex items-center gap-3 rounded-2xl border border-blue-100 bg-blue-50/70 px-4 py-3"
                            >
                                <svg
                                    class="h-4 w-4 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M8 9h8m-8 4h5m7-1a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                <div class="text-sm">
                                    <p class="text-xs text-slate-500">微信</p>
                                    <p
                                        class="font-semibold break-all text-slate-900"
                                    >
                                        {{ advisor.wechat }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
