public class FizzBuzz {
    public static void main(String[] args) {
        run();
    }

    public static void run() {
        for (int num = 1; num <= 100; num++) {
            if (num % 15 == 0) {
                System.out.println("FizzBuzz");
            } else if (num % 3 == 0) {
                System.out.println("Fizz");
            } else if (num % 5 == 0) {
                System.out.println("Buzz");
            } else {
                System.out.println(num);
            }
        }
    }
}
