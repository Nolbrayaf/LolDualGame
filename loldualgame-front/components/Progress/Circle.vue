<template>
    <svg class="progress-ring" height="120" width="120">
        <!-- Cercle de fond (grisé) -->
        <circle cx="60" cy="60" :r="radius" stroke="#ccc" stroke-width="4" fill="transparent" />
        <!-- Cercle de progression -->
        <circle class="progress-ring__circle" stroke-width="4" :stroke="props.fillColor" fill="transparent" :r="radius"
            cx="60" cy="60" :stroke-dasharray="circumference" :stroke-dashoffset="dashOffset" />
        <text class=" text-5xl" x="50%" y="50%" text-anchor="middle" dy=".3em" :fill="props.fillColor">{{ props.text
        }}</text>
    </svg>
</template>

<style scoped>
.progress-ring__circle {
    transition: stroke-dashoffset 0.5s ease-out;
    transform: rotate(-90deg);
    transform-origin: 50% 50%;
}
</style>

<script setup>
const props = defineProps({
    progress: {
        type: Number,
        default: 0
    },
    text: {
        type: String
    }
    ,
    fillColor: {
        type: String
    }
})

const radius = ref(58);
const circumference = 2 * Math.PI * radius.value;

const dashOffset = ref(circumference);


watchEffect(() => {
    const progressPercent = props.progress / 100;
    dashOffset.value = circumference * (1 - progressPercent);
});



</script>