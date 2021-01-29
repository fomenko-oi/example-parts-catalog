<template>
  <div class="select">
    <label>{{ $t('checkout.delivery') }}</label>

    <input type="hidden" name="delivery_type" :value="delivery ? delivery.id : null">

    <select name="delivery" id="delivery_type" v-model="delivery" >
      <option value="none" disabled="disabled" selected="selected">{{ $t('checkout.choose_delivery') }}</option>

      <option v-for="method in items" :value="method" :data-cost="method.cost">{{ getDeliveryName(method) }}</option>
    </select>
    <div class="select-arrow"></div>
  </div>
</template>

<script>
  export default {
    props: ['items'],

    data() {
      return {
        delivery: ''
      }
    },

    methods: {
      getDeliveryName(method) {
        if (window.app_variables.lang === 'ru' && method.name_ru && method.name_ru.length > 0) {
          return method.name_ru
        }
        return method.name
      }
    },

    watch: {
      delivery() {
        this.$emit('change', this.delivery)
      }
    }
  }
</script>

<style scoped>

</style>
