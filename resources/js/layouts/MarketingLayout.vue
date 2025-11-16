<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';

const navigation = [
    { label: '首页', href: '/' },
    { label: '服务体系', href: '/services' },
    { label: '关于我们', href: '/about' },
    { label: '团队介绍', href: '/team' },
    { label: '联系我们', href: '/contact' },
];

const mobileMenuOpen = ref(false);
const page = usePage();
const currentPath = computed(() => page.url.split('?')[0]);

watch(
    () => page.url,
    () => {
        mobileMenuOpen.value = false;
    },
);
</script>

<template>
    <div class="min-h-screen bg-white text-slate-900">
        <header
            class="sticky top-0 z-30 border-b border-slate-100 bg-white/90 backdrop-blur"
        >
            <div
                class="mx-auto flex w-full max-w-6xl items-center justify-between px-6 py-4"
            >
                <Link class="flex items-center gap-3" href="/">
                    <img
                        src="/logo.png"
                        alt="马格网络 Logo"
                        class="h-11 w-11 rounded-2xl border border-blue-100 bg-white object-contain shadow-sm"
                    />
                    <div>
                        <p
                            class="text-[0.65rem] font-semibold tracking-[0.4em] text-blue-600 uppercase"
                        >
                            MageNetwork
                        </p>
                        <p class="-mt-1 text-lg font-bold text-slate-900">
                            马格网络
                        </p>
                    </div>
                </Link>

                <nav
                    class="hidden items-center gap-8 text-sm font-semibold text-slate-600 lg:flex"
                >
                    <Link
                        v-for="item in navigation"
                        :key="item.href"
                        :href="item.href"
                        :class="[
                            'relative transition',
                            currentPath === item.href
                                ? 'text-blue-600'
                                : 'hover:text-slate-900',
                        ]"
                    >
                        {{ item.label }}
                        <span
                            v-if="currentPath === item.href"
                            class="absolute -bottom-2 left-1/2 h-0.5 w-8 -translate-x-1/2 rounded-full bg-gradient-to-r from-blue-500 to-blue-400"
                        />
                    </Link>
                </nav>

                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        class="hidden rounded-full bg-gradient-to-r from-blue-600 to-blue-500 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-blue-400/40 transition hover:scale-[1.02] hover:shadow-blue-400/80 lg:inline-flex"
                        @click="router.visit('/contact')"
                    >
                        联系顾问
                    </button>
                    <button
                        type="button"
                        class="grid h-10 w-10 place-items-center rounded-full border border-slate-200 text-slate-600 lg:hidden"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                    >
                        <svg
                            v-if="!mobileMenuOpen"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.6"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 8h16M4 16h16"
                            />
                        </svg>
                        <svg
                            v-else
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.6"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>

            <div
                v-show="mobileMenuOpen"
                class="border-t border-slate-100 bg-white px-6 py-4 lg:hidden"
            >
                <nav class="space-y-3">
                    <Link
                        v-for="item in navigation"
                        :key="item.href"
                        :href="item.href"
                        class="block rounded-2xl border border-slate-100 px-4 py-3 text-sm font-semibold"
                        :class="
                            currentPath === item.href
                                ? 'bg-blue-50 text-blue-600'
                                : 'text-slate-600'
                        "
                    >
                        {{ item.label }}
                    </Link>
                </nav>
                <button
                    type="button"
                    class="mt-4 w-full rounded-2xl bg-gradient-to-r from-blue-600 to-blue-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-400/40 transition hover:shadow-blue-400/80"
                    @click="router.visit('/contact')"
                >
                    联系顾问
                </button>
            </div>
        </header>

        <main>
            <slot />
        </main>

        <footer class="mt-16 border-t border-slate-100 bg-slate-50/70 py-12">
            <div class="mx-auto w-full max-w-6xl space-y-8 px-6">
                <div class="grid gap-8 md:grid-cols-3">
                    <div>
                        <p
                            class="text-xs font-semibold tracking-[0.4em] text-blue-600 uppercase"
                        >
                            公司简介
                        </p>
                        <p class="mt-3 text-sm text-slate-600">
                            山西马格网络科技有限公司致力于为企业提供全方位的网络安全和信息化解决方案。
                        </p>
                    </div>
                    <div>
                        <p
                            class="text-xs font-semibold tracking-[0.4em] text-blue-600 uppercase"
                        >
                            快速链接
                        </p>
                        <div class="mt-3 space-y-2 text-sm">
                            <Link
                                href="/services"
                                class="block text-slate-600 transition hover:text-blue-600"
                                >服务体系</Link
                            >
                            <Link
                                href="/about"
                                class="block text-slate-600 transition hover:text-blue-600"
                                >关于我们</Link
                            >
                            <Link
                                href="/team"
                                class="block text-slate-600 transition hover:text-blue-600"
                                >团队介绍</Link
                            >
                            <Link
                                href="/contact"
                                class="block text-slate-600 transition hover:text-blue-600"
                                >联系我们</Link
                            >
                        </div>
                    </div>
                    <div>
                        <p
                            class="text-xs font-semibold tracking-[0.4em] text-blue-600 uppercase"
                        >
                            联系方式
                        </p>
                        <div class="mt-3 space-y-2 text-sm text-slate-600">
                            <p>电话：0349-2288789</p>
                            <p>邮箱：sxmgwl@163.com</p>
                            <p class="text-xs text-slate-500">
                                itaustin@163.com
                            </p>
                            <p class="text-xs text-slate-500">
                                地址：山西省朔州市开发区恒晟大厦 1204/1304/1703
                            </p>
                        </div>
                    </div>
                </div>
                <div
                    class="border-t border-slate-100 pt-6 text-center text-xs text-slate-500"
                >
                    晋 ICP 备 2023002392 号-1 · ©
                    {{ new Date().getFullYear() }} MageNetwork. All Rights
                    Reserved.
                </div>
            </div>
        </footer>
    </div>
</template>
