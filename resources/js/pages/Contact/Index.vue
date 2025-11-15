<script setup lang="ts">
import MarketingLayout from '@/layouts/MarketingLayout.vue';
import { store as contactStore } from '@/routes/contact';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Phone, Message, Location, Clock, User, ChatDotSquare } from '@element-plus/icons-vue';
import type { FormInstance, FormRules } from 'element-plus';
import { ElMessage } from 'element-plus';

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

const formRef = ref<FormInstance>();
const form = useForm({
    name: '',
    phone: '',
    company: '',
    email: '',
    content: '',
});

const rules: FormRules = {
    name: [
        { required: true, message: '请输入姓名', trigger: 'blur' },
        { min: 2, max: 50, message: '姓名长度在 2 到 50 个字符', trigger: 'blur' }
    ],
    phone: [
        { required: true, message: '请输入电话', trigger: 'blur' },
        { pattern: /^1[3-9]\d{9}$/, message: '请输入正确的手机号码', trigger: 'blur' }
    ],
    email: [
        { type: 'email', message: '请输入正确的邮箱地址', trigger: 'blur' }
    ],
    content: [
        { required: true, message: '请输入需求内容', trigger: 'blur' },
        { min: 10, message: '需求内容至少 10 个字符', trigger: 'blur' }
    ]
};

const flash = computed(() => usePage().props.flash as { type?: string; message?: string } | null);

const submitForm = async () => {
    if (!formRef.value) return;
    
    await formRef.value.validate((valid) => {
        if (valid) {
            form.post(contactStore().url, {
                onSuccess: () => {
                    form.reset('name', 'phone', 'company', 'email', 'content');
                    ElMessage.success('提交成功！我们会尽快与您联系。');
                },
                onError: () => {
                    ElMessage.error('提交失败，请检查表单信息。');
                }
            });
        }
    });
};

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
        <section class="bg-gray-50 py-16">
            <div class="mx-auto w-full max-w-5xl px-6">
                <el-row :gutter="24">
                    <!-- Contact Info -->
                    <el-col :xs="24" :lg="12" class="mb-6 lg:mb-0">
                        <el-card shadow="hover" class="h-full">
                            <template #header>
                                <el-text type="primary" class="text-xs uppercase tracking-widest font-semibold">CONTACT</el-text>
                                <h1 class="mt-2 text-2xl font-bold">{{ cta.title }}</h1>
                                <el-text class="text-sm">{{ cta.description }}</el-text>
                            </template>
                            
                            <el-space direction="vertical" :size="20" class="w-full">
                                <div class="flex items-start gap-3">
                                    <el-icon color="#2563eb" :size="18" class="mt-0.5"><User /></el-icon>
                                    <div class="flex-1">
                                        <el-text type="info" class="text-xs block mb-1">负责顾问</el-text>
                                        <el-text class="font-semibold">{{ contact.advisor ?? '待分配' }}</el-text>
                                    </div>
                                </div>
                                
                                <el-divider class="my-0" />
                                
                                <div class="flex items-start gap-3">
                                    <el-icon color="#2563eb" :size="18" class="mt-0.5"><Phone /></el-icon>
                                    <div class="flex-1">
                                        <el-text type="info" class="text-xs block mb-1">电话</el-text>
                                        <el-link :href="`tel:${contact.phone}`" type="primary" class="text-lg font-semibold">
                                            {{ contact.phone }}
                                        </el-link>
                                    </div>
                                </div>
                                
                                <el-divider class="my-0" />
                                
                                <div class="flex items-start gap-3">
                                    <el-icon color="#2563eb" :size="18" class="mt-0.5"><Message /></el-icon>
                                    <div class="flex-1">
                                        <el-text type="info" class="text-xs block mb-1">邮箱</el-text>
                                        <el-link :href="`mailto:${contact.email}`" type="primary">
                                            {{ contact.email }}
                                        </el-link>
                                    </div>
                                </div>
                                
                                <el-divider class="my-0" />
                                
                                <div class="flex items-start gap-3">
                                    <el-icon color="#2563eb" :size="18" class="mt-0.5"><ChatDotSquare /></el-icon>
                                    <div class="flex-1">
                                        <el-text type="info" class="text-xs block mb-1">微信</el-text>
                                        <el-text>{{ contact.wechat }}</el-text>
                                    </div>
                                </div>
                                
                                <el-divider class="my-0" />
                                
                                <div class="flex items-start gap-3">
                                    <el-icon color="#2563eb" :size="18" class="mt-0.5"><Location /></el-icon>
                                    <div class="flex-1">
                                        <el-text type="info" class="text-xs block mb-1">地址</el-text>
                                        <el-text>{{ contact.address }}</el-text>
                                    </div>
                                </div>
                                
                                <el-divider class="my-0" />
                                
                                <div class="flex items-start gap-3">
                                    <el-icon color="#2563eb" :size="18" class="mt-0.5"><Clock /></el-icon>
                                    <div class="flex-1">
                                        <el-text type="info" class="text-xs block mb-1">响应时间</el-text>
                                        <el-text>{{ contact.hours }}</el-text>
                                    </div>
                                </div>
                            </el-space>
                        </el-card>
                    </el-col>

                    <!-- Contact Form -->
                    <el-col :xs="24" :lg="12">
                        <el-card shadow="hover" class="h-full">
                            <template #header>
                                <h2 class="text-xl font-bold">提交需求信息</h2>
                                <el-text class="text-sm">表单会写入系统联系人列表，与驻场顾问共享，确保状态一致。</el-text>
                            </template>
                            
                            <el-alert
                                v-if="flash?.message"
                                :title="flash.message"
                                type="success"
                                class="mb-6"
                                :closable="false"
                            />
                            
                            <el-form
                                ref="formRef"
                                :model="form"
                                :rules="rules"
                                label-position="top"
                                @submit.prevent="submitForm"
                            >
                                <el-row :gutter="16">
                                    <el-col :span="12">
                                        <el-form-item label="姓名" prop="name" required>
                                            <el-input
                                                v-model="form.name"
                                                placeholder="请输入您的姓名"
                                                clearable
                                            />
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="12">
                                        <el-form-item label="电话" prop="phone" required>
                                            <el-input
                                                v-model="form.phone"
                                                placeholder="请输入您的电话"
                                                clearable
                                            />
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                
                                <el-row :gutter="16">
                                    <el-col :span="12">
                                        <el-form-item label="公司 / 单位" prop="company">
                                            <el-input
                                                v-model="form.company"
                                                placeholder="请输入公司或单位名称"
                                                clearable
                                            />
                                        </el-form-item>
                                    </el-col>
                                    <el-col :span="12">
                                        <el-form-item label="邮箱" prop="email">
                                            <el-input
                                                v-model="form.email"
                                                placeholder="请输入您的邮箱"
                                                clearable
                                            />
                                        </el-form-item>
                                    </el-col>
                                </el-row>
                                
                                <el-form-item label="需求内容" prop="content" required>
                                    <el-input
                                        v-model="form.content"
                                        type="textarea"
                                        :rows="5"
                                        placeholder="请详细描述您的需求..."
                                    />
                                </el-form-item>
                                
                                <el-form-item>
                                    <el-space>
                                        <el-button
                                            type="primary"
                                            native-type="submit"
                                            :loading="form.processing"
                                            size="large"
                                        >
                                            {{ form.processing ? '提交中...' : '提交需求' }}
                                        </el-button>
                                        <el-text class="text-sm">
                                            或直接拨打
                                            <el-link :href="`tel:${contact.phone}`" type="primary">{{ contact.phone }}</el-link>
                                        </el-text>
                                    </el-space>
                                </el-form-item>
                            </el-form>
                        </el-card>
                    </el-col>
                </el-row>
            </div>
        </section>

        <!-- Advisors Section -->
        <section class="bg-white py-16" v-if="advisors.length">
            <div class="mx-auto w-full max-w-5xl px-6">
                <el-text type="primary" class="text-xs uppercase tracking-widest font-semibold">ADVISORS</el-text>
                <h2 class="mt-2 text-2xl font-bold">联系人列表</h2>
                <el-row :gutter="24" class="mt-8">
                    <el-col
                        v-for="advisor in cleanedAdvisors"
                        :key="advisor.name"
                        :xs="24"
                        :sm="12"
                        :md="8"
                        class="mb-6"
                    >
                        <el-card shadow="hover" class="h-full">
                            <template #header>
                                <div class="flex items-center gap-3">
                                    <el-avatar :size="40" class="bg-blue-100 text-blue-600">
                                        <el-icon :size="24"><User /></el-icon>
                                    </el-avatar>
                                    <div>
                                        <h3 class="text-lg font-bold text-blue-600">{{ advisor.name }}</h3>
                                        <el-text type="info" class="text-sm">{{ advisor.title }}</el-text>
                                    </div>
                                </div>
                            </template>
                            
                            <el-space direction="vertical" :size="12" class="w-full">
                                <div>
                                    <el-tag type="primary" size="large">{{ advisor.expertise }}</el-tag>
                                </div>
                                
                                <div v-if="advisor.phone" class="flex items-center gap-2">
                                    <Phone class="w-4 h-4 text-blue-600" />
                                    <el-text class="text-xs text-gray-600">电话：</el-text>
                                    <el-link :href="`tel:${advisor.phone}`" type="primary" class="text-sm">
                                        {{ advisor.phone }}
                                    </el-link>
                                </div>
                                <div v-if="advisor.wechat" class="flex items-center gap-2">
                                    <ChatDotSquare class="w-4 h-4 text-blue-600" />
                                    <el-text class="text-xs text-gray-600">微信：</el-text>
                                    <el-text class="text-sm">{{ advisor.wechat }}</el-text>
                                </div>
                            </el-space>
                        </el-card>
                    </el-col>
                </el-row>
            </div>
        </section>
    </MarketingLayout>
</template>
