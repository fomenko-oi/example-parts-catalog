<template>
  <div class="one">
    <div class="name">{{ item.name }}<span>{{ item.sku }}</span></div>
    <div class="date"></div>
    <div class="count form-number">
      <span class="form-number-decrement" @click="onDecrement">–</span>
      <input type="text" name="calculate" maxlength="3" value="1" min="1" max="999" readonly="readonly" v-model.number="quantity"/>
      <span class="form-number-increment" @click="onIncrement">+</span>
      <p>{{ $t('labels.q') }}</p>
    </div>
    <div class="type"></div>
    <div class="status"></div>
    <div class="price">{{ totalPrice }} {{ currencyLabel }}<span>({{ totalYenPrice }} ¥)</span></div>

    <div class="arrow" v-if="itemsCount > 1" @click="$emit('remove')"><img src="/images/close.svg" alt="alt"/></div>
  </div>
</template>

<script>
  export default {
    props: ['item', 'itemsCount', 'priceField', 'currencyLabel'],

    data() {
      return {
        quantity: this.item.quantity
      }
    },

    computed: {
      totalPrice() {
        return this.item.price[window.app_variables.currency] * this.item.quantity
      },
      totalRubPrice() {
        return this.item.price.rub * this.item.quantity
      },
      totalYenPrice() {
        return this.item.price.yen * this.item.quantity
      }
    },

    methods: {
      onIncrement() {
        this.quantity++;
      },
      onDecrement() {
        if (this.quantity <= 1) {
          this.quantity = 1;
          return
        }
        this.quantity--;
      },
    },

    watch: {
      quantity() {
        if (this.quantity <= 1) {
          this.quantity = 1;
        }
        this.$emit('quantityUpdate', this.quantity)
      }
    }
  }
</script>

<style scoped>

</style>
