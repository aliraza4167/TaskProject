<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const props = defineProps<{
    threads: Array<{
        id: number;
        title: string;
        content: string;
    }>;
}>();

defineOptions({
    layout: AppLayout,
});
</script>

<template>
    <Head title="Dashboard" />

    <div class="container mx-auto p-4">
        <nav class="mb-4 text-sm" aria-label="Breadcrumb">
            <ol class="list-reset flex text-gray-600">
                <li
                    v-for="(breadcrumb, index) in breadcrumbs"
                    :key="index"
                    class="flex items-center"
                >
                    <a :href="breadcrumb.href" class="hover:underline">{{
                        breadcrumb.title
                    }}</a>
                    <span v-if="index < breadcrumbs.length - 1" class="mx-2"
                        >/</span
                    >
                </li>
            </ol>
        </nav>

        <h1 class="mb-6 text-2xl font-bold">Threads</h1>

        <div v-if="threads.length === 0" class="text-gray-500">
            No threads available.
        </div>

        <div v-else class="space-y-4">
            <Link
                v-for="thread in threads"
                :key="thread.id"
                class="rounded-lg border p-4 transition-shadow hover:shadow-md"
                :href="`/threads/${thread.id}`"
            >
                <h2 class="mb-2 text-xl font-semibold">{{ thread.title }}</h2>
                <p class="text-gray-700">{{ thread.content }}</p>
            </Link>
        </div>
    </div>
</template>
