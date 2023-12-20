<template>
  <svg 
    width="170" height="60" viewBox="0 0 158 60" class="arrow-svg"
    @mouseover="hover = true"
    @mouseleave="hover = false"

  >
    <defs>
      <!-- Dégradé linéaire pour la bordure -->
      <linearGradient v-if="hover" id="pathStrokeGradient" x1="0.5" y1="0" x2="0.5" y2="1">
        <stop offset="0%" stop-color="#0AC8B9" />
        <stop offset="50%" stop-color="#0A323C" />
        <stop offset="100%" stop-color="#005A82" />
      </linearGradient>
      <linearGradient v-else id="pathStrokeGradient" x1="0.5" y1="0" x2="0.5" y2="1">
        <stop offset="0%" stop-color="#CDFAFA" />
        <stop offset="50%" stop-color="#005A82" />
        <stop offset="100%" stop-color="#0397AB" />
      </linearGradient>
    </defs>
    <!-- Image alignée par le bas -->
    <image x="0" y="10" width="40" height="40" href="~/assets/img/logo.png" />
    <!-- Path aligné par le bas -->
    <path 
      d="M 40,20 L 143,20 L 158,34 L 143,48 L 40,48 C 50,34 40,20 40,20 Z" 
      fill="#3C3C41" 
      :class="{'hover-stroke': hover}" 
      stroke="url(#pathStrokeGradient)" 
      stroke-width="3"
    />
    <!-- Texte -->
    <text x="60%" y="40" fill="white" text-anchor="middle" font-family="BeaufortforLOL-Bold" font-size="18px">
      Jouer
    </text>
  </svg>
</template>

<script>
export default {
  data() {
    return {
      hover: false,
    };
  },
};
</script>

<style scoped>
.hover-stroke {
  stroke: linear-gradient(); /* Remplacer par une couleur plus sombre */
  filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.3)); /* Ombre portée */
}
</style>
