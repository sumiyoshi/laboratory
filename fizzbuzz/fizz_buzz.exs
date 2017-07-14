fn main() {
    for x in 1..101 {
        match x {
            _ if x % 15 == 0 => println!("{}", "FizzBuzz"),
            _ if x % 3 == 0 => println!("{}", "Fizz"),
            _ if x % 5 == 0 => println!("{}", "Buzz"),
            _ => println!("{}", x),
        }
    }
}
