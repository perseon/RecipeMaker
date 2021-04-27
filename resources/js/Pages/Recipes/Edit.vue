<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link :href="route('recipes')" class="text-indigo-400 hover:text-indigo-600">Retete</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="recipe.deleted_at" class="mb-6" @restore="restore">
      This recipe has been deleted.
    </trashed-message>
    <div class="bg-white rounded shadow">
      <form @submit.prevent="submit">
        <div class="flex flex-wrap">
          <text-input v-model="form.name" :error="errors.name" class="m-3 pr-6 pb-8 w-full lg:w-1/2"
                      label="Denumire"
          />
          <table class="w-full whitespace-no-wrap">
            <tr class="text-center">
              <th class="px-6 pt-6 pb-4">Denumire</th>
              <th class="px-6 pt-6 pb-4">Cant</th>
              <th class="px-6 pt-6 pb-4">C Ramas</th>
              <th class="px-6 pt-6 pb-4">Proteine</th>
              <th class="px-6 pt-6 pb-4">Lipide</th>
              <th class="px-6 pt-6 pb-4">Glucide</th>
              <th class="px-6 pt-6 pb-4">Calorii</th>
            </tr>
            <tr v-for="(ingredient,index) in recipe.ingredients" :key="ingredient.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100"
            >
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {{ ingredient.name }}
                        </span>
              </td>
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center" tabindex="-1">
                            <input style="width:5em"  type="number" step="0.5" ref="input" class="form-input"  v-model="ingredient.cant"> {{ ingredient.um }}
                        </span>
              </td>
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center" tabindex="-1">
                            {{ (ingredient.cant_r * ingredient.cant / ingredient.orig).toFixed(2) }}
                        </span>
              </td>
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center" tabindex="-1">
                            {{ (ingredient.proteine * ingredient.cant / ingredient.orig).toFixed(2)  }}
                        </span>
              </td>
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center" tabindex="-1">
                            {{ (ingredient.lipide * ingredient.cant / ingredient.orig).toFixed(2) }}
                        </span>
              </td>
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center" tabindex="-1">
                            {{ (ingredient.glucide * ingredient.cant / ingredient.orig).toFixed(2)}}
                        </span>
              </td>
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center" tabindex="-1">
                            {{ ((ingredient.glucide * 4.1 + ingredient.proteine * 4.1 + ingredient.lipide * 9.3)* ingredient.cant / ingredient.orig ).toFixed(2)}}
                        </span>
              </td>
              <td class="border-t w-px">
                        <span class="px-4 flex items-center" tabindex="-1" @click="deleteIngredient(index)">
                            <icon class="block w-6 h-6 fill-gray-400" name="trash"/>
                        </span>
              </td>
            </tr>
            <tr v-if="recipe.ingredients.length" class="hover:bg-gray-100 focus-within:bg-gray-100 font-bold">
              <td class="border-t">
                <span class="px-6 py-4 flex items-center focus:text-indigo-500" tabindex="-1">
                  TOTAL
                </span>
              </td>
              <td class="border-t">
                <span class="px-4 flex items-center" tabindex="-1">
                  {{ getTotal("cant") }}
                </span>

              </td>
              <td class="border-t">
                <span class="px-4 flex items-center" tabindex="-1">
                {{ getTotal("cant_r") }}
                </span>
              </td>
              <td class="border-t">
                <span class="px-4 flex items-center" tabindex="-1">
                {{ getTotal("proteine") }}
                </span>
              </td>
              <td class="border-t">
                <span class="px-4 flex items-center" tabindex="-1">
                {{ getTotal("lipide") }}
                </span>
              </td>
              <td class="border-t">
                <span class="px-4 flex items-center" tabindex="-1">
                {{ getTotal("glucide") }}
                </span>
              </td>
              <td class="border-t">
                <span class="px-4 flex items-center" tabindex="-1">
                {{ getTotal("calorii") }}
                </span>
              </td>
            </tr>
          </table>

        </div>

        <button class="text-white bg-green-600 hover:bg-green-700 font-bold py-2 px-4 rounded m-2" type="button"
                @click="sideOver=true"
        >
          Adauga ingredient
        </button>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button v-if="!recipe.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button"
                  @click="destroy"
          >Sterge Reteta
          </button>
          <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Actualizeaza
          </loading-button>
        </div>
      </form>
    </div>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div v-if="sideOver" class="fixed inset-0 overflow-hidden">
      <div class="absolute inset-0 overflow-hidden">
        <div aria-hidden="true" class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <section aria-labelledby="slide-over-heading" class="absolute inset-y-0 right-0 pl-10 max-w-full flex">

          <div class="relative w-screen max-w-4xl">

            <div class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4">
              <button
                class="rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white"
                @click="sideOver=false"
              >
                <span class="sr-only">Close panel</span>
                <!-- Heroicon name: outline/x -->
                <svg aria-hidden="true" class="h-6 w-6" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                >
                  <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                  />
                </svg>
              </button>
            </div>
            <div class="h-full flex flex-col py-6 bg-white shadow-xl overflow-y-scroll">
              <div class="px-4 sm:px-6">
                <input autocomplete="off"
                       class="bg-gray-200 text-black relative w-full px-6 py-3 rounded-r focus:shadow-outline"
                       name="cautare" placeholder="Cauta ingredient…" type="text"
                       @input="search($event.target.value)"
                >
              </div>
              <div class="mt-6 relative flex-1 px-4 sm:px-6">
                <table class="w-full whitespace-no-wrap">
                  <tr class="text-left font-bold">
                    <th class="px-6 pt-6 pb-4">Denumire</th>
                    <th class="px-6 pt-6 pb-4">Cant</th>
                    <th class="px-6 pt-6 pb-4">Calorii</th>
                  </tr>
                  <tr v-for="ingredient in XHRingredients.data" :key="ingredient.id"
                      class="hover:bg-gray-100 focus-within:bg-gray-100"
                  >
                    <td class="border-t">
                                          <span class="px-6 py-4 flex items-center focus:text-indigo-500"
                                                @click="selectIngredient(ingredient)"
                                          >
                                              {{ ingredient.name }}
                                          </span>
                    </td>
                    <td class="border-t">
                                          <span class="px-6 py-4 flex items-center" tabindex="-1"
                                                @click="selectIngredient(ingredient)"
                                          >
                                              {{ ingredient.cant }}{{ ingredient.um }}
                                          </span>
                    </td>
                    <td class="border-t">
                                          <span class="px-6 py-4 flex items-center"
                                                @click="selectIngredient(ingredient)"
                                          >
                                              {{ ingredient.calorii }}
                                          </span>
                    </td>
                    <td class="border-t w-px">
                                          <span class="px-4 flex items-center" @click="selectIngredient(ingredient)">
                                              <icon class="block w-6 h-6 fill-gray-400" name="cheveron-right"/>
                                          </span>
                    </td>
                  </tr>
                </table>

              </div>
            </div>
          </div>
        </section>
      </div>
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
import axios from 'axios'

export default {
  metaInfo() {
    return {title: this.form.name}
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
    recipe: Object,
  },
  remember: 'form',
  data() {
    return {
      sending: false,
      form: {
        name: this.recipe.name,
        um: this.recipe.um,
        cant: this.recipe.cant,
        cant_r: this.recipe.cant_r,
        proteine: this.recipe.proteine,
        lipide: this.recipe.lipide,
        glucide: this.recipe.glucide,
        calorii: this.recipe.calorii,
      },
      sideOver: false,
      value: '',
      XHRingredients: [],

    }
  },
  methods: {
    submit() {
      ['um','cant','cant_r','proteine','lipide','glucide','calorii'].forEach((item)=>this.form[item] = item=='um'?'':this.getTotal(item))
      this.form.ingredients = this.recipe.ingredients.map(i => [i.id,i.cant]);
      this.$inertia.put(this.route('recipes.update', this.recipe.id), this.form, {
        onStart: () => this.sending = true,
        onFinish: () => this.sending = false,
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete this recipe?')) {
        this.$inertia.delete(this.route('recipes.destroy', this.recipe.id))
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this recipe?')) {
        this.$inertia.put(this.route('recipes.restore', this.recipe.id))
      }
    },
    search(needle) {
      axios
        .get('/api/ingredients?search=' + needle,
        )
        .then(response => (this.XHRingredients = response))
    },
    selectIngredient(ingredient) {
      //copiem ca sa avem o referinta asupra cantitatii
      ingredient.orig = ingredient.cant
      this.recipe.ingredients.push(ingredient)
      this.sideOver = false
    },
    deleteIngredient(index) {
      //debugger
      this.recipe.ingredients.splice(index, 1)
    },
    getTotal(field){
      const reducer = (accumulator, currentValue) => isNaN(currentValue)?currentValue: accumulator + currentValue;
      const values = this.recipe.ingredients.map(a => field==='cant'?parseInt(a[field]):a[field] * a['cant'] / a['orig']);
      return values.reduce(reducer).toFixed(2)
    }
  },
  mounted() {
    this.search('')
  }
}
</script>
