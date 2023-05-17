<template>
  <nav
    class="fixed top-0 left-0 z-20 w-full bg-white border-b border-neutral-200 dark:bg-neutral-800 dark:border-neutral-600">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl p-4 mx-auto">
      <Link :href="route('home')" class="flex items-center">
        <img :src="Icon" class="h-8 mr-3" alt="Flowbite Logo" />
        <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"
          >ED Atlas</span
        >
      </Link>
      <button
        data-collapse-toggle="navbar-multi-level"
        type="button"
        class="inline-flex items-center p-2 ml-3 text-sm rounded-lg text-neutral-500 md:hidden hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-neutral-200 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:ring-neutral-600"
        aria-controls="navbar-multi-level"
        aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg
          class="w-6 h-6"
          aria-hidden="true"
          fill="currentColor"
          viewBox="0 0 20 20"
          xmlns="http://www.w3.org/2000/svg">
          <path
            fill-rule="evenodd"
            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
            clip-rule="evenodd"></path>
        </svg>
      </button>
      <div class="hidden w-full md:block md:w-auto" id="navbar-multi-level">
        <ul
          class="flex flex-col p-4 mt-4 font-medium border rounded-lg md:p-0 border-neutral-100 bg-neutral-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-neutral-800 md:dark:bg-neutral-800 dark:border-neutral-700">
          <li v-for="item in menuItems" :key="item.title">
            <div v-if="!item.hasOwnProperty('children')">
              <Link
                :href="route(item.link)"
                class="block py-2 pl-3 pr-4 rounded text-neutral-900 hover:bg-neutral-100 md:hover:bg-transparent md:border-0 md:hover:text-anzac-700 md:p-0 dark:text-white md:dark:hover:text-anzac-500 dark:hover:bg-neutral-700 dark:hover:text-white md:dark:hover:bg-transparent"
                aria-current="page">
                {{ item.title }}
              </Link>
            </div>
            <div v-else>
              <button
                id="dropdownNavbarLink"
                data-dropdown-toggle="dropdownNavbar"
                class="flex items-center justify-between w-full py-2 pl-3 pr-4 border-b text-neutral-700 border-neutral-100 hover:bg-neutral-50 md:hover:bg-transparent md:border-0 md:hover:text-anzac-700 md:p-0 md:w-auto dark:text-white md:dark:hover:text-anzac-500 dark:focus:text-white dark:border-neutral-700 dark:hover:bg-neutral-700 md:dark:hover:bg-transparent">
                {{ item.title }}
                <svg
                  class="w-5 h-5 ml-1"
                  aria-hidden="true"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
                </svg>
              </button>
              <!-- Dropdown menu -->
              <div
                id="dropdownNavbar"
                class="z-10 hidden font-normal bg-white divide-y rounded-lg shadow divide-neutral-100 w-44 dark:bg-neutral-700 dark:divide-neutral-600">
                <ul
                  class="py-2 text-sm text-neutral-700 dark:text-neutral-400"
                  aria-labelledby="dropdownLargeButton">
                  <li v-for="child in item.children!" :key="child.title">
                    <Link
                      :href="route(child.link)"
                      class="block px-4 py-2 hover:bg-neutral-100 dark:hover:bg-neutral-600 dark:hover:text-anzac-500">
                      {{ child.title }}
                    </Link>
                  </li>
                </ul>
              </div>
            </div>
          </li>
          <li>
            <label class="relative inline-flex items-center cursor-pointer">
              <input
                @change="toggleDark"
                type="checkbox"
                value=""
                class="sr-only peer"
                :checked="store.dark" />
              <div
                class="w-11 h-6 bg-neutral-200 rounded-full peer peer-focus:ring-0 peer-focus:ring-anzac-300 dark:peer-focus:ring-anzac-800 dark:bg-neutral-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-neutral-600 peer-checked:bg-anzac-600"></div>
              <span class="mt-1 ml-3 text-sm font-medium text-neutral-900 dark:text-neutral-300"
                >Dark Mode</span
              >
            </label>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script lang="ts" setup>
import { onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import { initDropdowns } from 'flowbite'
import Icon from '../../../images/Icon.svg'
import { useSettings } from '@/store/settings'

const store = useSettings()

interface MenuItem {
  title: string
  link: string
  children?: MenuItem[]
}

const menuItems: MenuItem[] = [
  {
    title: 'Systems',
    link: 'systems.index',
  },
  {
    title: 'Stations',
    link: 'stations',
  },
  {
    title: 'Market',
    link: 'market',
    children: [
      {
        link: 'market.commodities',
        title: 'Commodities',
      },
      {
        link: 'market.rare-commodities',
        title: 'Rare Commodities',
      },
      {
        link: 'market.traderoutes',
        title: 'Trade Routes',
      },
    ],
  },
  {
    title: 'Shipyard',
    link: 'shipyard',
  },
  {
    title: 'Outfitting',
    link: 'outfitting',
  },
  {
    title: 'Galaxy Map',
    link: 'galaxy',
  },
]

onMounted(() => {
  initDropdowns()
})

const toggleDark = () => {
  const isDark = store.dark
  store.toggleDark(!isDark)
}
</script>
