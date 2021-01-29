<template>
  <form class="basket__form" action="/checkout" method="GET">
    <div class="basket__table">
      <table class="table">
        <tbody>
          <tr>
            <th>{{ $t('cart.name') }}</th>
            <th>{{ $t('cart.quantity') }}</th>
            <th>{{ $t('cart.price') }} ({{ $t('cart.price_1q') }})</th>
            <th>{{ $t('cart.price') }}</th>
            <th></th>
          </tr>

          <tr v-if="details.length === 0">
            <td colspan="4" style="text-align: center;">{{ $t('cart.nothing_added') }}</td>
          </tr>

          <cart-item
            v-for="(item, index) in details"
            :item="item"
            :key="item.id"
            @quantityUpdate="onQuantityUpdate(index, $event)"
            @remove="onItemRemove(index)"
            :price-field="itemPriceName"
            :currency-label="oppositeCurrencyName"
          />
        </tbody>
      </table>
    </div>

    <div class="basket__delivery">

    </div>

    <div class="basket__total">
      <div class="basket__total__summa">
        <div class="title">{{ $t('cart.final_amount') }}:</div>
        <p>{{ totalPrice }} {{ oppositeCurrencyName }}<span>{{ totalYenPrice }} ¥</span></p>
      </div>

      <input class="basket__total__order" type="submit" :value="$t('cart.checkout')" :disabled="isSubmitDisabled">
    </div>
  </form>
</template>

<script>
  import CartItem from "./CartItem";

  export default {
    props: ['items'],

    data() {
      return {
        details: this.items,
        comment: '',
      }
    },

    computed: {
      oppositeCurrencyName() {
        return window.app_variables.currencyLabel
      },
      itemPriceName() {
        return window.app_variables.currency === 'rub' ? 'price_rub' : 'price_usd'
      },
      totalPrice() {
        let price = this.details.reduce((accumulator, item) => {
          return accumulator + parseFloat(item.detail[this.itemPriceName]) * item.quantity;
        }, 0);

        return window.app_variables.currency === 'rub' ? price : price.toFixed(2)
      },
      totalYenPrice() {
        return this.details.reduce((acc, current) => acc + current.quantity * current.price_yen, 0)
      },
      isSubmitDisabled() {
        return this.details.length === 0
      }
    },

    methods: {
      onItemRemove(index) {
        const cartCount = $('#cart_amount_count');

        this.details.splice(index, 1);

        cartCount.text(parseInt(cartCount.text() - 1));
      },
      onQuantityUpdate(key, quantity) {
        this.$set(this.details[key], 'quantity', quantity)
      }
    },

    components: {CartItem}
  }
</script>

<style scoped>
  input[disabled] {
    opacity: .5;
  }
</style>
