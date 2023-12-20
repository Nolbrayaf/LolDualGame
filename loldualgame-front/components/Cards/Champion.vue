<script setup>
import { server } from '~/services/api.js'

const prop = defineProps({
    "champion": Object
})


</script>


<template >
    <div class="p-4 flex flex-col gap-4 border border-slate-600 rounded-lg bg-[#1E282D]">
        <div>
            <p class="text-xl font-bold m-auto w-fit ">{{ champion.name }}</p>
            <p class="text-md text-slate-400 italic font-bold m-auto w-fit ">{{ champion.title }}</p>
        </div>
        <img :src="server + '/storage/' + champion.square_art_path" :alt="champion.name" class="w-32 h-32 m-auto">
    </div>
</template>

