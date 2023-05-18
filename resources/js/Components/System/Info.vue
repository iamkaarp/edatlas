<template>
  <div class="flex w-full mt-1">
    <div class="w-1/4">
      <slot name="key" />
    </div>
    <div class="w-1/2 text-neutral-300">
      <slot name="value" />
    </div>
  </div>
</template>
