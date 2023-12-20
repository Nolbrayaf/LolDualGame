<template >
    <main class="flex flex-col items-center">
        <div class="p-8">
            <h1 class="text-5xl font-bold text-color-primary">LEAGUE OF LEGEND</h1>
            <h2 class="text-3xl font-bold text-color-primary italic text-center">The Dual Game</h2>
        </div>
        <p>Choisissez votre champion</p>
        <div class="flex flex-col gap-4">

            <div>
                <input type="text">
            </div>

            <div v-if="champions" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <CardsChampion v-for="champion in champions" :champion="champion" />
            </div>

        </div>

    </main>
</template>

<script setup>
import { server } from '~/services/api.js'
const champions = ref()
const isLoading = ref()



onMounted(() => {
    isLoading.value = true
    fetch(server + '/api/champions')
        .then(data => data.json())
        .then(data => {
            champions.value = data
            isLoading.value = false
        })

})







</script>


<style></style>