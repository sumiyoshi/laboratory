import Fizzbuzz from 'models/fizzbuzz';

export default {
  name: 'ContentViewModel',
  el: '#point',
  data: {
    list: [],
    num: null
  },
  methods: {
    fizzbuzz: function () {
      this.list = [];
      let fizzbuzz = new Fizzbuzz;
      if (parseInt(this.num) > 0) {
        this.list = fizzbuzz.run(parseInt(this.num));
      }
    }
  }
}
