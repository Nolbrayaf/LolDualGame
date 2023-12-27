<script setup>
import { server } from '~/services/api.js'

const prop = defineProps({
    "champion": Object
})

const emit = defineEmits(['selectChampion'])

function selectChampion(){
    emit('selectChampion', prop.champion)
}


const isInfoOpen = ref(false)
const isFullInfoOpen = ref(false)

</script>


<template >
    <div class="relative group md:min-w-[200px] p-4 flex flex-col gap-4 border border-slate-600 rounded-lg bg-[#1E282D]">
        <div>
            <p class="text-xl font-bold m-auto w-fit ">{{ champion.name }}</p>
            <p class="text-md text-slate-400 italic font-bold m-auto w-fit ">{{ champion.title }}</p>
        </div>
        <div v-if="!isInfoOpen" class="flex flex-col gap-4">
            <img :src="server + '/storage/' + champion.square_art_path" :alt="champion.name" loading="lazy"
                class="w-32 h-32 m-auto">
            <div v-if="champion.tags" class="flex gap-1 justify-center">
                <img v-for="tag in champion.tags" :key="tag" :src="server + '/storage/role_icons/' + tag + '_icon.webp'"
                    :alt="tag" class="w-[30px]" loading="lazy" :title="tag">
            </div>
        </div>
        <div v-else class="items-center justify-center flex flex-col gap-1">
            <p class="text-md text-slate-300 italic">Attaque : {{ champion.info.attack }}</p>
            <p class="text-md text-slate-300 italic">Magie : {{ champion.info.magic }}</p>
            <p class="text-md text-slate-300 italic">Défense : {{ champion.info.defense }}</p>
            <p class="text-md text-slate-300 italic">Difficulté : {{ champion.info.difficulty }}</p>

        </div>
        <ProgressCircle title="Difficulté" :progress="champion.info.difficulty * 10" :text="champion.info.difficulty"
            fillColor="#c2902d" class="scale-[0.2] absolute -top-11 -right-11 cursor-default" />
        <IconsInfo @mouseover="isInfoOpen = true" @mouseleave="isInfoOpen = false" @click="selectChampion"
            class="absolute top-1 left-1 cursor-pointer" />
    </div>
</template>

<style scoped></style>