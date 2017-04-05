-module(fizz_buzz).
-export([run/0, run/1]).

run() -> run(1).
run(N) when N > 100 -> ok;
run(N) ->
    if
        N rem 15 == 0 -> io:write('FizzBuzz');
        N rem 3  == 0 -> io:write('Fizz');
        N rem 5  == 0 -> io:write('Buzz');
        true -> io:write(N)
    end,
    io:nl(),
    run(N + 1).
