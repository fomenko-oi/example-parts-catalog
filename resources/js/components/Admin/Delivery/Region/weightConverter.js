const GRAMS = 'gr';
const KILOGRAMS = 'kg';

class Weight {
  constructor(grams) {
    this.grams = grams;
  }

  getGrams() {
    return this.grams
  }

  getKiloGrams() {
    return this.grams / 1000
  }

  isKilograms() {
    return this.grams >= 1000
  }

  getUnit() {
    return this.isKilograms() ? KILOGRAMS : GRAMS
  }

  getValue() {
    return (this.isKilograms() ? this.getKiloGrams() : this.getGrams()) + ' ' + this.getUnit()
  }
}
Weight.prototype.toString = function() {
  return this.getValue()
};

export default weight => {
  return new Weight(weight)
}
