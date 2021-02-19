<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('ingredients')">Ingrediente</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="ingredient.deleted_at" class="mb-6" @restore="restore">
      This ingredient has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Nume" />
          <text-input v-model="form.um" :error="errors.um" class="pr-6 pb-8 w-full lg:w-1/2" label="Unitate Masura" />
          <text-input v-model="form.cant" :error="errors.cant" class="pr-6 pb-8 w-full lg:w-1/2" label="Cantitate" />
          <text-input v-model="form.cant_r" :error="errors.cant_r" class="pr-6 pb-8 w-full lg:w-1/2" label="Cantitate Ramasa" />
          <text-input v-model="form.proteine" :error="errors.proteine" class="pr-6 pb-8 w-full lg:w-1/2" label="Proteine" />
          <text-input v-model="form.lipide" :error="errors.lipide" class="pr-6 pb-8 w-full lg:w-1/2" label="Lipide" />
          <text-input v-model="form.glucide" :error="errors.glucide" class="pr-6 pb-8 w-full lg:w-1/2" label="Glucide" />
          <text-input v-model="calorii" readonly="true" class="pr-6 pb-8 w-full lg:w-1/2" label="Calorii" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button v-if="!ingredient.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Sterge Ingredient</button>
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
    ingredient: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: this.ingredient.name,
        um: this.ingredient.um,
        cant: this.ingredient.cant,
        cant_r: this.ingredient.cant_r,
        proteine: this.ingredient.proteine,
        lipide: this.ingredient.lipide,
        glucide: this.ingredient.glucide,
        calorii: this.ingredient.calorii,
      },
    }
  },
  computed:{
    calorii:function (){
      return parseInt(this.form.glucide)*4 + parseInt(this.form.lipide)*9 + parseInt(this.form.proteine)*4
    }
  },
  methods: {
    submit() {
      this.form.calorii = this.calorii
      this.$inertia.put(this.route('ingredients.update', this.ingredient.id), this.form, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this ingredient?')) {
        this.$inertia.delete(this.route('ingredients.destroy', this.ingredient.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this ingredient?')) {
        this.$inertia.put(this.route('ingredients.restore', this.ingredient.id))
      }
    },
  },
}
</script>
