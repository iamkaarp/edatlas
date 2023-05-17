import { defineStore } from 'pinia'

export const useSettings = defineStore('settings', {
  state: () => {
    return {
      _dark: true,
    }
  },
  getters: {
    dark: (state) => state._dark,
  },
  actions: {
    toggleDark(dark: boolean) {
      return (this._dark = dark)
    },
  },
  persist: {
    storage: localStorage,
  },
})
