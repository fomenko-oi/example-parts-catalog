<template>
  <div class="form-row">
    <div class="col-lg-3 mb-3">
      <label :for="'from-' + id">From <span v-if="from">({{ fromWeight}})</span></label>
      <input :name="`ranges[${id}][from]`" v-model.number="from" class="form-control" :id="'from-' + id" type="number" placeholder="Weight From" required>
    </div>

    <div class="col-lg-3 mb-3">
      <label :for="'to-' + id">To <span v-if="to">({{ toWeight }})</span></label>
      <input :name="`ranges[${id}][to]`" v-model.number="to" class="form-control" :id="'to-' + id" type="number" placeholder="Weight To" required>
    </div>

    <div class="col-lg-3 mb-3">
      <label :for="'price-' + id">Price</label>
      <input :name="`ranges[${id}][price]`" v-model.number="price" :id="'price-' + id" class="form-control" type="number" placeholder="Price" required>
    </div>

    <div class="col-lg-3 mb-3">
      <input class="form-control" id="validationServer02" type="number" placeholder="Price" value="Otto" style="visibility: hidden">

      <div class="btn btn-xs btn-danger" style="margin-left: 15px;" @click="$emit('remove')" v-if="canRemove">
        <em class="fa-1x mr-1 ml-1 fas fa-trash-alt"></em>
      </div>
    </div>
  </div>
</template>

<script>
  import weightConverter from './weightConverter'

  export default {
    props: ['item', 'canRemove', 'id'],

    data() {
      return {
        from: this.item.from,
        to: this.item.to,
        price: this.item.price,
      }
    },

    computed: {
      fromWeight() {
        return weightConverter(this.from)
      },
      toWeight() {
        return weightConverter(this.to)
      },
      inputData() {
        return {
          from: this.from,
          to: this.to,
          price: this.price,
        }
      },
    },

    methods: {
      triggerChange() {
        this.$emit('change', this.inputData)
      }
    },

    watch: {
      from() {
        return this.triggerChange()
      },
      to() {
        return this.triggerChange()
      },
      price() {
        return this.triggerChange()
      },
    }
  }
</script>

<style scoped>

</style>
