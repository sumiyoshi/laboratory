#include <stdio.h>

int main(int argc, char *args[])
{
    int num;
    for (num = 1; num <= 100; num = num + 1) {
        if (num % 15 == 0) {
            printf("FizzBuzz\n");
        } else if (num % 3 == 0) {
            printf("Fizz\n");
        } else if (num % 5 == 0) {
            printf("Buzz\n");
        } else {
            printf("%d\n", num);
        }
    }
    return 0;
}