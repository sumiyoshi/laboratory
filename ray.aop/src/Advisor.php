<?php

use Ray\Aop\Pointcut;
use Ray\Aop\Matcher;
use Ray\Aop\Bind;
use Ray\Aop\Compiler;

class Advisor
{

    /**
     * @var array
     */
    protected $interceptor = [
        \Interceptor\Benchmark::class,
        \Interceptor\Logger::class,
    ];

    /**
     * @var array
     */
    protected $pointcuts = [];

    /**
     * @var Compiler
     */
    protected $compiler = null;

    /**
     * @var null
     */
    protected $tmpDir = null;

    public function __construct($tmpDir)
    {
        $this->tmpDir = $tmpDir;
        $this->pointcuts = $this->getPointcuts();
        $this->compiler = $this->getCompiler();
    }

    protected function getPointcuts() : array
    {
        $pointcuts = [];
        foreach ($this->interceptor as $item) {
            $pointcuts[] = new Pointcut(
                (new Matcher)->any(),
                (new Matcher)->annotatedWith($item),
                [new $item]
            );
        }

        return $pointcuts;
    }

    protected function getCompiler() : Compiler
    {
        return (new Compiler($this->tmpDir));
    }

    public function newInstance($name, array $args)
    {
        $bind = (new Bind)->bind($name, $this->pointcuts);
        return $this->compiler->newInstance($name, $args, $bind);
    }

}