<template>
  <div>
    <payment-item v-for="payment in payments" :payment="payment" :key="payment.id" />
  </div>
</template>

<script>
  import PaymentItem from "./PaymentItem";

  export default {
    props: ['payments'],

    data() {
      return {
        refills: this.payments,
      }
    },

    components: {PaymentItem}
  }
</script>

<style scoped>

</style>
