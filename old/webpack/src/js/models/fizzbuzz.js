export default class Fizzbuzz {

  run(num) {
    let range = Array.from(new Array(num).keys());
    return range.reduce(function (previousValue, currentValue) {
      previousValue.push(Fizzbuzz.do_run(currentValue + 1));
      return previousValue;
    }, []);
  }

  static do_run(num) {
    if (num % 15 == 0) {
      return 'FizzBuzz'
    } else if (num % 3 == 0) {
      return 'Fizz'
    } else if (num % 5 == 0) {
      return 'Buzz'
    }
    return num;
  }
}