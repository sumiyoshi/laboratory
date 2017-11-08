var assert = require('assert');

import Fizzbuzz from 'models/fizzbuzz';

describe('CONTENT_FIZZBUZZ', function () {

  describe('methods', function () {

    let fizzbuzz = new Fizzbuzz;

    it('#run()', function () {
      assert(fizzbuzz.run(1).length === 1);
      assert(fizzbuzz.run(100).length === 100);
    });
    it('#do_run()', function () {

      assert(Fizzbuzz.do_run(1) === 1);
      assert(Fizzbuzz.do_run(3) === 'Fizz');
      assert(Fizzbuzz.do_run(5) === 'Buzz');
      assert(Fizzbuzz.do_run(15) === 'FizzBuzz');
    });
  });
});
