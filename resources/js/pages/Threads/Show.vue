<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { formatDistance, parseISO } from 'date-fns';
import { computed } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

defineOptions({
    layout: AppLayout,
});

const props = defineProps<{
    thread: {
        id: number;
        title: string;
        participants: Array<{
            id: number;
            name: string;
        }>;
        messages: Array<{
            id: number;
            body: string;
            user: {
                id: number;
                name: string;
            };
        }>;
    };
}>();

const messagesSortedByCreatedAt = computed(() => {
    return props.thread.messages.slice().sort((a, b) => {
        return (
            new Date(a.created_at).getTime() - new Date(b.created_at).getTime()
        );
    });
});

const formattedDate = (dateString: string) => {
    return formatDistance(parseISO(dateString), new Date(), {
        addSuffix: true,
    });
};

const messageForm = useForm({
    body: '',
});

const createMessage = () => {
    // Placeholder function for creating a new message
    // console.log('sending message:', messageForm.body);
    // messageForm.reset();
    messageForm.post(`/threads/${props.thread.id}/messages`, {
        preserveScroll: true,
        onSuccess: () => {
            messageForm.reset();
        },
        onError: (errors) => {
            console.error('Error sending message:', errors);
        },
    });
};
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

        <h1 class="mb-6 text-2xl font-bold">{{ thread.title }}</h1>

        <div class="mb-4">
            <h2 class="mb-2 text-xl font-semibold">Messages</h2>
            <div v-if="thread.messages.length === 0" class="text-gray-500">
                No messages available.
            </div>
            <div v-else class="space-y-4">
                <div
                    v-for="message in messagesSortedByCreatedAt"
                    :key="message.id"
                    class="rounded-lg border p-4 transition-shadow hover:shadow-md"
                >
                    <div class="flex">
                        <div class="mr-4 mb-2 font-bold text-blue-600">
                            {{ message.user.name }}
                        </div>
                        <p class="mb-2">{{ message.body }}</p>
                        <span class="ml-auto text-sm text-gray-500">
                            <!-- Placeholder for timestamp -->
                            {{ formattedDate(message.created_at) }}
                        </span>
                    </div>
                </div>
                <form @submit.prevent="createMessage" class="mt-4">
                    <textarea
                        v-model="messageForm.body"
                        class="w-full rounded border p-2"
                        rows="4"
                        placeholder="Type your message here..."
                        @keyup.enter="createMessage"
                    ></textarea>
                    <button
                        type="submit"
                        class="mt-2 rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                    >
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
