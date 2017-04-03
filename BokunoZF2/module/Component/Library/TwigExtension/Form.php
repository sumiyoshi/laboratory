<?php

namespace Component\Library\TwigExtension;

class Form extends \Twig_Extension
{
    protected $datas;

    protected $errors;

    protected $error_config;

    public function getName()
    {
        return 'form';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('form_start', array($this, 'start'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_end', array($this, 'end'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_default_value', array($this, 'default_value')),
            new \Twig_SimpleFunction('form_errors', array($this, 'set_errors')),
            new \Twig_SimpleFunction('form_hidden', array($this, 'hidden'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_text', array($this, 'text'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_password', array($this, 'password'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_checkbox', array($this, 'checkbox'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_select', array($this, 'select'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_textarea', array($this, 'textarea'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_file', array($this, 'file'), array('is_safe' => array('html'))),
        );
    }

    public function start($method = "GET", $action = "", $attributes = array())
    {
        $method = strtoupper($method);

        # if ($method == 'PUT' || $method = 'DELETE') {
        #     $additional = $this->input('hidden', 'REQUEST_METHOD', array('value' => $method));
        #     $method     = 'POST';
        # } else {
        #     $additional = '';
        # }

        $attributes['method'] = $method;
        $attributes['action'] = $action;

        $attributes = $this->toStringAttributes($attributes);

        $html = "<form {$attributes}>";

        # $html .= $additional;

        return $html;
    }

    public function end()
    {
        return '</form>';
    }


    /**
     * @param array $datas
     */
    public function default_value($datas)
    {
        $this->datas = $datas;
    }

    public function set_errors($errors, $configs = array())
    {
        $this->errors = $errors;

        $this->error_config = $configs + array('class' => 'input-error');
    }

    /**
     * @param string $name
     * @param array $attributes
     *
     * @return string
     */
    public function hidden($name, $attributes = array())
    {
        return $this->input('hidden', $name, $attributes);
    }

    /**
     * @param string $name
     * @param array $attributes
     *
     * @return string
     */
    public function text($name, $attributes = array())
    {
        return $this->input('text', $name, $attributes);
    }

    /**
     * @param string $name
     * @param array $attributes
     *
     * @return string
     */
    public function password($name, $attributes = array())
    {
        return $this->input('password', $name, $attributes);
    }

    /**
     * @param string $name
     * @param array $attributes
     *
     * @return string
     */
    public function file($name, $attributes = array())
    {
        return $this->input('file', $name, $attributes);
    }

    /**
     * @param string $type
     * @param string $name
     * @param array $attributes
     *
     * @return string
     */
    protected function input($type, $name, $attributes = array())
    {
        $attributes['name'] = $name;
        $attributes['type'] = $type;

        if (isset($this->datas[$name])) {
            $attributes['value'] = $this->datas[$name];
        }

        if (isset($this->errors[$name])) {
            if (!isset($attributes['class'])) {
                $attributes['class'] = '';
            }
            $attributes['class'] .= ' ' . $this->error_config['class'];
        }

        $attributes = $this->toStringAttributes($attributes);


        $html = "<input {$attributes}>";

        if (isset($this->errors[$name])) {
            $html .= "<span class='error'>";
            $html .= implode('<br>', $this->errors[$name]);
            $html .= "</span>";
        }

        return $html;
    }

    /**
     * チェックボックスが一個の時
     *
     * $values に [true=>1, false=>0] とやるとチェックしなくても必ず $name のパラメータがわたる
     * $values がスカラ値だったらチェックした時しか渡らない
     *
     * @param string $name
     * @param string|int|array $values
     * @param array $attributes
     *
     * @return string
     */
    public function checkbox($name, $values, $attributes = array())
    {
        $html = '';

        if (is_array($values)) {
            $true_value = $values['true'];
            $false_value = $values['false'];
            $html .= "<input name=\"$name\" type=\"hidden\" value=\"{$false_value}\">";
        } else {
            $true_value = $values;
        }

        $attributes['name'] = $name;
        $attributes['type'] = 'checkbox';
        $attributes['value'] = $true_value;

        if (isset($this->errors[$name])) {
            if (!isset($attributes['class'])) {
                $attributes['class'] = '';
            }
            $attributes['class'] .= ' ' . $this->error_config['class'];
        }

        $attributes = $this->toStringAttributes($attributes);


        if (isset($this->datas[$name]) && $this->datas[$name] == $true_value) {
            $ckecked = " checked";
        } else {
            $ckecked = "";
        }

        $html .= "<input {$attributes}{$ckecked}>";

        if (isset($this->errors[$name])) {
            $html .= "<span class='error'>";
            $html .= implode('<br>', $this->errors[$name]);
            $html .= "</span>";
        }

        return $html;
    }

    /**
     * @param string $name
     * @param array $options
     * @param array $attributes
     * @param string|null $empty
     *
     * @return string
     */
    public function select($name, $options, $attributes = array(), $empty = null, $alias = null)
    {
        $attributes['name'] = $name;

        if ($alias) {
            $selected_value = (isset($this->datas[$alias])) ? (string)$this->datas[$alias] : null;
        } else {
            $selected_value = (isset($this->datas[$name])) ? (string)$this->datas[$name] : null;
        }


        if (isset($this->errors[$name])) {
            if (!isset($attributes['class'])) {
                $attributes['class'] = '';
            }
            $attributes['class'] .= ' ' . $this->error_config['class'];
        }

        $attributes = $this->toStringAttributes($attributes);

        $html = "<select {$attributes}>";

        if (!is_array($options)) {
            $options = array();
        }

        if (!is_null($empty)) {
            $options = array('' => $empty) + $options;
        }

        foreach ($options as $value => $label) {
            $value = htmlspecialchars($value, ENT_QUOTES);
            $label = htmlspecialchars($label, ENT_QUOTES);
            $selected = ($selected_value === (string)$value) ? ' selected' : '';
            $html .= '<option' . $selected . ' value="' . $value . '">' . $label . '</option>';
        }

        $html .= '</select>';

        if (isset($this->errors[$name])) {
            $html .= "<span class='error'>";
            $html .= implode('<br>', $this->errors[$name]);
            $html .= "</span>";
        }

        return $html;
    }

    /**
     * @param string $name
     * @param array $attributes
     *
     * @return string
     */
    public function textarea($name, $attributes = array())
    {
        $attributes['name'] = $name;

        if (isset($this->errors[$name])) {
            if (!isset($attributes['class'])) {
                $attributes['class'] = '';
            }
            $attributes['class'] .= ' ' . $this->error_config['class'];
        }

        $attributes = $this->toStringAttributes($attributes);

        $html = "<textarea {$attributes}>";

        if (isset($this->datas[$name])) {
            $html .= htmlspecialchars($this->datas[$name], ENT_QUOTES);
        }

        $html .= '</textarea>';

        if (isset($this->errors[$name])) {
            $html .= "<span class='error'>";
            $html .= implode('<br>', $this->errors[$name]);
            $html .= "</span>";
        }

        return $html;
    }

    /**
     * @param array $attributes
     *
     * @return string
     */
    protected function toStringAttributes($attributes)
    {
        $attrs = array();
        foreach ($attributes as $key => $value) {
            $value = htmlspecialchars($value, ENT_QUOTES);
            $attrs[] = "{$key}=\"{$value}\"";
        }

        return implode(' ', $attrs);
    }

}