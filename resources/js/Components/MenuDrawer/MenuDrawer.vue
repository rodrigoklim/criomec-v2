<script lang="ts" setup>
import ChildDrawer from "@/Components/MenuDrawer/components/ChildDrawer.vue";
import { MenuItem, menu } from "@/Components/MenuDrawer/menu";
import { Link } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import map from "lodash/map";

const menuItems = ref<MenuItem[]>(menu);
const itemSelected = ref<MenuItem>({
  label: "",
  icon: "",
  path: "",
  children: [],
});
const childrenDrawerOpen = ref(false);

const selectMenu = (item: MenuItem) => {
  itemSelected.value = item;
  if (itemSelected.value?.children && itemSelected.value?.children.length > 0) {
    childrenDrawerOpen.value = true;
    window.location.href = itemSelected.value.children[0].path;
  }

  window.location.href = itemSelected.value.path;
};

const showTooltip = ref([] as boolean[]);

const closeChildrenDrawer = () => {
  childrenDrawerOpen.value = false;
};

onMounted(() => {
  const route = window.location.pathname;
  map(menuItems.value, (item: MenuItem) => {
    if (item.children && item.children.length > 0) {
      map(item.children, (child: MenuItem) => {
        if (child.path === route) {
          itemSelected.value = item;
          childrenDrawerOpen.value = true;
        }
      });
    }
  });
});
</script>

<template>
  <div class="flex h-screen">
    <div class="w-16 bg-primary p-2 flex justify-center">
      <ul>
        <li class="mb-8 mt-2">
          <Link :href="route('dashboard')">
            <div class="bg-white rounded-xl p-1">
              <img src="/images/miniatura_novo.png" alt="dose-diary" style="height: 40px; width: 40px" />
            </div>
          </Link>
        </li>
        <li v-for="(item, index) in menuItems" :key="item.label" class="relative my-2">
          <button
            class="flex items-center p-2 rounded-md text-gray-700 hover:bg-gray-300 w-full"
            :class="itemSelected?.label === item.label && childrenDrawerOpen ? 'bg-secondary rounded-lg' : ''"
            @click="selectMenu(item)"
            @mouseenter="showTooltip[index] = true"
            @mouseleave="showTooltip[index] = false"
          >
            <span class="material-symbols-outlined text-white text-3xl">
              {{ item.icon }}
            </span>
          </button>
          <transition name="fade" mode="out-in">
            <span
              v-if="showTooltip[index] && !childrenDrawerOpen"
              class="absolute whitespace-nowrap bg-gray-600 text-white text-lg py-2 px-4 left-16 rounded-md ml-2 z-10"
              style="top: 50%; transform: translateY(-50%)"
            >
              {{ item.label }}
            </span>
          </transition>
        </li>
      </ul>
    </div>
    <div
      class="bg-white flex-1 p-5 transition-width duration-300 relative"
      :class="childrenDrawerOpen ? 'w-64' : 'w-0 opacity-0'"
    >
      <button
        class="p-2 flex items-center justify-center rounded-full bg-primary text-white absolute top-26 -right-5"
        @click="closeChildrenDrawer"
      >
        <span class="material-symbols-outlined">chevron_left</span>
      </button>
      <ChildDrawer v-if="itemSelected" :title="itemSelected?.label" :children="itemSelected?.children" />
    </div>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
