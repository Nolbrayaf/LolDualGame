<script setup>
import { server } from '~/services/api.js'

const prop = defineProps({
    "champion": Object,
    "isLoading": Boolean
})


</script>


<template >
    <div v-if="isLoading" class="p-4 flex flex-col gap-4 border border-slate-600 rounded-lg bg-[#1E282D] loading-animation">

        <div class="animate-pulse flex space-x-4">
            <div class="rounded-full bg-slate-700 h-12 w-12"></div>
            <div class="flex-1 space-y-6 py-1">
                <div class="h-2 bg-slate-700 rounded"></div>
                <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="h-2 bg-slate-700 rounded col-span-2"></div>
                        <div class="h-2 bg-slate-700 rounded col-span-1"></div>
                    </div>
                    <div class="h-2 bg-slate-700 rounded"></div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="p-4 flex flex-col gap-4 border border-slate-600 rounded-lg bg-[#1E282D]">
        <div>
            <p class="text-xl font-bold m-auto w-fit ">{{ champion.name }}</p>
            <p class="text-md text-slate-400 italic font-bold m-auto w-fit ">{{ champion.title }}</p>
        </div>
        <img :src="server + '/storage/' + champion.square_art_path" :alt="champion.name" class="w-32 h-32 m-auto">
    </div>
</template>

<style scoped>
@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.05);
        opacity: 0.7;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.loading-animation {
    animation: pulse 1s infinite ease-in-out;
}

</style>

