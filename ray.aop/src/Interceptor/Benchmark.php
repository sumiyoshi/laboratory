<?php

namespace Interceptor;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class Benchmark implements MethodInterceptor
{
    public function invoke(MethodInvocation $invocation)
    {
        $start = microtime(true);
        $result = $invocation->proceed();
        $time = (microtime(true) - $start) * 1000;

        $msg = sprintf("\n%s: %f ms", $invocation->getMethod()->getName(), $time);
        return $result . $msg;
    }
}