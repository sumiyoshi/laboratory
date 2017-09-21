<?php

/**
 * @Interceptor\ClassLogger
 */
class Hello
{
    /**
     * @Interceptor\Logger
     * @Interceptor\Benchmark
     */
    public function say()
    {
        return 'Hello World!';
    }

}