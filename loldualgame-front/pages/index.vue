<template >
    <main class="flex flex-col items-center">

        <!-- Blank Space for Header Fixed-->
        <div class="h-[61px] md:hidden">

        </div>
        <div class="p-8">
            <h1 class="text-5xl font-bold text-color-primary">LEAGUE OF LEGEND</h1>
            <h2 class="text-3xl font-bold text-color-primary italic text-center">The Dual Game</h2>
        </div>
        <p class="text-2xl">Choisissez votre champion</p>
        <div class="flex flex-col gap-4">

            <!-- Filter -->
            <form class="flex justify-between w-full border border-slate-600 text-white my-4  bg-transparent pr-4">
                <!-- SearchBar -->
                <div :class="isSearchBarFocused ? 'w-full transition duration-300 ease-in-out' : ''"
                    class=" flex items-center  md:w-1/6">
                    <input @focus="isSearchBarFocused = true" @blur="isSearchBarFocused = false" id="searchBar"
                        type="search" v-model="search"
                        :class="isSearchBarFocused ? 'w-full transition duration-300 ease-in-out' : ''"
                        class=" bg-transparent w-full h-full text-slate-400 p-4 outline-none" placeholder="Rechercher">
                    <label for="searchBar">
                        <IconsSearch class=" " />
                    </label>
                </div>
                <hr class="w-[1px] h-[35px] bg-slate-600 my-auto border-none">

                <!-- Role Filter -->
                <div :class="isSearchBarFocused ? 'hidden md:flex' : ''" class="relative my-auto min-w-[80px]">
                    <div class="flex items-center justify-center gap-2 cursor-pointer text-slate-400 md:hidden"
                        @click="isTagsMenuOpen = !isTagsMenuOpen">
                        <p>Rôle</p>
                        <IconsArrowDown />
                    </div>
                    <ul v-if="tags" :class="isTagsMenuOpen ? 'absolute' : 'hidden'"
                        class="bg-primary w-[80px] h-[200px] border border-slate-600 border-t-0 md:border-none md:w-fit md:h-fit overflow-y-auto top-[165%] -left-0 md:bg-transparent md:sticky md:flex gap-2 z-10">
                        <li v-for="tag in tags"
                            :class="selectedTag === tag ? 'border-l-[#c2902d] border-l-2 md:border-l-0 md:border-b-[#c2902d] md:border-b-2' : 'hoverBorderEffect'"
                            class=" px-2 py-4  cursor-pointer sticky" @click="filterChampions(tag)">{{ tag }}</li>
                    </ul>
                </div>
                <hr class="w-[1px] h-[35px] bg-slate-600 my-auto border-none">

                <!-- Difficulty Filter -->
                <select v-if="difficulty" v-model="selectedDifficulty" id=""
                    :class="isSearchBarFocused ? 'hidden md:flex' : ''"
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
                        :key="champion.id" :champion="champion" @selectChampion="handleSelectChampionInfo" />
                    <p v-else class="text-slate-300 col-span-2 md:col-span-3 lg:col-span-5 text-center ">Aucun champion
                        trouvé</p>
                </div>
            </transition>
        </div>



        <!-- Informations Champions -->
        <transition name="fade">

            <div v-if="isChampionInfoOpen && selectedChampion" @click="isChampionInfoOpen = false"
                class="z-10 fixed overflow-scroll top-[61px] bottom-0 md:top-0 left-0 right-0 bg-[rgba(0,0,0,0.8)] flex items-center justify-center">



                <div class="flex flex-col md:flex-row items-center justify-center gap-4 p-4">
                    <div class="p-4 flex flex-col items-center gap-4 md:w-1/2">
                        <h2 class="text-3xl md:text-5xl font-bold">{{ selectedChampion.name }}</h2>
                        <p class="text-slate-300 text-lg md:text-2xl">{{ selectedChampion.title }}</p>
                        <img :src="server + '/storage/' + selectedChampion.splash_art_path" :alt="selectedChampion.name"
                            class="max-w-[300px] md:max-w-full md:w-1/2">
                        <p class=" text-slate-300 font-bold text-xs md:text-md text-center md:text-left">{{
                            selectedChampion.description }}</p>
                        <div class="flex gap-4">
                            <div v-for="spell in selectedChampion.spells">
                                <img :key="spell.id" :src="server + '/storage/' + spell.image_path" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2 flex flex-col gap-4">
                        <div>
                            <h2 class="md:text-2xl font-bold text-center gradient-border py-1 md:py-3 ">Statistiques de
                                Bases</h2>
                            <div class="flex justify-between p-2 text-xs md:text-md">
                                <p>Points de vie : {{ championStats.hp }}</p>
                                <p>Type de ressource : <span :class="getResourceTypeClass(selectedChampion.partype)">{{
                                    selectedChampion.partype }}</span></p>
                            </div>
                            <div class="flex justify-between p-2 text-xs md:text-md ">
                                <p>MP : {{ championStats.mp }}</p>
                                <p>Chance de coup critique : {{ championStats.crit }}%</p>
                            </div>
                            <div class="flex justify-between p-2 text-xs md:text-md ">
                                <p>Armure : {{ championStats.armor }}</p>
                                <p>Vitesse de déplacement : {{ championStats.movespeed }}</p>
                            </div>
                            <div class="flex justify-between p-2 text-xs md:text-md ">
                                <p>Vitesse d'attaque : {{ championStats.attackspeed }} </p>
                                <p>Dégâts de base : {{ championStats.attackdamage }}</p>
                            </div>
                            <p class="p-2 text-xs md:text-md">Chance de bloquer l'attaque : {{ championStats.spellblock }}%
                            </p>
                        </div>
                        <div>
                            <h2 class="md:text-2xl font-bold text-center gradient-border py-1 md:py-3 ">Régénération / Tour
                            </h2>
                            <!-- Statistiques de Régénération -->
                            <div class="flex justify-between p-2 text-xs md:text-md ">
                                <p>Régen PV/Tour : {{ championStats.hpregen * 5 }}</p>
                                <p>Régen MP/Tour : {{ championStats.mpregen }}</p>
                            </div>
                        </div>
                        <div>
                            <h2 class="md:text-2xl font-bold text-center gradient-border py-1 md:py-3 ">Gains par Niveau
                            </h2>
                            <!-- Gains par Niveau -->
                            <div class="flex justify-between p-2 text-xs md:text-md ">
                                <p>Gain d'HP par niveau : {{ championStats.hpperlevel }}</p>
                                <p>Gain d'MP par niveau : {{ championStats.mpperlevel }}</p>
                            </div>
                            <div class="flex justify-between p-2 text-xs md:text-md ">
                                <p>Gain d'armure par niveau : {{ championStats.armorperlevel }}</p>
                                <p>Gain de régen PV/tour par niveau : {{ championStats.hpregenperlevel * 10 }}</p>
                            </div>
                            <div class="flex justify-between p-2 text-xs md:text-md ">
                                <p>Gain de régen MP/tour par niveau : {{ championStats.mpregenperlevel * 10 }}</p>
                                <p>Gain de chance de blocage par niveau : {{ championStats.spellblockperlevel }}</p>
                            </div>
                            <div class="flex justify-between p-2 text-xs md:text-md ">
                                <p>Gain de Vitesse d'attaque par niveau : {{ (championStats.attackspeedperlevel /
                                    10).toFixed(2) }}</p>
                                <p>Gain de dégats de base par niveau : {{ championStats.attackdamageperlevel }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
        <!--                 -->
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
const isSearchBarFocused = ref(false)
const selectedChampion = ref(null)
const isChampionInfoOpen = ref(false);
const championStats = ref(null)

const handleSelectChampionInfo = async (champion) => {
    selectedChampion.value = champion

    fetch(server + '/api/champions/' + selectedChampion.value.id + '/spells')
        .then(response => response.json())
        .then(data => {
            selectedChampion.value.spells = data
            championStats.value = selectedChampion.value.stats

        })




    isChampionInfoOpen.value = true
    console.log(selectedChampion.value)
}


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
        tags: JSON.parse(champion.tags),
        stats: JSON.parse(champion.stats)
    }));
    displayedChampions.value = champions.value;
    isLoading.value = false;
});

const getResourceTypeClass = (partype) => {
    switch (partype) {
        case 'Mana':
            return 'text-blue-500';
        case 'Énergie':
            return 'text-yellow-500';
        case 'Puits de sang':
            return 'text-red-500';
        case 'Férocité':
            return 'text-red-500';
        case 'Fureur':
            return 'text-red-500';
        case 'Agressivité':
            return 'text-red-500';
        case 'Afflux sanguin':
            return 'text-red-500';
        case 'Fureur':
            return 'text-red-500';
        case 'Courage':
            return 'text-green-500';
        case 'Bouclier':
            return 'text-blue-500';
        case 'Impulsion':
            return 'text-blue-400';
        case 'Vapeur':
            return 'text-blue-300';
        default:
            return 'text-slate-500';
    }
};

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

}</style>