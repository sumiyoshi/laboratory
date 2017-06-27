<?php

namespace App;

class Markdown
{
    /**
     * @param $argument1
     * @return string
     */
    public function toHtml($argument1)
    {
        return '<p>' . $argument1 . '</p>';
    }
}
