<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Phone, ChatDotSquare, User } from '@element-plus/icons-vue';

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
                <el-text type="primary" class="text-xs uppercase tracking-widest font-semibold">ADVISORS</el-text>
                <h1 class="mt-4 text-4xl font-bold drop-shadow-lg">驻场顾问信息实时同步</h1>
                <el-text class="block mt-3">
                    后台录入的联系人会直接展示在这里，确保所有渠道使用同一组电话与微信。
                </el-text>
            </div>
        </section>

        <!-- Team Members Grid -->
        <section class="bg-gray-50 py-16">
            <div class="mx-auto w-full max-w-6xl px-6">
                <el-row :gutter="24">
                    <el-col
                        v-for="member in cleanedMembers"
                        :key="member.name"
                        :xs="24"
                        :md="12"
                        class="mb-6"
                    >
                        <el-card shadow="hover" class="h-full">
                            <template #header>
                                <el-space alignment="center">
                                    <el-avatar :size="48" :icon="User" />
                                    <div>
                                        <h2 class="text-xl font-bold">{{ member.name }}</h2>
                                        <el-text type="info" class="text-sm">{{ member.title }}</el-text>
                                    </div>
                                </el-space>
                            </template>
                            
                            <el-tag type="primary" class="mb-4">{{ member.expertise }}</el-tag>
                            
                            <el-space direction="vertical" :size="12" class="w-full">
                                <div v-if="member.phone" class="flex items-center gap-2">
                                    <Phone class="w-4 h-4 text-blue-600" />
                                    <el-text class="text-sm font-semibold">电话：</el-text>
                                    <el-link :href="`tel:${member.phone}`" type="primary" class="text-sm">
                                        {{ member.phone }}
                                    </el-link>
                                </div>
                                <div v-if="member.wechat" class="flex items-center gap-2">
                                    <ChatDotSquare class="w-4 h-4 text-blue-600" />
                                    <el-text class="text-sm font-semibold">微信：</el-text>
                                    <el-text class="text-sm">{{ member.wechat }}</el-text>
                                </div>
                            </el-space>
                        </el-card>
                    </el-col>
                </el-row>
            </div>
        </section>

        <!-- Team Pillars -->
        <section class="bg-white py-16">
            <div class="mx-auto w-full max-w-5xl px-6">
                <el-text type="primary" class="text-xs uppercase tracking-widest font-semibold">TEAM PILLARS</el-text>
                <h2 class="mt-3 text-2xl font-bold">部门职责清晰透明</h2>
                <el-row :gutter="24" class="mt-8">
                    <el-col
                        v-for="pillar in cleanedPillars"
                        :key="pillar.title"
                        :xs="24"
                        :md="8"
                        class="mb-6"
                    >
                        <el-card shadow="hover" class="h-full">
                            <template #header>
                                <h3 class="text-lg font-bold text-blue-600">{{ pillar.title }}</h3>
                            </template>
                            <el-text class="leading-relaxed">{{ pillar.body }}</el-text>
                        </el-card>
                    </el-col>
                </el-row>
            </div>
        </section>
    </MarketingLayout>
</template>
