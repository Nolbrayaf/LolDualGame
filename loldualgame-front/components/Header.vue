<script setup>

</script>


<template>
    <header class="flex justify-between items-center px-8 border-b border-slate-600">

        <NuxtLink to="/">
            <ButtonsPlay />
        </NuxtLink>


        <div class="flex gap-4">
            <NuxtLink to="/user/login" class=" py-2 px-4 text-xl font-bold border-bottom-hover">Se Connecter</NuxtLink>
            <NuxtLink to="/user/login" class=" py-2 px-4 text-xl font-bold border-bottom-hover">S'inscrire</NuxtLink>
        </div>


    </header>
</template>


<style scoped></style>

