<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('ingredients')">Ingrediente</inertia-link>
      <span class="text-indigo-400 font-medium">/</span> Creeaza
    </h1>
    <div class="bg-white rounded shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="submit">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
            <text-input v-model="form.name" :error="errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="Denumire" />
            <text-input v-model="form.um" :error="errors.um" class="pr-6 pb-8 w-full lg:w-1/2" label="Unitate Masura" />
            <text-input v-model.number="form.cant" :error="errors.cant" class="pr-6 pb-8 w-full lg:w-1/2" label="Cantitate" />
            <text-input v-model.number="form.cant_r" :error="errors.cant_r" class="pr-6 pb-8 w-full lg:w-1/2" label="Cantitate Ramasa" />
            <text-input v-model.number="form.proteine" :error="errors.proteine" class="pr-6 pb-8 w-full lg:w-1/2" label="Proteine" />
            <text-input v-model.number="form.lipide" :error="errors.lipide" class="pr-6 pb-8 w-full lg:w-1/2" label="Lipide" />
            <text-input v-model.number="form.glucide" :error="errors.glucide" class="pr-6 pb-8 w-full lg:w-1/2" label="Glucide" />
          <text-input v-model="calorii" readonly="true" class="pr-6 pb-8 w-full lg:w-1/2" label="Calorii" />
        </div>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
          <loading-button :loading="sending" class="btn-indigo" type="submit">Creeaza Ingredient</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import TextInput from '@/Shared/TextInput'

export default {
  metaInfo: { title: 'Creeaza Ingredient' },
  layout: Layout,
  components: {
    LoadingButton,
    SelectInput,
    TextInput,
  },
  props: {
    errors: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: null,
        um: 'gr',
        cant: null,
        cant_r: null,
        proteine: null,
        glucide: null,
        lipide: null,
      },
    }
  },
  computed:{
    calorii:function (){
      return (parseFloat(this.form.glucide)*4.1 + parseFloat(this.form.lipide)*9.3 + parseFloat(this.form.proteine)*4.1).toFixed(2)
    }
  },
  methods: {
    submit() {
      this.form.calorii = this.calorii
      this.$inertia.post(this.route('ingredients.store'), this.form, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })
    },
  },
}
</script>
