<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Menu as IconMenu, Close } from '@element-plus/icons-vue';

const navigation = [
    { label: '首页', href: '/' },
    { label: '服务体系', href: '/services' },
    { label: '关于我们', href: '/about' },
    { label: '团队介绍', href: '/team' },
    { label: '联系我们', href: '/contact' },
];

const mobileMenuOpen = ref(false);
const activeIndex = computed(() => {
    const current = window.location.pathname;
    const index = navigation.findIndex(item => item.href === current);
    return index >= 0 ? String(index) : '0';
});

const handleMenuSelect = (index: string) => {
    const item = navigation[Number(index)];
    if (item) {
        router.visit(item.href);
    }
};
</script>

<template>
    <div class="min-h-screen bg-white text-gray-900">
        <el-affix :offset="0">
            <header class="border-b border-gray-200 bg-white/95 backdrop-blur-md shadow-sm">
                <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-3">
                    <Link class="flex items-center gap-3" href="/">
                        <el-avatar :size="40" src="/logo.png" shape="square" />
                        <div>
                            <p class="text-xs uppercase tracking-[0.35em] text-blue-600 font-semibold">MageNetwork</p>
                            <p class="-mt-1 text-base font-bold text-gray-900">马格网络</p>
                        </div>
                    </Link>
                    
                    <!-- Desktop Navigation -->
                    <el-menu
                        :default-active="activeIndex"
                        mode="horizontal"
                        :ellipsis="false"
                        class="hidden lg:flex border-none"
                        @select="handleMenuSelect"
                    >
                        <el-menu-item
                            v-for="(item, index) in navigation"
                            :key="item.href"
                            :index="String(index)"
                        >
                            {{ item.label }}
                        </el-menu-item>
                    </el-menu>
                    
                    <div class="flex items-center gap-4">
                        <!-- Desktop CTA Button -->
                        <el-button
                            type="primary"
                            class="hidden lg:inline-flex"
                            @click="router.visit('/contact')"
                        >
                            联系顾问
                        </el-button>
                        
                        <!-- Mobile Menu Button -->
                        <el-button
                            :icon="mobileMenuOpen ? Close : IconMenu"
                            circle
                            class="lg:hidden"
                            @click="mobileMenuOpen = !mobileMenuOpen"
                        />
                    </div>
                </div>
                
                <!-- Mobile Navigation -->
                <el-collapse-transition>
                    <div v-show="mobileMenuOpen" class="lg:hidden border-t border-gray-200 bg-gray-50 px-6 py-4">
                        <el-menu
                            :default-active="activeIndex"
                            class="border-none bg-transparent"
                            @select="(index: string) => { handleMenuSelect(index); mobileMenuOpen = false; }"
                        >
                            <el-menu-item
                                v-for="(item, index) in navigation"
                                :key="item.href"
                                :index="String(index)"
                            >
                                {{ item.label }}
                            </el-menu-item>
                        </el-menu>
                        <el-button
                            type="primary"
                            class="w-full mt-4"
                            @click="() => { router.visit('/contact'); mobileMenuOpen = false; }"
                        >
                            联系顾问
                        </el-button>
                    </div>
                </el-collapse-transition>
            </header>
        </el-affix>

        <main>
            <slot />
        </main>

        <footer class="mt-16 border-t border-gray-200 bg-gray-50 py-12">
            <div class="mx-auto w-full max-w-6xl px-6">
                <el-row :gutter="32" class="mb-8">
                    <el-col :xs="24" :md="8">
                        <el-text type="primary" class="text-xs uppercase tracking-[0.35em] font-semibold">公司简介</el-text>
                        <el-text class="mt-3 block text-sm">山西马格网络科技有限公司致力于为企业提供全方位的网络安全和信息化解决方案。</el-text>
                    </el-col>
                    <el-col :xs="24" :md="8">
                        <el-text type="primary" class="text-xs uppercase tracking-[0.35em] font-semibold">快速链接</el-text>
                        <div class="mt-3 space-y-2">
                            <Link href="/services" class="block text-sm hover:text-blue-600 transition">服务体系</Link>
                            <Link href="/about" class="block text-sm hover:text-blue-600 transition">关于我们</Link>
                            <Link href="/team" class="block text-sm hover:text-blue-600 transition">团队介绍</Link>
                            <Link href="/contact" class="block text-sm hover:text-blue-600 transition">联系我们</Link>
                        </div>
                    </el-col>
                    <el-col :xs="24" :md="8">
                        <el-text type="primary" class="text-xs uppercase tracking-[0.35em] font-semibold">联系方式</el-text>
                        <div class="mt-3 space-y-2">
                            <el-text class="block text-sm">电话：0349-2288789</el-text>
                            <el-text class="block text-sm">邮箱：sxmgwl@163.com</el-text>
                            <el-text type="info" class="block text-xs">itaustin@163.com</el-text>
                            <el-text type="info" class="block text-xs mt-2">地址：山西省朔州市开发区恒晟大厦 1204/1304/1703</el-text>
                        </div>
                    </el-col>
                </el-row>
                <el-divider />
                <div class="text-center">
                    <el-text type="info" class="text-xs">晋 ICP 备 2023002392 号-1 · © {{ new Date().getFullYear() }} MageNetwork. All Rights Reserved.</el-text>
                </div>
            </div>
        </footer>
    </div>
</template>
