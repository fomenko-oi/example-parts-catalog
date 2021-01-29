<template>
  <fragment>
    <div class="account__content__title">{{ $t('orders.header') }}</div>

    <order-item v-for="order in orders" :order="order" :key="order.id" />
  </fragment>
</template>

<script>
  import OrderItem from "./OrderItem";

  export default {
    props: ['orders'],

    components: {OrderItem}
  }
</script>

<style scoped>

</style>
