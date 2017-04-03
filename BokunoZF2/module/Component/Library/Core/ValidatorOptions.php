<?php

namespace Component\Library\Core;

use Zend\Validator\Callback;
use Zend\Validator\EmailAddress;
use Zend\Validator\InArray;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\Validator\Digits;
use Zend\Validator\Regex;
use Zend\Validator\Date;

/**
 * Class ValidatorOptions
 *
 * @package Component\Library\Core
 */
class ValidatorOptions
{

    /**
     * 必須チェック
     *
     * @return array
     */
    public static function notEmpty()
    {
        return array(
            'name' => 'NotEmpty',
            'options' => array(
                'messages' => array(
                    NotEmpty::IS_EMPTY => "入力してください",
                    NotEmpty::INVALID => "形式が無効です",
                )
            )
        );
    }

    /**
     * 文字数チェック
     *
     * @param $max
     * @return array
     */
    public static function stringLength($max)
    {
        return array(
            'name' => 'StringLength',
            'break_chain_on_failure' => true,
            'options' => array(
                'encoding' => 'UTF-8',
                'max' => $max,
                'messages' => array(
                    StringLength::INVALID => "形式が無効です",
                    StringLength::TOO_LONG => "%max%文字以下で入力してください",
                )
            )
        );
    }

    /**
     * 文字数チェック最小
     *
     * @param $min
     * @return array
     */
    public static function stringLengthMin($min)
    {
        return array(
            'name' => 'StringLength',
            'break_chain_on_failure' => true,
            'options' => array(
                'encoding' => 'UTF-8',
                'min' => $min,
                'messages' => array(
                    StringLength::INVALID => "形式が無効です",
                    StringLength::TOO_SHORT => "%min%文字以上で入力してください",
                )
            )
        );
    }

    /**
     * メールアドレスバリデータ
     *
     * @return array
     */
    public static function emailAddress()
    {
        return array(
            'name' => 'EmailAddress',
            'break_chain_on_failure' => true,
            'options' => array(
                'encoding' => 'UTF-8',
                'useDomainCheck' => false,
                'messages' => array(
                    EmailAddress::INVALID_FORMAT => "形式が無効です",
                )
            )
        );
    }

    /**
     * 半角数字のバリデータ
     *
     * @return array バリデータのspec
     */
    public static function digits()
    {
        return array(
            'name' => 'Digits',
            'break_chain_on_failure' => true,
            'options' => array(
                'messages' => array(
                    Digits::NOT_DIGITS => '半角数字のみを入力して下さい',
                )
            )
        );
    }

    /**
     * 時刻のバリデータ
     *
     * @return array バリデータのspec
     */
    public static function time()
    {
        $msg = '時刻を「HH:MM」の形式で入力して下さい';
        return array(
            'name' => 'Regex',
            'break_chain_on_failure' => true,
            'options' => array(
                'pattern' => '/^(([0-1]+[0-9])|(2[0-3])):([0-5]+[0-9])$/',
                'messages' => array(
                    Regex::NOT_MATCH => $msg,
                    Regex::NOT_MATCH => $msg,
                    Regex::ERROROUS => $msg
                )
            )
        );
    }

    /**
     * 全角カナのバリデータ
     *
     * @return array バリデータのspec
     */
    public static function zenKana()
    {
        $msg = '全角カナを入力して下さい';
        return array(
            'name' => 'Regex',
            'break_chain_on_failure' => true,
            'options' => array(
                'pattern' => '/^[ァ-ヾ]+$/u',
                'messages' => array(
                    Regex::INVALID => $msg,
                    Regex::NOT_MATCH => $msg,
                    Regex::ERROROUS => $msg
                )
            )
        );
    }

    /**
     * 全角カナのバリデータ
     *
     * @return array バリデータのspec
     */
    public static function uri()
    {
        $msg = '形式が無効です';
        return array(
            'name' => 'Regex',
            'break_chain_on_failure' => true,
            'options' => array(
                'pattern' => '/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/',
                'messages' => array(
                    Regex::INVALID => $msg,
                    Regex::NOT_MATCH => $msg,
                    Regex::ERROROUS => $msg
                )
            )
        );
    }

    /**
     * 半角英数字・記号
     *
     * @return array
     */
    public static function alphanumeric()
    {
        $msg = '半角英数字で入力して下さい';
        return array(
            'name' => 'Regex',
            'break_chain_on_failure' => true,
            'options' => array(
                'pattern' => '/^[[:graph:]|[:space:]]+$/i',
                'messages' => array(
                    Regex::INVALID => $msg,
                    Regex::NOT_MATCH => $msg,
                    Regex::ERROROUS => $msg
                )
            )
        );
    }

    /**
     * 日付のバリデータ
     *
     * @return array バリデータのspec
     */
    public static function date($format = 'Y/m/d')
    {
        $msg = '日付を'.$format.'の形式で入力して下さい';
        return array(
            'name' => 'Date',
            'break_chain_on_failure' => true,
            'options' => array(
                'format' => $format,
                'messages' => array(
                    Date::INVALID => $msg,
                    Date::INVALID_DATE => $msg,
                    Date::FALSEFORMAT => $msg,
                )
            )
        );
    }

    /**
     * 配列データとチェック
     *
     * @param array $haystack
     * @return array
     */
    public static function inArray(array $haystack)
    {
        return array(
            'name' => 'InArray',
            'break_chain_on_failure' => true,
            'options' => array(
                'haystack' => $haystack,
                'messages' => array(
                    InArray::NOT_IN_ARRAY => 'パラメータが不正です',
                )
            )
        );
    }

    /**
     * 正規表現
     *
     * @param $pattern
     * @return array
     */
    public static function regex($pattern, $message)
    {
        return array(
            'name' => 'Regex',
            'break_chain_on_failure' => true,
            'options' => array(
                'pattern' => $pattern,
                'messages' => array(
                    Regex::INVALID => $message,
                    Regex::NOT_MATCH => $message,
                    Regex::ERROROUS => $message
                )
            )
        );
    }

    /**
     * コールバック
     *
     * @param $func
     * @param $message
     * @return array
     */
    public static function callback($func, $message)
    {
        return array(
            'name' => 'Callback',
            'break_chain_on_failure' => true,
            'options' => array(
                'encoding' => 'UTF-8',
                'callback' => $func,
                'messages' => array(
                    Callback::INVALID_VALUE => $message,
                    Callback::INVALID_VALUE => $message,
                )
            )
        );
    }
}