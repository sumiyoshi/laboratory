<?php

namespace Interceptor;

use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class Logger implements MethodInterceptor
{
    public function invoke(MethodInvocation $invocation)
    {
        echo "処理開始！：". $invocation->getMethod()->getName() . PHP_EOL;
        $result = $invocation->proceed();
        return $result . PHP_EOL . '処理終わり!' . PHP_EOL;
    }
}