import { defineStore } from 'pinia'

interface Favorite {
  id: string
  name: string
}

export const useFavourites = defineStore('favourites', {
  state: () => {
    return {
      systems: [] as Favorite[],
      stations: [] as Favorite[],
    } as Record<string, Favorite[]>
  },
  getters: {
    getSystems(state): Favorite[] {
      return state.systems
    },
  },
  actions: {
    addFilter(key: string, filter: Favorite): void {
      this[key].push(filter)
    },
    removeFilter(key: string, id: string): void {
      const index = this[key].findIndex((filter: Favorite) => filter.id === id)
      this[key].splice(index, 1)
    },
  },
  persist: {
    storage: localStorage,
  },
})
