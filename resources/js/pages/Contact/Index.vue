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

const flash = computed(() => usePage().props.flash as { type?: string; message?: string } | null);

// 过滤 HTML 实体和空白
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

const cleanedAdvisors = computed(() => 
    props.advisors.map(advisor => ({
        ...advisor,
        name: cleanText(advisor.name),
        title: cleanText(advisor.title),
        expertise: cleanText(advisor.expertise),
        phone: cleanText(advisor.phone),
        wechat: cleanText(advisor.wechat),
    }))
);
</script>

<template>
    <MarketingLayout>
        <Head title="联系顾问" />

        <!-- Contact Section -->
        <section class="bg-white py-16">
            <div class="mx-auto grid w-full max-w-5xl gap-8 px-6 lg:grid-cols-2">
                <!-- Contact Info -->
                <div class="rounded-lg border border-blue-200 bg-gradient-to-br from-white to-blue-50 p-8 shadow-lg shadow-blue-200/20">
                    <p class="text-xs uppercase tracking-widest font-semibold text-blue-600">CONTACT</p>
                    <h1 class="mt-4 text-3xl font-bold text-slate-900">{{ cta.title }}</h1>
                    <p class="mt-3 text-sm text-gray-600">
                        {{ cta.description }}
                    </p>
                    <dl class="mt-6 space-y-4 text-sm text-gray-600">
                        <div>
                            <dt class="text-xs uppercase tracking-widest font-semibold text-blue-600">负责顾问</dt>
                            <dd class="mt-1 font-semibold text-slate-900">
                                {{ contact.advisor ?? '待分配' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-widest font-semibold text-blue-600">电话</dt>
                            <dd class="mt-1 text-xl font-semibold text-blue-600">
                                <a :href="`tel:${contact.phone}`" class="hover:text-blue-700 hover:underline">{{ contact.phone }}</a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-widest font-semibold text-blue-600">邮箱</dt>
                            <dd class="mt-1">
                                <a :href="`mailto:${contact.email}`" class="text-blue-600 hover:text-blue-700 hover:underline">{{ contact.email }}</a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-widest font-semibold text-blue-600">微信</dt>
                            <dd class="mt-1">{{ contact.wechat }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-widest font-semibold text-blue-600">地址</dt>
                            <dd class="mt-1">{{ contact.address }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs uppercase tracking-widest font-semibold text-blue-600">响应时间</dt>
                            <dd class="mt-1">{{ contact.hours }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Contact Form -->
                <div class="rounded-lg border border-blue-200 bg-gradient-to-br from-blue-50 to-white p-8 shadow-lg shadow-blue-200/20">
                    <h2 class="text-2xl font-bold text-slate-900">提交需求信息</h2>
                    <p class="mt-2 text-sm text-gray-600">
                        表单会写入系统联系人列表，与驻场顾问共享，确保状态一致。
                    </p>
                    <div
                        v-if="flash?.message"
                        class="mt-6 rounded-lg border border-blue-300 bg-blue-50 px-4 py-3 text-sm text-blue-700"
                    >
                        {{ flash.message }}
                    </div>
                    <form
                        class="mt-8 space-y-6"
                        @submit.prevent="form.post(contactStore().url, {
                            onSuccess: () => form.reset('name', 'phone', 'company', 'email', 'content'),
                        })"
                    >
                        <div class="grid gap-6 md:grid-cols-2">
                            <label class="text-sm font-semibold text-slate-900">
                                姓名 *
                                <input
                                    v-model="form.name"
                                    type="text"
                                    name="name"
                                    class="mt-2 w-full rounded-lg border border-blue-200 bg-white px-4 py-2 text-sm text-slate-900 placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-500/30"
                                />
                                <span v-if="form.errors.name" class="mt-1 block text-xs text-blue-600">{{ form.errors.name }}</span>
                            </label>
                            <label class="text-sm font-semibold text-slate-900">
                                电话 *
                                <input
                                    v-model="form.phone"
                                    type="text"
                                    name="phone"
                                    class="mt-2 w-full rounded-lg border border-blue-200 bg-white px-4 py-2 text-sm text-slate-900 placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-500/30"
                                />
                                <span v-if="form.errors.phone" class="mt-1 block text-xs text-blue-600">{{ form.errors.phone }}</span>
                            </label>
                        </div>
                        <div class="grid gap-6 md:grid-cols-2">
                            <label class="text-sm font-semibold text-slate-900">
                                公司 / 单位
                                <input
                                    v-model="form.company"
                                    type="text"
                                    name="company"
                                    class="mt-2 w-full rounded-lg border border-blue-200 bg-white px-4 py-2 text-sm text-slate-900 placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-500/30"
                                />
                                <span v-if="form.errors.company" class="mt-1 block text-xs text-blue-600">{{ form.errors.company }}</span>
                            </label>
                            <label class="text-sm font-semibold text-slate-900">
                                邮箱
                                <input
                                    v-model="form.email"
                                    type="email"
                                    name="email"
                                    class="mt-2 w-full rounded-lg border border-blue-200 bg-white px-4 py-2 text-sm text-slate-900 placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-500/30"
                                />
                                <span v-if="form.errors.email" class="mt-1 block text-xs text-blue-600">{{ form.errors.email }}</span>
                            </label>
                        </div>
                        <label class="text-sm font-semibold text-slate-900">
                            需求内容 *
                            <textarea
                                v-model="form.content"
                                name="content"
                                rows="5"
                                class="mt-2 w-full rounded-lg border border-blue-200 bg-white px-4 py-3 text-sm text-slate-900 placeholder-gray-400 focus:border-blue-400 focus:ring-2 focus:ring-blue-500/30"
                            />
                            <span v-if="form.errors.content" class="mt-1 block text-xs text-blue-600">{{ form.errors.content }}</span>
                        </label>
                        <div class="flex flex-wrap items-center gap-4">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 px-8 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-400/50 transition hover:shadow-blue-400/80 hover:scale-105 disabled:cursor-not-allowed disabled:opacity-60 disabled:scale-100"
                            >
                                {{ form.processing ? '提交中...' : '提交需求' }}
                            </button>
                            <p class="text-sm text-gray-600">
                                或直接拨打
                                <a :href="`tel:${contact.phone}`" class="font-semibold text-blue-600 hover:text-blue-700 hover:underline">{{ contact.phone }}</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Advisors Section -->
        <section class="bg-white py-16" v-if="advisors.length">
            <div class="mx-auto w-full max-w-5xl px-6">
                <p class="text-xs font-semibold uppercase tracking-widest text-blue-600">ADVISORS</p>
                <h2 class="mt-2 text-3xl font-bold text-slate-900">联系人列表</h2>
                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    <article
                        v-for="advisor in cleanedAdvisors"
                        :key="advisor.name"
                        class="rounded-lg border border-blue-200 bg-gradient-to-br from-white to-blue-50 p-6 shadow-lg shadow-blue-200/20 hover:border-blue-300 hover:shadow-blue-300/30 transition-all"
                    >
                        <h3 class="text-lg font-bold text-blue-700">{{ advisor.name }}</h3>
                        <p class="text-sm text-gray-600">{{ advisor.title }}</p>
                        <p class="mt-2 text-sm font-medium text-blue-600">{{ advisor.expertise }}</p>
                        <div class="mt-4 space-y-1 text-sm text-gray-600">
                            <p v-if="advisor.phone">
                                <span class="font-semibold text-blue-600">电话</span>：<a :href="`tel:${advisor.phone}`" class="text-blue-600 hover:text-blue-700 hover:underline">{{ advisor.phone }}</a>
                            </p>
                            <p v-if="advisor.wechat">
                                <span class="font-semibold text-blue-600">微信</span>：{{ advisor.wechat }}
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </MarketingLayout>
</template>
