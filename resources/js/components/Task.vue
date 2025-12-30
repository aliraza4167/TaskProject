<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';

defineOptions({
    layout: AppLayout,
});

const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
});

defineEmits(['update', 'delete']);
</script>

<template>
    <p class="flex items-center justify-between border-b pb-2">
        <div>
            <h3 :class="{ 'line-through': task.is_completed }">
                {{ task.title }}
            </h3>
            <p :class="{ 'line-through': task.is_completed }">{{ task.description }}</p>
        </div>
        <div class="flex space-x-2">
            <button
                @click="
                    $emit('update', {
                        ...task,
                        is_completed: !task.is_completed,
                    })
                "
                :class="task.is_completed ? 'bg-green-500' : 'bg-yellow-500'"
                class="rounded px-4 py-2 text-white"
            >
                {{ task.is_completed ? 'Mark Incomplete' : 'Mark Complete' }}
            </button>
            <button
                @click="$emit('delete', task.id)"
                class="rounded bg-red-500 px-4 py-2 text-white"
            >
                Delete
            </button>
        </div>
    </p>
</template>
