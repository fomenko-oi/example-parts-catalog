<template>
  <div class="form-group row">
    <div class="col-md-12">
      <range
        v-for="(range, index) in items"
        :item="range"
        :id="range.id"
        :key="range.id"
        :can-remove="items.length > 1"
        @remove="onRemove(index)"
        @change="onChange(index, $event)"
      />

      <div class="btn btn-warning" type="submit" @click="addOption">Add option</div>
      <button class="btn btn-primary" type="submit">Update</button>
    </div>
  </div>
</template>

<script>
  import Range from "./Range";

  export default {
    props: ['ranges'],

    data() {
      return {
        items: [],
        maxId: 1,
      }
    },

    mounted() {
      this.ranges.map(range => {
        this.items.push({from: range.from, to: range.to, price: range.price, id: this.maxId})
        this.maxId++;
      })

      if (this.ranges.length === 0) {
        this.items.push({from: 0, to: 500, price: null, id: this.maxId})
      }
    },

    computed: {
      maxWeightValue() {
        return _.maxBy(this.items, 'to').to
      }
    },

    methods: {
      addOption() {
        const maxValue = this.maxWeightValue * 2;

        this.maxId++;
        this.items.push({from: this.maxWeightValue, to: maxValue, price: null, id: this.maxId})
      },
      onRemove(index) {
        this.$delete(this.items, index)
      },
      onChange(index, payload) {
        const range = this.items[index];

        range.from = payload.from;
        range.to = payload.to;
        range.price = payload.price;
      }
    },

    components: {Range}
  }
</script>

<style scoped>

</style>
