<template >
    <main class="flex flex-col items-center">
        <div class="p-8">
            <h1 class="text-5xl font-bold text-color-primary">LEAGUE OF LEGEND</h1>
            <h2 class="text-3xl font-bold text-color-primary italic text-center">The Dual Game</h2>
        </div>
        <p>Choisissez votre champion</p>
        <div class="flex flex-col gap-4">


            <!-- Barre de recherche -->
            <form v-if="tags"
                class="flex justify-between w-full border border-slate-600 text-white my-4  bg-transparent pr-4">
                <div class="relative md:w-1/6">
                    <IconsSearch class="absolute top-1/2 translate-y-[-50%] right-[-50px]" />
                    <input type="search" class="bg-transparent w-full h-full text-slate-400 p-4 outline-none"
                        placeholder="Rechercher">
                </div>
                <hr class="w-[1px] h-[35px] bg-slate-600 my-auto border-none">
                <ul class="flex gap-2">
                    <li v-for="tag in tags" class="px-2 py-4 hoverBorderEffect cursor-pointer"
                        @click="filterChampions(tag)">{{ tag }}</li>
                </ul>
                <hr class="w-[1px] h-[35px] bg-slate-600 my-auto border-none">

                <select name="difficulty" id="" class="bg-transparent text-slate-400 outline-none cursor-pointer">
                    <option value="" selected>Toutes les difficultés</option>
                    <option v-for="diff in difficulty" :value="diff" class="appare">
                        {{ '★'.repeat(diff) }} {{ 10 - diff > 0 ? '☆'.repeat(10 - diff) : '' }}
                    </option>
                </select>

            </form>
            <!--                    -->



            <transition name="fade">
                <div v-if="champions" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <CardsChampion v-for="champion in displayedChampions" :key="champion.id" :isLoading="isLoading" :champion="champion" />
                </div>
            </transition>
        </div>

    </main>
</template>

<script setup>
import { server } from '~/services/api.js'
const champions = ref()
const displayedChampions = ref()
const isLoading = ref(false)
const tags = ref(["Tout"])
const selectedTag = ref("Tout")
const difficulty = ref([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10])


const filterChampions = (tag) => {
    selectedTag.value = tag;
    displayedChampions.value = tag === "Tout"
        ? champions.value
        : champions.value.filter(champion => champion.tags.includes(tag));
}

onMounted(async () => {
    isLoading.value = true;
    const response = await fetch(server + '/api/champions');
    champions.value = await response.json();
    displayedChampions.value = champions.value;
    isLoading.value = false;
});

fetch(server + '/api/champions_tags')
    .then(data => data.json())
    .then(data => {
        tags.value.push(...data);
        filterChampions("Tout");
    });







</script>


<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(20px);

}

.fade-enter-to,
.fade-leave-from {
    opacity: 1;
    transform: translateY(0);
}

.hoverBorderEffect {
    position: relative;
}

.hoverBorderEffect::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background-color: #c2902d;
    transition: width 0.3s ease;
}

.hoverBorderEffect:hover::before {

    width: 50%;

}
</style>