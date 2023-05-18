<template>
  <Default :title="`System - ${name}`">
    <div>
      <span class="text-3xl font-bold uppercase text-anzac-500">System</span>
      <div
        class="text-sm font-medium text-center border-b text-neutral-500 border-neutral-200 dark:text-neutral-400 dark:border-neutral-700">
        <ul class="flex flex-wrap -mb-px">
          <li class="mr-2">
            <a :href="route('systems.show', { name })" class="link active" aria-current="page"
              >Overview</a
            >
          </li>
          <li class="mr-2">
            <a :href="route('systems.show.stations', { name })" class="link">Stations</a>
          </li>
          <li class="mr-2">
            <a :href="route('systems.show.bodies', { name })" class="link">Bodies</a>
          </li>
          <li class="mr-2">
            <a :href="route('systems.show.map', { name })" class="link">Map</a>
          </li>
        </ul>
      </div>
      <div
        class="flex w-full bg-white border rounded-sm shadow h-96 border-neutral-200 dark:bg-neutral-800 dark:border-neutral-700">
        <div
          class="w-32 h-full bg-right bg-cover"
          style="background-image: url('/storage/Sun_sol.webp')"></div>
        <div class="flex flex-col w-full p-4 leading-normal">
          <div class="flex items-center justify-between">
            <h5 class="mb-2 text-3xl font-bold tracking-tight text-anzac-500 dark:text-anzac-500">
              {{ name }}
            </h5>
            <div class="flex items-center">
              <a
                :href="route('systems.show.edit', { name })"
                type="button"
                class="relative flex items-center justify-center h-8 p-2 text-sm font-medium text-center text-white uppercase rounded-sm cursor-pointer bg-ship-gray-700 hover:bg-ship-gray-800 focus:ring-4 focus:outline-none focus:ring-ship-gray-300 dark:bg-ship-gray-600 dark:hover:bg-ship-gray-700 dark:focus:ring-ship-gray-800">
                <span class="mdi mdi-pencil"></span>
                Edit
                <span class="sr-only">Edit</span>
              </a>
              <span
                type="button"
                class="relative flex items-center justify-center w-8 h-8 p-2 ml-2 text-sm font-medium text-center text-white rounded-sm cursor-pointer bg-anzac-700 hover:bg-anzac-800 focus:ring-4 focus:outline-none focus:ring-anzac-300 dark:bg-anzac-600 dark:hover:bg-anzac-700 dark:focus:ring-anzac-800">
                <span class="mdi mdi-star"></span>
                <span class="sr-only">Notifications</span>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Default>
</template>
<script setup lang="ts">
import { onMounted } from 'vue'
import Default from '@/Layouts/Default.vue'

import System from '@/Apis/System'

interface Props {
  name: string
}

const props: Props = defineProps({ name: { type: String, required: true } })

onMounted(async () => {
  const response = await System.get(props.name)
  console.log(response)
})
</script>
<style lang="scss" scoped>
.link {
  @apply inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-neutral-600 hover:border-neutral-300 dark:hover:text-neutral-300;

  &.active {
    @apply text-anzac-600 border-anzac-600 dark:text-anzac-500 dark:border-anzac-500;
  }
}
</style>
