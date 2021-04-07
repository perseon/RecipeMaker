<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Ingrediente</h1>
    <ul>
      <li>
        <a :href="route('exportIngredients')" class="text-indigo-400 hover:text-indigo-600">Export ingrediente</a>
      </li>
    </ul>

    <form  :action="route('importIngredients')" method="POST" enctype="multipart/form-data">
      <input type="file" name="file" class="form-control">
      <br>
      <button class="btn btn-success">Import ingrediente</button>
    </form>
  </div>
</template>

<script>

import Layout from '@/Shared/Layout'

export default {
  metaInfo: { title: 'Organizations' },
  layout: Layout,
  components: {
  },
  props: {
    ingredients: Object,
    filters: Object,
  },
  data() {
    return {

    }
  },
  watch: {
  },
  methods: {

  },
}
</script>
