<template>
  <div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('dashboard')">
        <icon name="dashboard" class="w-4 h-4 mr-2" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Pupitru</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('menus')">
        <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('menus') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('menus') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Meniuri</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('recipes')">
        <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('recipes') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('recipes') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Retete</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('ingredients')">
        <icon name="printer" class="w-4 h-4 mr-2" :class="isUrl('ingredients') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('ingredients') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Ingrediente</div>
      </inertia-link>
    </div>
    <div class="mb-4">
      <inertia-link class="flex items-center group py-3" :href="route('import')">
        <icon name="printer" class="w-4 h-4 mr-2" :class="isUrl('import') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('ingredients') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Import</div>
      </inertia-link>
    </div>
<!--    <div class="mb-4">-->
<!--      <inertia-link class="flex items-center group py-3" :href="route('organizations')">-->
<!--          <icon name="office" class="w-4 h-4 mr-2" :class="isUrl('organizations') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />-->
<!--          <div :class="isUrl('organizations') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Organizations</div>-->
<!--      </inertia-link>-->
<!--    </div>-->
<!--    <div class="mb-4">-->
<!--      <inertia-link class="flex items-center group py-3" :href="route('contacts')">-->
<!--          <icon name="users" class="w-4 h-4 mr-2" :class="isUrl('contacts') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />-->
<!--          <div :class="isUrl('contacts') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Contacts</div>-->
<!--      </inertia-link>-->
<!--    </div>-->
<!--    <div class="mb-4">-->
<!--      <inertia-link class="flex items-center group py-3" :href="route('reports')">-->
<!--          <icon name="printer" class="w-4 h-4 mr-2" :class="isUrl('reports') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />-->
<!--          <div :class="isUrl('reports') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Reports</div>-->
<!--      </inertia-link>-->
<!--    </div>-->
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
  },
  props: {
    url: String,
  },
  methods: {
    isUrl(...urls) {
      if (urls[0] === '') {
        return this.url === ''
      }

      return urls.filter(url => this.url.startsWith(url)).length
    },
  },
}
</script>
