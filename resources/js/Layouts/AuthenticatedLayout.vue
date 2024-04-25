<script setup lang="ts">
import MenuDrawer from "@/Components/MenuDrawer/MenuDrawer.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <div class="max-h-screen flex flex-row bg-gray-100">
    <menu-drawer class="absolute top-0 z-10" />
    <Dropdown align="right" class="fixed mt-2 -right-[93vw]">
      <template #trigger>
        <span class="inline-flex rounded-md">
          <button
            type="button"
            class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 hover:bg-green-50 hover:text-white focus:outline-none transition ease-in-out duration-150"
          >
            <span v-if="$page.props.auth.user.name">
              {{ $page.props.auth.user.name }}
            </span>
            <span v-else class="material-symbols-outlined text-primary"> account_circle </span>
            <svg
              class="ms-2 -me-0.5 h-4 w-4 fill-primary"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
              />
            </svg>
          </button>
        </span>
      </template>

      <template #content>
        <DropdownLink :href="route('profile.edit')">
          <Link class="flex flex-row items-center" href="/my-account">
            <span class="material-symbols-outlined">person</span> <span class="ml-4">Minha Conta</span>
          </Link>
        </DropdownLink>
        <DropdownLink :href="route('logout')" method="post" as="button">
          <div class="flex flex-row">
            <span class="material-symbols-outlined">logout</span> <span class="ml-4">Logout</span>
          </div>
        </DropdownLink>
      </template>
    </Dropdown>
    <div class="flex flex-col w-full max-h-screen overflow-y-auto">
      <!-- Page Heading -->
      <header v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>
    </div>
  </div>
</template>
