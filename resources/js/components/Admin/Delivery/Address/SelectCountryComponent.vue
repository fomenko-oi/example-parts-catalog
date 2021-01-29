<template>
  <fragment>
    <div class="form-group row mb-2">
      <label class="col-md-2 col-form-label">Country</label>
      <input type="hidden" name="country_id" :value="country">
      <div class="col-md-10">
        <model-select
          :options="countriesList"
          v-model="country"
          placeholder="Country"
          id="country"
          autocomplete="country2"
        >
        </model-select>
      </div>
    </div>

    <div class="form-group row mb-2">
      <label class="col-md-2 col-form-label">Region</label>
      <div class="col-md-10">
        <input type="hidden" name="region_id" :value="region">
        <model-select
          :key="country"
          :options="regionsList"
          v-model="region"
          placeholder="Region"
          id="region"
          autocomplete="region"
        >
        </model-select>
      </div>
    </div>

    <div class="form-group row mb-2">
      <label class="col-md-2 col-form-label">City</label>
      <div class="col-md-10">
        <input type="hidden" name="city_id" :value="city">
        <model-select
          :key="region"
          :options="citiesList"
          v-model="city"
          placeholder="City"
          id="city"
          autocomplete="city2"
        >
        </model-select>
      </div>
    </div>
  </fragment>
</template>

<script>
  import 'vue-search-select/dist/VueSearchSelect.css';
  import { ModelSelect } from 'vue-search-select'

  export default {
    props: ['countries', 'defaultCountry', 'defaultRegion', 'defaultCity'],

    data() {
      return {
        country: '',

        regionsList: [],
        region: '',

        citiesList: [],
        city: '',
      }
    },

    computed: {
      countriesList() {
        return this.countries.map(el => {
          return {value: el.id, text: el.name}
        })
      },
      currentCountry() {
        return this.countries.filter(el => el.id === parseInt(this.country))[0]
      },
    },

    methods: {
      onCountrySelect(country) {
        this.country = country;

        this.regionsList = [];
        this.citiesList = [];
        this.region = '';
        this.city = '';

        if (!this.country && this.country !== 0) {
          return;
        }

        axios.get(`/api/country/${this.country}/regions`)
          .then(res => {
            this.regionsList = res.data.map(el => {
              return {value: el.id, text: el.name}
            });
          })
      },
      onRegionSelect(region) {
        this.region = region;

        if ((!this.country && this.country !== 0) || (!this.region && this.region !== 0)) {
          return;
        }

        this.citiesList = [];
        this.city = '';

        axios.get(`/api/country/${this.country}/${this.region}`)
          .then(res => {
            this.citiesList = res.data.map(el => {
              return {value: el.id, text: el.name}
            });
          })
      },
      onCitySelect(city) {
        this.city = city;
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
    },

    async mounted() {
      if(this.defaultCountry) {
        this.country = parseInt(this.defaultCountry);
        this.$emit('countryChange', this.country);

        await axios.get(`/api/country/${this.country}/regions`)
          .then(res => {
            this.regionsList = res.data.map(el => {
              return {value: el.id, text: el.name}
            });
          });

        this.region = parseInt(this.defaultRegion);
        await axios.get(`/api/country/${this.country}/${this.region}`)
          .then(res => {
            this.citiesList = res.data.map(el => {
              return {value: el.id, text: el.name}
            });
          });

        this.city = parseInt(this.defaultCity);
      }
    },

    watch: {
      country() {
        this.$emit('countryChange', this.country);

        if (this.country) {
          this.onCountrySelect(this.country)
        }
      },
      region() {
        this.$emit('regionChange', this.region);

        if (this.region) {
          this.onRegionSelect(this.region)
        }
      },
      city() {
        this.$emit('citySelect', this.city);

        if (this.city) {
          this.onCitySelect(this.city)
        }
      }
    },

    components: {
      ModelSelect
    }
  }
</script>

<style scoped>

</style>
