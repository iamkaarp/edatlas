import './bootstrap'
import '../css/app.css'

import { createApp, h, DefineComponent } from 'vue'
import { createPinia } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'
import resolveConfig from 'tailwindcss/resolveConfig'
import tailwindConfig from '../../tailwind.config.js'
import { useSettings } from './store/settings'
const fullConfig = resolveConfig(tailwindConfig)

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'ED Atlas'

const pinia = createPinia()
pinia.use(piniaPluginPersistedstate)

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob<DefineComponent>('./Pages/**/*.vue')
    ),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .use(pinia)
      .mount(el)

    const settings = useSettings()
    if (localStorage.getItem('settings') === null) {
      settings.toggleDark(true)
    }
  },
  progress: {
    color: fullConfig.theme?.colors?.anzac[500],
  },
})
