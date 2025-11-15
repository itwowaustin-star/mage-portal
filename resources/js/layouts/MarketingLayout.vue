<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const navigation = [
    { label: '首页', href: '/' },
    { label: '服务体系', href: '/services' },
    { label: '关于我们', href: '/about' },
    { label: '团队介绍', href: '/team' },
    { label: '联系我们', href: '/contact' },
];

const mobileMenuOpen = ref(false);
</script>

<template>
    <div class="min-h-screen bg-white text-gray-900">
        <header class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur-md shadow-sm">
            <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4">
                <Link class="flex items-center gap-3" href="/">
                    <img
                        src="/logo.png"
                        alt="马格网络科技 Logo"
                        class="h-10 w-10 rounded-lg object-contain"
                    />
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-blue-600 font-semibold">MageNetwork</p>
                        <p class="-mt-1 text-base font-bold text-gray-900">马格网络</p>
                    </div>
                </Link>
                
                <!-- Desktop Navigation -->
                <nav class="hidden items-center gap-8 text-sm font-semibold lg:flex">
                    <Link
                        v-for="item in navigation"
                        :key="item.href"
                        :href="item.href"
                        class="text-gray-600 transition hover:text-blue-600"
                    >
                        {{ item.label }}
                    </Link>
                </nav>
                
                <div class="flex items-center gap-4">
                    <!-- Desktop CTA Button -->
                    <Link
                        href="/contact"
                        class="hidden rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-2 text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition hover:shadow-blue-600/50 hover:scale-105 lg:inline-flex"
                    >
                        联系顾问
                    </Link>
                    
                    <!-- Mobile Menu Button -->
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="lg:hidden p-2 rounded-lg hover:bg-gray-50 text-blue-600 transition"
                    >
                        <svg v-if="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Mobile Navigation -->
            <nav v-if="mobileMenuOpen" class="lg:hidden border-t border-gray-200 bg-gray-50 px-6 py-4 space-y-2">
                <Link
                    v-for="item in navigation"
                    :key="item.href"
                    :href="item.href"
                    class="block px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition"
                    @click="mobileMenuOpen = false"
                >
                    {{ item.label }}
                </Link>
                <Link
                    href="/contact"
                    class="block w-full mt-4 rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2 text-center text-sm font-semibold text-white shadow-lg shadow-blue-600/30 transition hover:shadow-blue-600/50"
                    @click="mobileMenuOpen = false"
                >
                    联系顾问
                </Link>
            </nav>
        </header>

        <main>
            <slot />
        </main>

        <footer class="mt-16 border-t border-gray-200 bg-gray-50 py-12 text-gray-600">
            <div class="mx-auto w-full max-w-6xl px-6">
                <div class="grid gap-8 md:grid-cols-3 mb-8">
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-blue-600 font-semibold">公司简介</p>
                        <p class="mt-3 text-sm text-gray-700">山西马格网络科技有限公司致力于为企业提供全方位的网络安全和信息化解决方案。</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-blue-600 font-semibold">快速链接</p>
                        <div class="mt-3 space-y-2 text-sm">
                            <Link href="/services" class="block hover:text-blue-600 transition">服务体系</Link>
                            <Link href="/about" class="block hover:text-blue-600 transition">关于我们</Link>
                            <Link href="/team" class="block hover:text-blue-600 transition">团队介绍</Link>
                            <Link href="/contact" class="block hover:text-blue-600 transition">联系我们</Link>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.35em] text-blue-600 font-semibold">联系方式</p>
                        <div class="mt-3 space-y-2 text-sm">
                            <p>电话：0349-2288789</p>
                            <p>邮箱：sxmgwl@163.com</p>
                            <p class="text-xs text-gray-500">itaustin@163.com</p>
                            <p class="text-xs text-gray-500 mt-2">地址：山西省朔州市开发区恒晟大厦 1204/1304/1703</p>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-200 pt-8 text-center">
                    <p class="text-xs text-gray-500">晋 ICP 备 2023002392 号-1 · © {{ new Date().getFullYear() }} MageNetwork. All Rights Reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</template>
