<script setup lang="ts">
import Task from '@/components/Task.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const props = defineProps<{
    tasks: Array<{
        id: number;
        title: string;
        description: string;
        is_completed: boolean;
    }>;
}>();

defineOptions({
    layout: AppLayout,
});

const taskForm = useForm({
    title: '',
    description: '',
    is_completed: false,
    due_date: '',
});

const updateTaskStatus = (taskId: number, completed: boolean) => {
    taskForm.is_completed = completed;
    taskForm.put(`/tasks/${taskId}`, {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Task status updated successfully');
        },
        onError: (errors) => {
            console.error('Error updating task status:', errors);
        },
    });
};

const deleteTask = (taskId: number) => {
    taskForm.delete(`/tasks/${taskId}`, {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Task deleted successfully');
        },
        onError: (errors) => {
            console.error('Error deleting task:', errors);
        },
    });
};

const openDialog = ref(false);

const showDialogBox = () => {
    alert('Button clicked!');
    openDialog.value = true;
};
</script>

<template>
    <Head title="Dashboard" />
    <div>
        <h3 class="m-5 rounded bg-blue-200 p-5">Incomplete tasks</h3>
        <ul class="w-full">
            <li v-for="task in tasks" :key="task.id" class="m-4">
                <Task
                    :task="task"
                    @update="updateTaskStatus(task.id, !task.is_completed)"
                    @delete="deleteTask(task.id)"
                />
                <!-- <div v-if="task.is_completed == false" class="flex">
                    <div>
                        <h3>{{ task.title }}</h3>
                        <p>{{ task.description }}</p>
                    </div>
                    <div class="m-4">
                        <form
                            @submit.prevent="
                                updateTaskStatus(task.id, !task.is_completed)
                            "
                        >
                            <button
                                class="primary bg-white-500 justify-end rounded border-2 px-4 py-2 hover:bg-gray-500"
                                type="submit"
                            >
                                Toggle Status
                            </button>
                        </form>
                    </div>
                </div> -->
            </li>
        </ul>
    </div>
</template>
