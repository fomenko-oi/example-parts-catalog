<template>
  <tr :data-max="item.quantity" :data-price="item.price_rub">
    <td>{{ item.detail.name }} <br>{{ item.detail.description }}</td>
    <td>
      <div class="form-number">
        <span class="form-number-decrement" @click="onDecrement">–</span>
        <input class="form-number-input quantity--number" type="text" name="calculate" maxlength="3" min="1" max="999" v-model.number="quantity">
        <span class="form-number-increment" @click="onIncrement">+</span>
      </div>
    </td>
    <td>
      <div class="price_rub">{{ oppositePrice }} {{ currencyLabel }}</div>
      <div class="price_yen">({{ item.price_yen }} ¥)</div>
    </td>
    <td class="final-calculation">
      <div class="price_rub">{{ totalPrice }} {{ currencyLabel }}</div>
      <div class="price_yen">({{ totalPriceYen }} ¥)</div>
    </td>
    <td><img @click="removeItem" src="/images/close.svg" alt="alt"></td>
  </tr>
</template>

<script>
  export default {
    props: ['item', 'priceField', 'currencyLabel'],

    data() {
      return {
        quantity: this.item.quantity
      }
    },

    computed: {
      totalPrice() {
        return (this.oppositePrice * this.quantity)
      },
      totalRubPrice() {
        return this.item.detail.price_rub * this.quantity
      },
      totalPriceYen() {
        return this.item.price_yen * this.quantity
      },
      oppositePrice() {
        return this.item.detail[this.priceField]
      }
    },

    methods: {
      onIncrement() {
        this.quantity += 1;
      },
      onDecrement() {
        if (this.quantity <= 1) {
          this.quantity = 1;
          return;
        }
        this.quantity -= 1;
      },
      removeItem() {
        this.$emit('remove');

        axios.delete(`/cart?id=${this.item.id}`).then(res => {
          console.log(res.data);
        })
      }
    },

    watch: {
      quantity(newValue, prevValue) {
        if (this.quantity <= 1) {
          this.quantity = 1;
        }

        axios.put(`/cart?id=${this.item.id}&quantity=${this.quantity}`).then(res => {
          if (res.data.success === true) {
            this.$emit('quantityUpdate', this.quantity)
            return true;
          }

          this.quantity = res.data.quantity;

          alert(res.data.error);
          console.log(res.data)
        })
      }
    }
  }
</script>

<style scoped>

</style>
