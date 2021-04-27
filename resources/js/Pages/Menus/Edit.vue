<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('menus')">Meniu</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>
    <trashed-message v-if="menu.deleted_at" class="mb-6" @restore="restore">
      Meniul a fost sters.
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
            <tr v-for="(recipe,index) in menu.recipes" :key="recipe.id"
                class="hover:bg-gray-100 focus-within:bg-gray-100"
            >
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center focus:text-indigo-500">
                            {{ recipe.name }}
                        </span>
              </td>
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center" tabindex="-1">
                            <input style="width:5em"  type="number" step="0.5" ref="input" class="form-input"  v-model="recipe.cant"> {{ recipe.um }}
                        </span>
              </td>
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center" tabindex="-1">
                            {{ (recipe.cant_r * recipe.cant / recipe.orig).toFixed(2) }}
                        </span>
              </td>
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center" tabindex="-1">
                            {{ (recipe.proteine * recipe.cant / recipe.orig).toFixed(2)  }}
                        </span>
              </td>
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center" tabindex="-1">
                            {{ (recipe.lipide * recipe.cant / recipe.orig).toFixed(2) }}
                        </span>
              </td>
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center" tabindex="-1">
                            {{ (recipe.glucide * recipe.cant / recipe.orig).toFixed(2)}}
                        </span>
              </td>
              <td class="border-t">
                        <span class="px-6 py-4 flex items-center" tabindex="-1">
                            {{ ((recipe.glucide * 4.1 + recipe.proteine * 4.1 + recipe.lipide * 9.3)* recipe.cant / recipe.orig ).toFixed(2)}}
                        </span>
              </td>
              <td class="border-t w-px">
                        <span class="px-4 flex items-center" tabindex="-1" @click="deleteIngredient(index)">
                            <icon class="block w-6 h-6 fill-gray-400" name="trash"/>
                        </span>
              </td>
            </tr>
            <tr v-if="menu.recipes.length" class="hover:bg-gray-100 focus-within:bg-gray-100 font-bold">
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
          Adauga Reteta
        </button>
        <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex items-center">
          <button v-if="!menu.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button"
                  @click="destroy"
          >Sterge Meniu
          </button>
          <loading-button :loading="sending" class="btn-indigo ml-auto" type="submit">Actualizeaza
          </loading-button>
        </div>
      </form>
    </div>
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
                  <tr v-for="recipe in XHRrecipes.data" :key="recipe.id"
                      class="hover:bg-gray-100 focus-within:bg-gray-100"
                  >
                    <td class="border-t">
                                          <span class="px-6 py-4 flex items-center focus:text-indigo-500"
                                                @click="selectRecipe(recipe)"
                                          >
                                              {{ recipe.name }}
                                          </span>
                    </td>
                    <td class="border-t">
                                          <span class="px-6 py-4 flex items-center" tabindex="-1"
                                                @click="selectRecipe(recipe)"
                                          >
                                              {{ recipe.cant }}{{ recipe.um }}
                                          </span>
                    </td>
                    <td class="border-t">
                                          <span class="px-6 py-4 flex items-center"
                                                @click="selectRecipe(recipe)"
                                          >
                                              {{ recipe.calorii }}
                                          </span>
                    </td>
                    <td class="border-t w-px">
                                          <span class="px-4 flex items-center" @click="selectRecipe(recipe)">
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
        calorii: this.menu.calorii,
      },
      sideOver: false,
      value: '',
      XHRrecipes: [],
    }
  },
  methods: {
    submit() {
      ['um','cant','cant_r','proteine','lipide','glucide','calorii'].forEach((item)=>this.form[item] = item=='um'?'':this.getTotal(item))
      this.form.recipes = this.menu.recipes.map(i => [i.id,i.cant]);
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
    search(needle) {
      axios
        .get('/api/recipes?search=' + needle,
        )
        .then(response => (this.XHRrecipes = response))
    },
    selectRecipe(recipe) {
      //copiem ca sa avem o referinta asupra cantitatii
      recipe.orig = recipe.cant
      this.menu.recipes.push(recipe)
      this.sideOver = false
    },
    deleteRecipe(index) {
      //debugger
      this.menu.recipes.splice(index, 1)
    },
    getTotal(field){
      const reducer = (accumulator, currentValue) => isNaN(currentValue)?currentValue: accumulator + currentValue;
      const values = this.menu.recipes.map(a => field==='cant'?parseInt(a[field]):a[field] * a['cant'] / a['orig']);
      return values.reduce(reducer).toFixed(2)
    }
  },
  mounted() {
    this.search('')
  }
}
</script>
