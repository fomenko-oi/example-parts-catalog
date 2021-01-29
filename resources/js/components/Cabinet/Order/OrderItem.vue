<template>
  <div class="account__order" :class="order.class">
    <div class="account__order__header">
      <div class="name" v-if="isUpdatable">{{ $t('orders.order') }}<span class="edit">№ {{ order.id }}</span></div>
      <div class="name" v-else>{{ $t('orders.order') }} № {{ order.id }}</div>

      <div class="date">{{ order.date }}</div>
      <div class="count">{{ $t('orders.quantity') }} {{ totalQuantity }} {{ $t('labels.q') }}</div>
      <div class="type">{{ orderStatus }}</div>
      <div class="status">{{ paymentStatus }}</div>
      <div class="price">
        {{ totalConvertedPrice }} {{ oppositeCurrencyName }}
        <span>({{ totalYenPrice }} ¥)</span>
      </div>
      <div class="arrow"><img src="/images/arrow.svg" alt="alt"/></div>
    </div>

    <form class="account__order__body" action="/">
      <order-detail-item
        v-for="(item, index) in items"
        :item="item"
        :items-count="totalQuantity"
        :price-field="itemPriceName"
        :currency-label="oppositeCurrencyName"
        :key="item.id"
        @quantityUpdate="onQuantityUpdate(index, $event)"
        @remove="onRemove(index)"
      />

      <div class="one">
        <div class="name">{{ $t('orders.delivery') }}: {{ deliveryName }}</div>
        <div class="date"></div>
        <div class="count form-number"></div>
        <div class="type"></div>
        <div class="status"></div>

        <div class="price">
          {{ totalDeliveryPrice }} {{ oppositeCurrencyName }}
          <span>({{ totalYenDeliveryPrice }} ¥)</span>
        </div>
      </div>

      <div class="bottom">
        <div class="delivery">{{ $t('orders.total') }}:</div>
        <div class="total">
          {{ totalConvertedPrice }} {{ oppositeCurrencyName }}
          <span>( {{ totalYenPrice }} ¥)</span>
        </div>
        <div class="btns">
          <input @click.prevent="onSaveItems" v-if="dataChanged" class="save" type="submit" :value="$t('orders.save')"/>
          <a v-if="needsToPay" :class="{'pay': true, 'pay--disabled': payButtonDisabled}" :href="'/cabinet/orders/' + order.id + '/pay'">
            {{ $t('orders.pay') }}
          </a>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
  import OrderDetailItem from "./OrderDetailItem";

  export default {
    props: ['order'],

    data() {
      return {
        items: this.order.items,
        dataChanged: false,
        changeDeliveryPrice: {}
      }
    },

    computed: {
      deliveryName() {
        if (window.app_variables.lang === 'ru' && this.order.delivery.name_ru && this.order.delivery.name_ru.length > 0) {
          return this.order.delivery.name_ru
        }
        return this.order.delivery.name
      },
      oppositeCurrencyName() {
        return window.app_variables.currencyLabel
      },
      itemPriceName() {
        return window.app_variables.currency === 'rub' ? 'price_rub' : 'price_usd'
      },
      totalDeliveryPrice() {
        return window.app_variables.currency === 'rub' ? this.totalRubDeliveryPrice : this.totalUsdDeliveryPrice;
      },
      totalRubDeliveryPrice() {
        return this.changeDeliveryPrice.rub || this.order.delivery.cost.rub
      },
      totalUsdDeliveryPrice() {
        return this.changeDeliveryPrice.usd || this.order.delivery.cost.usd
      },
      totalYenDeliveryPrice() {
        return this.changeDeliveryPrice.yen || this.order.delivery.cost.yen
      },
      isUpdatable() {
        return this.order.status.value === 'new' && this.order.payment_status.value === 'wait'
      },
      totalQuantity() {
        return this.items.length
      },
      totalRubPrice() {
        return this.items.reduce((acc, current) => acc + current.quantity * current.price.rub, 0) + this.totalRubDeliveryPrice
      },
      totalUSDPrice() {
        let price = this.items.reduce((acc, current) => acc + current.quantity * parseFloat(current.price.usd), 0) + parseFloat(this.totalUsdDeliveryPrice)

        return parseFloat(price).toFixed(2)
      },
      totalConvertedPrice() {
        return window.app_variables.currency === 'rub' ? this.totalRubPrice : this.totalUSDPrice
      },
      totalYenPrice() {
        return this.items.reduce((acc, current) => acc + current.quantity * current.price.yen, 0) + this.totalYenDeliveryPrice
      },
      paymentStatus() {
        return this.order.payment_status.name
      },
      needsToPay() {
        return this.order.payment_status.value === 'wait'
      },
      orderStatus() {
        return this.order.status.name
      },
      payButtonDisabled() {
        return this.dataChanged
      }
    },

    methods: {
      onQuantityUpdate(key, quantity) {
        this.dataChanged = true;
        this.$set(this.items[key], 'quantity', quantity)
      },
      onRemove(index) {
        this.items.splice(index, 1);
        this.dataChanged = true;
      },
      onSaveItems() {
        const items = {};
        this.items.map(el => {items[el.id] = el.quantity})

        axios.put(`/cabinet/orders/${this.order.id}`, {
          items: items
        })
          .then(res => {
            if (res.data.success === false) {
              alert(res.data.error);
              return;
            }
            this.dataChanged = false;
            this.changeDeliveryPrice = res.data.order.delivery_cost;
          })
          .catch(err => {
            console.log(err)
          })
      }
    },

    components: {
      OrderDetailItem
    }
  }
</script>

<style>
  .pay--disabled {
    opacity: 0.4;
  }
</style>
