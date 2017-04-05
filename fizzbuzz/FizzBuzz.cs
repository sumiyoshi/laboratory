public class Hello{
    public static void Main() {
        FizzBuzz.Run();
    }
}

public class FizzBuzz {

    public static void Run() {
        foreach(int i in System.Linq.Enumerable.Range(1, 100))
        {
            if (i % 15 == 0) {
                System.Console.WriteLine("FizzBuzz");
            } else if (i % 3 == 0) {
                System.Console.WriteLine("Fizz");
            } else if (i % 5 == 0) {
                System.Console.WriteLine("Buzz");
            } else {
                System.Console.WriteLine(i);
            }
        }
    }
}