<script setup>


const route = useRoute();
console.log(route.path)
const isAboutOpen = ref(false)

onMounted(() => {

    if (route.path === "/") {
        setTimeout(() => {
            isAboutOpen.value = true
        }
            , 2000)
    }
})

</script>


<template>
    <header class="flex gap-4 justify-between items-center px-8 border-b border-slate-600">
        <div class="">
            <NuxtLink to="/">
                <ButtonsPlay />
            </NuxtLink>

        </div>
        <div class="bg-[#010A13] md:bg-transparent absolute bottom-0 top-0 right-0 flex-col flex md:flex-row gap-4">
            <p @click="isAboutOpen = true"
                class=" md:block me-auto text-md font-bold cursor-pointer border-bottom-hover py-1">A propos</p>

            <div class="flex-col flex md:flex-row gap-4">
                <NuxtLink to="/user/login" class=" py-1 px-4 text-xl font-bold border-bottom-hover">Se Connecter</NuxtLink>
                <NuxtLink to="/user/login" class=" py-1 px-4 text-xl font-bold border-bottom-hover">S'inscrire</NuxtLink>
            </div>
        </div>



        <IconsBurgerMenu class="md:hidden cursor-pointer" />




        <!-- About Container -->
        <div v-if="isAboutOpen" class="absolute bottom-0 top-0 left-0 right-0 bg-[rgba(0,0,0,0.5)]">
            <div
                class=" flex flex-col gap-4 absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] bg-[#1E282D] border-2 border-[#785A28] p-5 md:p-20 w-[90%] md:max-w-2xl md:[&>*:first-child]:text-3xl md:text-md [&>*:first-child]:text-xl text-sm ">
                <h2 class=" font-bold text-center">A Propos de LEAGUE OF LEGEND The Dual Game</h2>
                <p>Bienvenue dans LEAGUE OF LEGEND The Dual Game, un jeu passionnant en cours de développement inspiré par
                    l'univers de "League of Legends". Conçu pour les amateurs de défis stratégiques, notre jeu vous propose
                    des
                    duels intenses en 1 contre 1, où vous affronterez un adversaire contrôlé par l'intelligence
                    artificielle.
                </p>
                <p>Chaque victoire vous rapproche un peu plus du sommet, vous permettant de gagner en rang et de
                    déverrouiller
                    une multitude de champions emblématiques. Votre habileté et votre stratégie seront les clés pour grimper
                    les
                    échelons et prouver que vous êtes un maître du duel.</p>

                <p>LEAGUE OF LEGEND The Dual Game est un fan-game créé par des passionnés pour la communauté. Nous tenons à
                    préciser que ce jeu est un projet indépendant et n'a aucun lien officiel avec Riot Games. Nous avons
                    construit cet univers par admiration pour le monde riche et captivant de "League of Legends" et espérons
                    offrir une expérience unique et amusante à tous les joueurs.</p>

                <p>Rejoignez-nous dans cette aventure épique et forgez votre chemin vers la gloire !</p>
                <div class="pt-20 m-auto">
                    <button class="border-bottom text-2xl p-2" @click="isAboutOpen = false">Compris !</button>
                </div>
            </div>

        </div>
        <!--                 -->
    </header>
</template>


<style scoped></style>

