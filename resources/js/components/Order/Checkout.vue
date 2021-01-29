<template>
  <fragment>
    <form class="offer__form" @submit.prevent="onSubmit">
      <div class="offer__form__title">{{ $t('checkout.title') }}</div>
      <div class="offer__form__desc">{{ $t('checkout.description') }}</div>
      <div class="offer__form__subtitle">{{ $t('checkout.personal_data') }}</div>
      <div class="offer__form__field">
        <label for="name">{{ $t('checkout.user_name') }}</label>
        <input id="name" type="text" placeholder="" name="name" v-model="name"/>
      </div>

      <div class="offer__form__field">
        <label for="email">{{ $t('checkout.email') }}</label>
        <input id="email" name="email" type="email" v-model="email"/>
      </div>

      <div class="offer__form__field">
        <label for="phone">{{ $t('checkout.phone') }}</label>
        <input id="phone" name="phone" type="tel" placeholder="+7(999) 999-99-99" v-model="phone"/>
        <span>{{ $t('checkout.city_code_required') }}</span>
      </div>

      <div class="offer__form__subtitle">{{ $t('checkout.address') }}</div>
      <fragment>
        <country-component
          :countries='countries'
          :default-country="address.country_id"
          :default-region="address.region_id"
          :default-city="address.city_id"
          @countryChange="onCountryChange"
          ref="country"
        />
      </fragment>

      <div class="offer__form__field">
        <label for="address">{{ $t('checkout.address') }}</label>
        <input name="address" id="address" type="text" placeholder="" v-model="deliveryAddress"/>
      </div>

      <div class="offer__form__field offer__form__field--half">
        <label for="postcode">{{ $t('checkout.postcode') }}</label>
        <input id="postcode" name="postcode" type="text" placeholder="XXXXXX" maxlength="6" v-model="postcode"/>
      </div>

      <div class="offer__form__field offer__form__field--full offer__form__pay">
        <label for="payment_type">{{ $t('checkout.payment_method') }}</label>
        <div class="select">
          <select name="payment_type" id="payment_type" v-model="paymentType">
            <option v-for="(name, value) in paymentTypes" :value="value">{{ name }}</option>
          </select>
          <div class="select-arrow"></div>
        </div>

        <!--<a class="offer__form__pay&#45;&#45;score" href="javascript:void(0)" style="display: none">Сформировать счет</a>-->
      </div>

      <div class="offer__form__field">
        <div class="offer__form__field">
          <delivery :items="deliveryMethods" @change="onDeliveryChange" />
        </div>

        <div class="offer__form__field">
          <label for="payment_type">{{ $t('checkout.comment') }}</label>
          <textarea v-model="comment" id="comment" name="comment" :placeholder="$t('checkout.comment')" style="background: #eeede7; padding: 20px"></textarea>
        </div>
      </div>

      <div class="form-check">
        <input id="register" type="checkbox" checked="checked" v-model="acceptedRules"/>
        <label for="register"><span></span><em>{{ $t('checkout.agree') }} <a href='/' target="_blank">{{ $t('checkout.service_rules') }}</a></em></label>
      </div>
      <input type="submit" :value="$t('checkout.' + (isBillPaymentType ? 'bill' : 'order'))" :disabled="isSubmitDisabled"/>
    </form>

    <div class="offer__check" style="position: sticky; top: 50px;">
      <div class="offer__check__title"><a href="/cart">{{ $t('labels.order') }}</a></div>

      <div class="offer__check__product" v-for="item in cart.items">
        <div class="name">{{ getDetailName(item.detail) }} <br>{{ item.detail.sku }}</div>
        <div class="count">{{ item.quantity }} {{ $t('labels.q') }}</div>
        <div class="price">{{ getItemPrice(item) }} {{ oppositeCurrencyName }}<span>{{ item.price_yen }} ¥</span></div>
      </div>

      <div class="offer__check__product">
        <div class="name">{{ $t('labels.delivery') }}</div>
        <div class="price" v-if="deliveryPrice">{{ totalDeliveryPrice }} {{ oppositeCurrencyName }}<span>{{ deliveryPrice.yen }} ¥</span></div>
        <div class="price" v-else>{{ $t('labels.calculation') }}</div>
      </div>

      <div class="offer__check__total">
        <div class="title">{{ $t('orders.total') }}:</div>
        <div class="price">{{ totalOppositePrice }} {{ oppositeCurrencyName }}<span>{{ totalYenPrice }} ¥</span></div>
      </div>

      <div class="offer__check__delivery">
        <div class="block">
          <div class="title">{{ $t('checkout.delivery') }}:</div>
          <p>{{ delivery ? deliveryName : $t('checkout.empty_delivery_method') }}</p>
        </div>
        <div class="block">
          <div class="title">{{ $t('checkout.comment') }}:</div>
          <p>{{ comment }}</p>
        </div>
      </div>
    </div>
  </fragment>
</template>

<script>
  import Delivery from "../Cart/Delivery";

  export default {
    props: ['deliveryMethods', 'paymentTypes', 'cart', 'address', 'user', 'countries'],

    data() {
      return {
        name: this.user ? this.user.name : '',
        email: this.user ? this.user.email : '',
        phone: this.user ? this.user.phone : '',
        country: this.address.country || '',
        deliveryAddress: this.address.address || '',
        postcode: this.address.postcode || '',
        paymentType: '',
        comment: '',
        acceptedRules: true,
        delivery: null,
        deliveryPrice: null
      }
    },

    computed: {
      deliveryName() {
        if (!this.delivery) {
          return
        }

        if (window.app_variables.lang === 'ru' && this.delivery.name_ru && this.delivery.name_ru.length > 0) {
          return this.delivery.name_ru
        }
        return this.delivery.name
      },
      totalDeliveryPrice() {
        return window.app_variables.currency === 'rub' ? this.deliveryPrice.rub : this.deliveryPrice.usd;
      },
      totalOppositePrice() {
        let price = this.cart.items.reduce((accumulator, item) => {
          return accumulator + parseFloat(item[this.itemPriceName]) * item.quantity;
        }, 0);

        if (this.deliveryPrice) {
          price += window.app_variables.currency === 'rub' ? this.deliveryPrice.rub : parseFloat(this.deliveryPrice.usd)
        }

        return window.app_variables.currency === 'rub' ? price : price.toFixed(2)
      },
      totalRubPrice() {
        let price = this.cart.cost.total_usd

        if (this.deliveryPrice) {
          price += this.deliveryPrice.rub
        }

        return price;
      },
      totalUsdPrice() {
        let price = this.cart.cost.total_rub

        if (this.deliveryPrice) {
          price += this.deliveryPrice.rub
        }

        return price;
      },
      totalYenPrice() {
        let price = this.cart.cost.total_yen

        if (this.deliveryPrice) {
          price += this.deliveryPrice.yen
        }

        return price;
      },
      isBillPaymentType() {
        return this.paymentType === 'bill'
      },
      isSubmitDisabled() {
        return !this.delivery || !this.deliveryPrice
      },
      oppositeCurrencyName() {
        return window.app_variables.currencyLabel
      },
      itemPriceName() {
        return window.app_variables.currency === 'rub' ? 'price_rub' : 'price_usd'
      },
    },

    methods: {
      onSubmit() {
        axios.post('/order', {
          name: this.name,
          email: this.email,
          phone: this.phone,
          country_id: this.country,
          region_id: this.$refs.country.region,
          city_id: this.$refs.country.city,
          address: this.deliveryAddress,
          postcode: this.postcode,
          comment: this.comment,
          delivery_type: this.delivery.id,
          payment_type: this.paymentType,
          accepted_rules: this.acceptedRules,
        }).then(res => {
          const data = res.data;

          if (data.success === true) {
            window.location.href = '/cabinet/orders'
            return;
          }

          alert(data.error)
        }).catch(err => {
          console.log(err)
        })
      },
      onDeliveryChange(method) {
        this.delivery = method;

        this.checkDeliveryPrice();
      },
      onCountryChange(country) {
        this.country = country;

        this.checkDeliveryPrice()
      },
      checkDeliveryPrice() {
        if ((!this.country && this.country !== 0) || !this.delivery || !this.delivery.id) {
          return;
        }

        axios.post('/order/delivery', {
          country: this.country,
          delivery: this.delivery.id
        })
        .then(res => {
          const data = res.data;

          if(data.success === false) {
            this.deliveryPrice = null;
            alert(data.error);
            return;
          }

          this.deliveryPrice = data.delivery;
        })
        .catch(err => {
          console.log(err)
        })
      },
      getDetailName(detail) {
        let name = window.app_variables.currency === 'rub' ? detail.name_ru : detail.name_en
        return name && name.length > 0 ? name : detail.name
      },
      getItemPrice(item) {
        return ((window.app_variables.currency === 'rub' ? item.price_rub : item.price_usd) * item.quantity).toFixed(2)
      },
    },

    components: {
      Delivery
    }
  }
</script>

<style scoped>
 :disabled {
   opacity: .5;
 }
</style>
