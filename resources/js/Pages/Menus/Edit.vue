<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('menus')">Meniu</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="menu.deleted_at" class="mb-6" @restore="restore">
      This menu has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Denumire" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button v-if="!menu.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Sterge Menu</button>
          <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Actualizeaza</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  metaInfo() {
    return { title: this.form.name }
  },
  layout: Layout,
  components: {
    Icon,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  props: {
    errors: Object,
    menu: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: this.menu.name,
        um: this.menu.um,
        cant: this.menu.cant,
        cant_r: this.menu.cant_r,
        proteine: this.menu.proteine,
        lipide: this.menu.lipide,
        glucide: this.menu.glucide,
      },
    }
  },
  methods: {
    submit() {
      this.$inertia.put(this.route('menus.update', this.menu.id), this.form, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this menu?')) {
        this.$inertia.delete(this.route('menus.destroy', this.menu.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this menu?')) {
        this.$inertia.put(this.route('menus.restore', this.menu.id))
      }
    },
  },
}
</script>
