<script setup lang="ts"></script>

<template>
  <div class="flex flex-row items-center justify-center min-h-screen bg-white">
    <div class="flex w-full items-center justify-center mx-12">
      <img alt="Criomec logo" src="images/logo_novo.svg" />
    </div>
    <div class="flex bg-primary w-full min-h-screen items-center justify-center">
      <slot />
    </div>
  </div>
</template>
