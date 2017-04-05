object Main extends App{

    def run(i: Int) = i match {
      case i if i % 15 == 0 => "FizzBuzz"
      case i if i % 3 == 0 => "Fizz"
      case i if i % 5 == 0 => "Buzz"
      case _ => i
    }
    
    (1 to 100).map(run).foreach(println)
}
