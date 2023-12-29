<script setup>
import { server } from '~/services/api.js'

const prop = defineProps({
    "champion": Object
})

const emit = defineEmits(['selectChampion'])



function selectChampion() {
    emit('selectChampion', prop.champion)
}

onMounted(() => {
    watch(isInfoOpen, (newValue) => {
        if (newValue) adjustInfoDivPosition();
    });
});

const isInfoOpen = ref(false)
const infoDiv = ref(null)


function adjustInfoDivPosition() {
    const infoDivRect = infoDiv.value.getBoundingClientRect();
    const rightEdge = infoDivRect.right;
    const screenRightEdge = window.innerWidth;
    console.log(rightEdge + 125, screenRightEdge)
    if (rightEdge + 125 > screenRightEdge) {
        infoDiv.value.style.left = "-125px";
        infoDiv.value.style.right = "";

    }else{
        infoDiv.value.style.right = "-125px";
        infoDiv.value.style.left = "";
    }
}
</script>


<template >
    <div @mouseover="isInfoOpen = true" @mouseleave="isInfoOpen = false"
        class="relative md:min-w-[200px] p-4 flex flex-col gap-4 border border-slate-600 rounded-lg bg-[#1E282D]">
        <div>
            <p class="text-xl font-bold m-auto w-fit ">{{ champion.name }}</p>
            <p class="text-md text-slate-400 italic font-bold m-auto w-fit ">{{ champion.title }}</p>
        </div>
        <div class="flex flex-col gap-4">
            <img :src="server + '/storage/' + champion.square_art_path" :alt="champion.name" loading="lazy"
                class="w-32 h-32 m-auto">
            <div v-if="champion.tags" class="flex gap-1 justify-center">
                <img v-for="tag in champion.tags" :key="tag" :src="server + '/storage/role_icons/' + tag + '_icon.webp'"
                    :alt="tag" class="w-[30px]" loading="lazy" :title="tag">
            </div>
        </div>
        <div ref="infoDiv" :class="isInfoOpen ? 'translate-x-0 opacity-100' : '-translate-x-20 opacity-0 z-0'"
            class="absolute transition duration-300 ease-in-out top-0  bg-[#1E282D] border border-slate-600 rounded-lg p-4 z-10 items-center justify-center flex flex-col gap-1">
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