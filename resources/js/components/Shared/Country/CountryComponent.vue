<template>
  <fragment>
    <div class="login__form__field">
      <label for="country">{{ $t('labels.country') }}</label>

      <input type="hidden" name="country_id" :value="country">
      <input
        id="country"
        name="country"
        type="text"
        autocomplete="login"
        :placeholder="$t('labels.start_input')"
        v-model="countrySuggest"
        required
        @focusout="onCountryFocusOut"
        @keydown.enter.prevent
      >
      <div class="select-arrow"></div>
      <div class="login__form__field__list">
        <p v-for="country in filteredCountries" @click="onCountrySelect(country)">{{ getCountryName(country) }}</p>
      </div>
    </div>

    <div class="login__form__field">
      <label for="region">{{ $t('labels.region') }}</label>
      <input type="hidden" name="region_id" :value="region">
      <input id="region" name="region" type="text" autocomplete="region2" :placeholder="$t('labels.start_input')" v-model="regionSuggest" @keydown.enter.prevent>
      <div class="select-arrow"></div>
      <div class="login__form__field__list">
        <p v-for="region in filteredRegions" @click="onRegionSelect(region)">{{ region.name }}</p>
      </div>
    </div>

    <div class="login__form__field">
      <label for="city">{{ $t('labels.city') }}</label>
      <input type="hidden" name="city_id" :value="city">
      <input id="city" name="city" type="text" autocomplete="city" :placeholder="$t('labels.start_input')" v-model="citySuggest" @keydown.enter.prevent>
      <div class="select-arrow"></div>
      <div class="login__form__field__list">
        <p v-for="city in filteredCities" @click="onCitySelect(city)">{{ city.name }}</p>
      </div>
    </div>
  </fragment>
</template>

<script>
  export default {
    props: ['countries', 'defaultCountry', 'defaultRegion', 'defaultCity'],

    data() {
      return {
        countrySuggest: '',
        country: '',

        regionsList: [],
        regionSuggest: '',
        region: '',

        citiesList: [],
        citySuggest: '',
        city: '',
      }
    },

    computed: {
      currentCountry() {
        return this.countries.filter(el => el.id === parseInt(this.country))[0]
      },
      filteredCountries() {
        if(this.countrySuggest && this.countrySuggest.length > 0) {
          return this.countries.filter(el => el.name.toLowerCase().includes(this.countrySuggest.toLocaleLowerCase()))
        }
        return this.countries
      },
      filteredRegions() {
        if(this.regionSuggest.length > 0) {
          return this.regionsList.filter(el => el.name.toLowerCase().includes(this.regionSuggest.toLocaleLowerCase()))
        }
        return this.regionsList
      },
      filteredCities() {
        if(this.citySuggest && this.citySuggest.length > 0) {
          return this.citiesList.filter(el => el.name.toLowerCase().includes(this.citySuggest.toLocaleLowerCase()))
        }
        return this.citiesList
      }
    },

    methods: {
      onCountrySelect(country) {
        this.country = country.id;
        this.countrySuggest = country.name;

        this.regionsList = [];
        this.regionsList = [];
        this.citiesList = [];
        this.regionSuggest = '';
        this.region = '';
        this.citySuggest = '';
        this.city = '';

        if (!this.country && this.country !== 0) {
          return;
        }

        axios.get(`/api/country/${this.country}/regions`)
          .then(res => {
            this.regionsList = res.data;
          })
      },
      onRegionSelect(region) {
        this.region = region.id;
        this.regionSuggest = region.name;

        if ((!this.country && this.country !== 0) || (!this.region && this.region !== 0)) {
          return;
        }

        this.citiesList = [];
        this.citySuggest = '';
        this.city = '';

        axios.get(`/api/country/${this.country}/${this.region}`)
          .then(res => {
            this.citiesList = res.data;
          })
      },
      onCitySelect(city) {
        console.log(city)

        this.city = city.id;
        this.citySuggest = city.name;
      },
      onCountryFocusOut() {
        /*if (!this.currentCountry) {
          return
        }
        this.countrySuggest = this.currentCountry.name*/
      },
      getCountryById(id) {
        return this.countries.filter(item => item.id === id)[0]
      },
      getRegionById(id) {
        return this.regionsList.filter(item => item.id === id)[0]
      },
      getCityById(id) {
        return this.citiesList.filter(item => item.id === id)[0]
      },
      getCountryName(country) {
        if (window.app_variables.lang === 'ru' && country.name_ru && country.name_ru.length > 0) {
          return country.name_ru
        }
        return country.name
      }
    },

    async mounted() {
      if(this.defaultCountry) {
        this.country = parseInt(this.defaultCountry);
        this.$emit('countryChange', this.country);

        await axios.get(`/api/country/${this.country}/regions`)
          .then(res => {
            this.regionsList = res.data;
          });

        this.countrySuggest = this.getCountryById(this.country).name;

        this.region = parseInt(this.defaultRegion);
        await axios.get(`/api/country/${this.country}/${this.region}`)
          .then(res => {
            this.citiesList = res.data;
          });
        this.regionSuggest = this.getRegionById(this.region).name;

        this.city = parseInt(this.defaultCity);
        this.citySuggest = this.getCityById(this.city).name;
      }
    },

    watch: {
      country() {
        this.$emit('countryChange', this.country);
      }
    }
  }
</script>

<style scoped>

</style>
