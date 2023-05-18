<template>
  <Full :title="`System - ${name} - Map`" />
</template>
<script lang="ts" setup>
import Full from '@/Layouts/Full.vue'
import { onMounted, ref, Ref } from 'vue'

import System from '@/Apis/System'

interface Props {
  name: string
}

const props: Props = defineProps({ name: { type: String, required: true } })

const system: Ref<any> = ref(null)

onMounted(async () => {
  const response = await System.get(props.name)
  console.log(response.data)
  system.value = response.data
})
</script>
