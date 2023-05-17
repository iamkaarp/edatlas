<template>
  <Default :title="`System - ${name}`">
    <div>
      <span class="text-3xl font-bold uppercase text-anzac-500">{{ name }}</span>
      <div
        class="text-sm font-medium text-center border-b text-neutral-500 border-neutral-200 dark:text-neutral-400 dark:border-neutral-700">
        <ul class="flex flex-wrap -mb-px">
          <li class="mr-2">
            <a href="#" class="link active" aria-current="page">Overview</a>
          </li>
          <li class="mr-2">
            <a href="#" class="link">Stations</a>
          </li>
          <li class="mr-2">
            <a href="#" class="link">Bodies</a>
          </li>
          <li class="mr-2">
            <a href="#" class="link">Map</a>
          </li>
        </ul>
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
