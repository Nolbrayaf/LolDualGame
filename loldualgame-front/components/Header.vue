<script setup>


const route = useRoute();
console.log(route.path)
const isAboutOpen = ref(false)
const isBurgerMenuOpen = ref(false)

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

        <div :class="isBurgerMenuOpen ? '' : 'translate-x-full'"
            class=" z-10 transition duration-300 easing-in-out md:transform-none p-4 pl-0 fixed bg-[#010A13] bottom-0 top-0 right-0 flex-col md:p-0 md:bg-transparent md:sticky flex md:flex-row gap-4"
            @click="isBurgerMenuOpen = false">
            <IconsCross class="md:hidden cursor-pointer self-end" @click="isBurgerMenuOpen = false" />
            <p @click="isAboutOpen = true"
                class="mt-auto order-last md:order-none px-4 md:block me-auto text-xl font-bold text-slate-400 cursor-pointer border-bottom-hover py-1">
                <span class="uppercase">à</span> propos
            </p>

            <ul class="flex-col flex md:flex-row gap-4">
                <li class=" py-1 px-4 text-xl font-bold border-bottom-hover">
                    <NuxtLink to="/user/login">Se Connecter</NuxtLink>
                </li>
                <li class=" py-1 px-4 text-xl font-bold border-bottom-hover">
                    <NuxtLink to="/user/login">S'inscrire</NuxtLink>
                </li>
            </ul>
        </div>



        <IconsBurgerMenu class="md:hidden cursor-pointer width-fit" @click="isBurgerMenuOpen = true" />




        <!-- About Container -->
        <transition name="fade">

            <div v-if="isAboutOpen" class="fixed bottom-0 top-0 left-0 right-0 bg-[rgba(0,0,0,0.5)]">



                <div
                    class=" flex flex-col gap-4 absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] bg-[#1E282D] border-2 border-[#785A28] p-5 md:p-20 w-[90%] md:max-w-2xl md:[&>*:first-child]:text-3xl md:text-md [&>*:first-child]:text-xl text-sm ">
                    <h2 class=" font-bold text-center">A Propos de LEAGUE OF LEGEND The Dual Game</h2>
                    <p>Bienvenue dans LEAGUE OF LEGEND The Dual Game, un jeu passionnant en cours de développement
                        inspiré
                        par
                        l'univers de "League of Legends". Conçu pour les amateurs de défis stratégiques, notre jeu vous
                        propose
                        des
                        duels intenses en 1 contre 1, où vous affronterez un adversaire contrôlé par l'intelligence
                        artificielle.
                    </p>
                    <p>Chaque victoire vous rapproche un peu plus du sommet, vous permettant de gagner en rang et de
                        déverrouiller
                        une multitude de champions emblématiques. Votre habileté et votre stratégie seront les clés pour
                        grimper
                        les
                        échelons et prouver que vous êtes un maître du duel.</p>

                    <p>LEAGUE OF LEGEND The Dual Game est un fan-game créé par des passionnés pour la communauté. Nous
                        tenons à
                        préciser que ce jeu est un projet indépendant et n'a aucun lien officiel avec Riot Games. Nous
                        avons
                        construit cet univers par admiration pour le monde riche et captivant de "League of Legends" et
                        espérons
                        offrir une expérience unique et amusante à tous les joueurs.</p>

                    <p>Rejoignez-nous dans cette aventure épique et forgez votre chemin vers la gloire !</p>
                    <div class="md:pt-20 m-auto">
                        <button class="border-bottom text-2xl p-2" @click="isAboutOpen = false">Compris !</button>
                    </div>
                </div>
            </div>
        </transition>
        <!--                 -->


        <!-- Grey screen for BurgerMenu-->
        <div v-if="isBurgerMenuOpen" class="fixed md:hidden top-0 left-0 right-0 bottom-0 bg-black opacity-20 z-1"
            @click="isBurgerMenuOpen = false">

        </div>
        <!--                 -->

    </header>
</template>

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
</style>



