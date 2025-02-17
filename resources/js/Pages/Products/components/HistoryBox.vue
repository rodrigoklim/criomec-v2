<script setup lang="ts">
import { ProductLog } from "@/types/product";
import { onMounted, ref } from "vue";

const props = defineProps<{
  logs?: ProductLog[];
}>();

const isNew = ref(location.pathname.includes("create"));
onMounted(() => {
  console.log(isNew.value);
});
</script>

<template>
  <div class="flex flex-col border-2 border-primary p-6 rounded-2xl mr-4 bg-white max-h-[500px]">
    <div class="font-semibold text-lg">Histórico</div>
    <div class="flex flex-col bg-gray-100 p-4 rounded-2xl mt-4 max-h-[400px] overflow-y-auto scroll-bar">
      <div v-if="isNew" class="flex flex-col my-2 text-sm">
        <span class="font-semibold">{{ new Date().toLocaleDateString() }}</span> <span>Cadastrando produto...</span>
      </div>
      <div v-else>
        <div v-for="log in props.logs" :key="log.id" class="flex flex-col my-2 text-sm max-h-[400px]">
          <span class="font-semibold">{{ `${log.created_at} - ${log.user.name}` }}</span> <span>{{ log.action }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.scroll-bar {
  height: 37rem;
  overflow: auto;
}

.scroll-bar::-webkit-scrollbar {
  width: 10px;
  opacity: 0;
}

.scroll-bar::-webkit-scrollbar-thumb {
  @apply bg-primary/20 border-0 rounded-lg;
}

.scroll-bar::-webkit-scrollbar-thumb:hover {
  @apply bg-primary/70  border-0 rounded-lg;
}
</style>
