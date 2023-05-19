<template>
  <Default>
    <div class="flex-col mb-6">
      <div class="flex-col">
        <label
          class="flex w-full p-2 text-sm border rounded-sm text-neutral-900 border-neutral-300 bg-neutral-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-neutral-700 dark:border-neutral-600 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <div v-if="systemFilters.length" class="flex">
            <span
              v-for="filter in systemFilters"
              :id="filter.id"
              :class="{ filter: !filter.error, filterError: filter.error }">
              {{ filter.value }}
              <span @click="removeFilter(filter.id)" aria-label="Remove">
                <svg
                  aria-hidden="true"
                  class="w-3.5 h-3.5"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Remove Filter</span>
              </span>
            </span>
          </div>
          <div class="flex-grow input">
            <input
              type="text"
              name="f"
              id="f"
              class="w-full border-0 bg-neutral-50 dark:bg-neutral-700 focus:outline-none focus:ring-0"
              v-model="filter"
              v-debounce="1000"
              @keyup.enter="addFilter"
              placeholder="Filter" />
          </div>
        </label>
      </div>
      <span class="mb-6 text-sm text-neutral-700 dark:text-neutral-400">
        Filter by keywords like
        <span class="font-semibold text-neutral-900 dark:text-white">name:Sol</span> or
        <span class="font-semibold text-neutral-900 dark:text-white">population: &gt; 1b</span> or
        <span class="font-semibold text-neutral-900 dark:text-white">distance: &lt; 100</span>
      </span>
    </div>
    <Table :is="Table" @onSort="updateSort" :sort="column" :order="order" :th="thead" class="mb-6">
      <tbody v-if="loading">
        <tr>
          <th :colspan="thead.length" rowspan="5" class="table-cell p-4 text-center">
            <div class="flex items-center justify-center w-full h-96">
              <Loader :size="162" />
            </div>
          </th>
        </tr>
      </tbody>
      <tbody v-else>
        <tr
          :id="system.name"
          class="bg-white border-b dark:bg-neutral-800 dark:border-neutral-700"
          v-for="system in systems"
          :key="system.name">
          <td
            class="table-cell px-6 py-4 font-medium text-neutral-900 whitespace-nowrap dark:text-white">
            <Link
              :href="route('systems.show', { name: system.name })"
              class="hover:text-anzac-500"
              >{{ system.name }}</Link
            >

            <!--<div class="ml-4" v-if="system.conflicts.length > 0">
              <ul class="flex">
                <li v-for="conflict in system.conflicts" :key="conflict.id">
                  <span v-if="conflict.wartype === 'civilwar' || conflict.wartype === 'war'" alt="War" class="mdi mdi-sword-cross" />
                  <span v-if="conflict.wartype === 'election'" class="mdi mdi-ballot" />
                </li>
              </ul>
            </div>-->
          </td>
          <td class="px-6 py-4">{{ toLocaleString(system.population) || 0 }}</td>
          <td class="px-6 py-4">{{ toRangeString(system.distance) }} Ly</td>
          <td class="px-6 py-4">{{ system.economy || 'None' }}</td>
          <td class="px-6 py-4">{{ system.second_economy || 'None' }}</td>
          <td class="px-6 py-4">{{ system.security || 'None' }}</td>
          <td class="px-6 py-4">{{ DateFormat.fromNow(system.updated_at) }}</td>
        </tr>
      </tbody>
    </Table>
    <Pagination v-if="systems.length > 0" :meta="meta" :lastPage="lastPage" />
  </Default>
</template>

<script setup lang="ts">
import { ref, Ref, onMounted, watch } from 'vue'
import { Link } from '@inertiajs/vue3'
import { v4 } from 'uuid'
import { storeToRefs } from 'pinia'

import Pagination from '@/Components/Pagination/index.vue'
import Default from '@/Layouts/Default.vue'
import Table from '@/Components/Table/index.vue'
import Loader from '@/Components/Loader/index.vue'

import System from '@/Apis/System'

import { useFilters, useToasts } from '@/store'

import { System as ISystem } from '@/Interfaces'

import { DateFormat, toLocaleString, toRangeString } from '@/Utils'

interface Th {
  name: string
  key: string
}

interface Sort {
  column: string
}

interface Meta {
  count: number
  total: number
  current_page: number
  last_page: number
  per_page: number
}

interface Filter {
  id: string
  value: string
}

const thead: Th[] = [
  { name: 'System', key: 'name' },
  { name: 'Population', key: 'population' },
  { name: 'Distance Sol', key: 'distance' },
  { name: 'Economy', key: 'economy' },
  { name: 'Secondary Economy', key: 'second_economy' },
  { name: 'Security', key: 'security' },
  { name: 'Updated At', key: 'updated_at' },
]

const column: Ref<string> = ref('distance')
const order: Ref<string> = ref('asc')
const filter: Ref<string> = ref('')
const loading: Ref<boolean> = ref(true)
//const filters: Ref<Filter[]> = ref([])
const systems: Ref<ISystem[]> = ref([])
const lastPage: Ref<number> = ref(1)
const source: Ref<string> = ref('all')
const meta: Ref<Meta> = ref({ count: 0, total: 0, current_page: 1, last_page: 1, per_page: 1 })

const store = useFilters()
const filters = storeToRefs(store)
const toast = useToasts()
const systemFilters = filters.systems

onMounted(async () => {
  if (systemFilters.value.length > 0) {
    source.value = 'filter'
  } else {
    source.value = 'all'
  }
  console.log('fetch data')
  fetchData()
})

const removeFilter = (id: string) => {
  store.removeFilter('systems', id)
  if (systemFilters.value.length === 0) {
    source.value = 'all'
    fetchData()
    return
  }

  source.value = 'filter'
  fetchData()
}

const addFilter = () => {
  if (filter.value === '') {
    return
  }
  if (store.getByValue('systems', filter.value)) {
    //filter.value = ''
    toast.addToast({
      title: 'Filter already exists',
      message: 'Please enter a new filter',
      type: 'error',
    })
    return
  }
  store.addFilter('systems', { id: v4(), value: filter.value })
  filter.value = ''
  source.value = 'filter'
  fetchData()
}

const props = defineProps({ page: { type: Number, default: 1 } })

const updateSort = (sort: Sort) => {
  if (sort.column === column.value) {
    order.value = order.value === 'asc' ? 'desc' : 'asc'
    systems.value = []
    fetchData()
    return
  }

  column.value = sort.column
  order.value = 'asc'
  systems.value = []
  fetchData()
}

const all = async () => {
  const response = await System.index(props.page, column.value, order.value)
  systems.value = response.data
  lastPage.value = response.meta.last_page
  meta.value = response.meta
  loading.value = false
}

const filterData = async () => {
  const searchFilters = systemFilters.value.map((filter: Filter) => filter.value)
  const response = await System.filter(props.page, column.value, order.value, searchFilters)

  if (response.hasOwnProperty('data') === false) {
    findFilterWithError(response.filterErrors)
    loading.value = false
    return
  }
  systems.value = response.data
  lastPage.value = response.meta.last_page
  meta.value = response.meta
  loading.value = false
}

const findFilterWithError = (errors: any) => {
  const filterWithErrors = errors.map((error: any) =>
    systemFilters.value.find((filter: Filter) => filter.value.includes(error))
  )
  filterWithErrors.forEach((filter: Filter) => {
    store.updateFilter('systems', filter)
  })
}

const fetchData = () => {
  loading.value = true
  switch (source.value) {
    case 'filter':
      filterData()
      break
    case 'all':
      all()
      break
    default:
      all()
  }
}
</script>

<style lang="scss" scoped>
.filter {
  @apply inline-flex items-center px-2 py-1 mr-2 text-sm font-medium rounded text-neutral-800 bg-neutral-100 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:text-neutral-400;

  & > span {
    @apply inline-flex items-center p-0.5 ml-2 text-sm text-neutral-400 bg-transparent rounded-sm hover:bg-neutral-200 hover:text-neutral-900 dark:hover:bg-neutral-600 dark:hover:text-neutral-300;
  }
}

.filterError {
  @apply inline-flex items-center px-2 py-1 mr-2 text-sm font-medium text-red-800 bg-red-100 rounded dark:bg-red-900 dark:text-red-300;

  & > span {
    @apply inline-flex items-center p-0.5 ml-2 text-sm text-red-400 bg-transparent rounded-sm hover:bg-red-200 hover:text-red-900 dark:hover:bg-red-800 dark:hover:text-red-300;
  }
}
</style>
