<template>
  <div class="account__order" :class="payment.class">
    <div class="account__order__header">
      <div class="name">{{ $t('labels.payment') }} № {{ payment.id }}</div>

      <div class="date">{{ payment.date }}</div>
      <div class="count">{{ payment.type.name }}</div>
      <div class="status">{{ payment.status.name }}</div>
      <div class="price">
        {{ totalConvertedPrice }} {{ oppositeCurrencyName }}
        <span>({{ totalYenPrice }} ¥)</span>
      </div>

      <div class="arrow"><img src="/images/arrow.svg" alt="alt"/></div>
    </div>

    <form class="account__order__body" action="/">
      <div class="one">
        <div class="name">{{ $t('deposit.replenishment') }}</div>
        <div class="date"></div>
        <div class="count form-number"></div>
        <div class="type"></div>
        <div class="status"></div>

        <div class="price">
          {{ totalConvertedPrice }} {{ oppositeCurrencyName }}
          <span>({{ totalYenPrice }} ¥)</span>
        </div>
      </div>
      <div class="one" v-if="payment.cancel_reason" style="font-weight: normal; color: #eb492e">
        {{ $t('deposit.cancel_reason') }}: {{ payment.cancel_reason }}
      </div>

      <div class="bottom" v-if="needsToPay">
        <div class="btns">
          <a class="pay" :href="'/cabinet/payments/' + payment.id + '/pay'" target="_blank">
            {{ $t('orders.pay') }}
          </a>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
  export default {
    props: ['payment'],

    computed: {
      needsToPay() {
        return this.payment.status.value === 'new'
      },
      totalConvertedPrice() {
        return window.app_variables.currency === 'rub' ? this.totalRubPrice : this.totalUSDPrice
      },
      totalRubPrice() {
        return this.payment.amount.pure.rub
      },
      totalUSDPrice() {
        return this.payment.amount.pure.usd
      },
      oppositeCurrencyName() {
        return window.app_variables.currencyLabel
      },
      totalYenPrice() {
        return this.payment.amount.pure.yen
      }
    },
  }
</script>

<style>
  .pay--disabled {
    opacity: 0.4;
  }
</style>
