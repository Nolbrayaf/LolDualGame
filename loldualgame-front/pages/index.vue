<template >
    <main class="flex flex-col items-center">
        <div class="p-8">
            <h1 class="text-5xl font-bold text-color-primary">LEAGUE OF LEGEND</h1>
            <h2 class="text-3xl font-bold text-color-primary italic text-center">The Dual Game</h2>
        </div>
        <p class="text-2xl">Choisissez votre champion</p>
        <div class="flex flex-col gap-4">


            <!-- Barre de recherche -->
            <form class="flex justify-between w-full border border-slate-600 text-white my-4  bg-transparent pr-4">
                <div class="flex items-center md:w-1/6">
                    <input type="search" v-model="search"
                        class="bg-transparent w-full h-full text-slate-400 p-4 outline-none" placeholder="Rechercher">
                    <IconsSearch class=" " />
                </div>
                <hr class="w-[1px] h-[35px] bg-slate-600 my-auto border-none">
                <div class="relative my-auto min-w-[80px]">
                    <div class="flex items-center justify-center gap-2 cursor-pointer text-slate-400 md:hidden"
                        @click="isTagsMenuOpen = !isTagsMenuOpen">
                        <p>Rôle</p>
                        <IconsArrowDown />
                    </div>
                    <ul v-if="tags" :class="isTagsMenuOpen ? 'absolute' : 'hidden'"
                        class="bg-primary w-[80px] h-[200px] border border-slate-600 border-t-0 md:border-none md:w-fit md:h-fit overflow-y-auto top-[165%] -left-0 md:bg-transparent md:sticky md:flex gap-2">
                        <li v-for="tag in tags"
                            :class="selectedTag === tag ? 'border-l-[#c2902d] border-l-2 md:border-l-0 md:border-b-[#c2902d] md:border-b-2' : 'hoverBorderEffect'"
                            class=" px-2 py-4  cursor-pointer sticky" @click="filterChampions(tag)">{{ tag }}</li>
                    </ul>
                </div>
                <hr class="w-[1px] h-[35px] bg-slate-600 my-auto border-none">

                <select v-if="difficulty" v-model="selectedDifficulty" id=""
                    class="bg-transparent text-slate-400 outline-none cursor-pointer">
                    <option value="" selected>Toutes les difficultés</option>
                    <option v-for="diff in difficulty" :value="diff">
                        {{ '★'.repeat(diff) }} {{ 10 - diff > 0 ? '☆'.repeat(10 - diff) : '' }}
                    </option>
                </select>

            </form>
            <!--                    -->



            <transition name="fade">
                <div v-if="displayedChampions" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 p-4">
                    <CardsChampion v-if="displayedChampions.length > 0" v-for="champion in displayedChampions"
                        :key="champion.id" :champion="champion" />
                    <p v-else class="text-slate-300 col-span-2 md:col-span-3 lg:col-span-5 text-center ">Aucun champion
                        trouvé</p>
                </div>
            </transition>
        </div>

    </main>
</template>

<script setup>

import { server } from '~/services/api.js'
const champions = ref()
const displayedChampions = ref()
const isLoading = ref()
const tags = ref(["Tout"])
const selectedTag = ref("Tout")
const difficulty = ref([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10])
const search = ref('')
const selectedDifficulty = ref('')
const isTagsMenuOpen = ref(false)



const filterChampions = (tag) => {
    selectedTag.value = tag;


    // Filtrer par tag, DOIT RECUPERER TOUS LES CHAMPIONS A CHAQUE APPEL
    if (tag !== "Tout") {
        displayedChampions.value = champions.value.filter(champion => champion.tags.includes(tag));
    } else {
        displayedChampions.value = champions.value
    }

    // Filtrer par nom de champion
    if (search.value) {
        displayedChampions.value = displayedChampions.value.filter(champion => champion.name.toLowerCase().includes(search.value.toLowerCase()));
    }

    // Filtrer par difficulté
    if (selectedDifficulty.value) {
        displayedChampions.value = displayedChampions.value.filter(champion => champion.info && champion.difficulty === Number(selectedDifficulty.value));
    }
}

watch(search, () => {
    filterChampions(selectedTag.value);
});
watch(selectedDifficulty, () => {
    filterChampions(selectedTag.value);
});

onMounted(async () => {
    fetch(server + '/api/champions_tags')
        .then(data => data.json())
        .then(data => {
            tags.value.push(...data);
            filterChampions("Tout");
        });
    isLoading.value = true;
    const response = await fetch(server + '/api/champions');
    const data = await response.json();
    champions.value = data.map(champion => ({
        ...champion,
        info: JSON.parse(champion.info),
        tags: JSON.parse(champion.tags)
    }));
    displayedChampions.value = champions.value;
    isLoading.value = false;
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