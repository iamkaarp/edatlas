<template>
  <Full :title="title">
    <div class="w-1/2 mx-auto">
      <div class="w-full mt-20">
        <slot />
      </div>
    </div>
  </Full>
</template>
<script lang="ts" setup>
import Full from '@/Layouts/Full.vue'

const props = defineProps({
  title: {
    type: String,
    default: 'Systems',
  },
})
</script>
