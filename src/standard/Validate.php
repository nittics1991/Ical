<?php

/**
*   Validate
*
*   @version 191023
*/

declare(strict_types=1);

namespace Concerto\standard;

use DateTime;
use Concerto\mbstring\MbString;
use Concerto\standard\ArrayUtil;

final class Validate
{
    /**
    *   ASCII文字
    *
    *   @param mixed $val
    *   @param ?int $min_length 最短文字数
    *   @param ?int $max_length 最長文字数
    *   @return bool
    */
    public static function isAscii(
        $val,
        ?int $min_length = null,
        ?int $max_length = null
    ): bool {
        if (
            !is_string($val)
            || !mb_check_encoding($val)
            || !mb_ereg_match('\A[\x21-\x7e]+\z', $val)
        ) {
            return false;
        }
        
        if (isset($min_length) && mb_strlen($val) < $min_length) {
            return false;
        }
        
        if (isset($max_length) && mb_strlen($val) > $max_length) {
            return false;
        }
        return true;
    }
    
    /**
    *   部門コード
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isBumon($val): bool
    {
        return Validate::isText($val, 5, 6);
    }
    
    /**
    *   システムコード
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isCdSystem($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\Aitc_work[1-6]\z', $val);
    }
    
    /**
    *   16進RGB
    *
    *   @param mixed $val
    *   @return bool
    **/
    public function isColor($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A#[0-9A-Fa-f]{6}\z', $val);
    }
    
    /**
    *   注番
    *
    *   @param mixed $val 判定値
    *   @return bool
    */
    public static function isCyuban($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A([A-Z,0-9]{7,8})\z', $val);
    }
    
    /**
    *   注文番号
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isCyumon($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match(
                '\A(K|G|J)[A-Z,0-9]{3}[0-9]{5}((\-)([0-9]{2}))*\z',
                $val
            );
    }
     
    /**
    *   ファイルシステム
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isFilename($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && !mb_ereg_match('.*[\x00-\x1f/\\\\<>\*\?"|:;]+', $val)
            && mb_strlen($val) <= 107;
    }
    
    /**
    *   浮動小数
    *
    *   @param mixed $val
    *   @param ?float $min 最小値
    *   @param ?float $max 最大値
    *   @return bool
    */
    public static function isDouble(
        $val,
        ?float $min = null,
        ?float $max = null
    ): bool {
        return self::isFloat($val, $min, $max);
    }
    
    /**
    *   Email
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isEmail($val): bool
    {
        if (
            !is_string($val)
            || !mb_check_encoding($val)
            || !filter_var($val, FILTER_VALIDATE_EMAIL)
        ) {
            return false;
        }
        
        $lower = strtolower($val);
        return mb_ereg_match(
            '\A[0-9a-z\.]+@(glb\.)?toshiba\.co\.jp\z',
            $lower
        );
    }
    
    /**
    *   Email TEXT(;区切り)
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isEmailText($val): bool
    {
        $ans = true;
        $array = explode(';', $val);
        foreach ($array as $adr) {
            if (
                !is_string($val)
                || !mb_check_encoding($adr)
                || !filter_var($adr, FILTER_VALIDATE_EMAIL)
            ) {
                $ans = false;
            }
        }
        return $ans;
    }
    
    /**
    *   浮動小数
    *
    *   @param mixed $val
    *   @param ?float $min 最小値
    *   @param ?float $max 最大値
    *   @return bool
    */
    public static function isFloat(
        $val,
        ?float $min = null,
        ?float $max = null
    ): bool {
        $ans = true;
        if (!is_float($val)) {
            return false;
        }
        
        if (isset($min) && $val < $min) {
            return false;
        }
        
        if (isset($max) && $val > $max) {
            return false;
        }
        return $ans;
    }
    
    /**
    *   原価要素
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isGenkaYoso($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A([A-D])\z', $val);
    }
    
    /**
    *   整数
    *
    *   @param mixed $val
    *   @param ?int $min 最小値
    *   @param ?int $max 最大値
    *   @return bool
    */
    public static function isInt(
        $val,
        ?int $min = null,
        ?int $max = null
    ): bool {
        if (!is_int($val)) {
            return false;
        }
        
        if (isset($min) && $val < $min) {
            return false;
        }
        
        if (isset($max) && $val > $max) {
            return false;
        }
        return true;
    }
    
    /**
    *   IPv4
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isIpv4($val): bool
    {
        return filter_var($val, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)
            === $val;
    }
    
    /**
    *   IPv6
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isIpv6($val): bool
    {
        return filter_var($val, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)
            === $val;
    }
    
    /**
    *   項番
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isKoban($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A([A-Z,0-9]{4,5})\z', $val);
    }
    
    /**
    *   見積番号(ID)
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isMitumori($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A\d{8}\z', $val);
    }
    
    /**
    *   見積番号(CODE+NO)
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isMitumoriNo($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A[A-Z0-9]{2,3}-[0-9]{4,6}\z', $val);
    }
    
    /**
    *   金額(+/- カンマ区切り 小数許可)
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isMoney($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A[+-]?\d{1,3}(\d|,\d{3})*(\.\d+)?\z', $val);
    }
    
    /**
    *   年度コード
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isNendo($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A\d{4}(K|S)\z', $val);
    }
    
    /**
    *   郵便番号
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isPostAdr($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A\d{3}-\d{4}\z', $val);
    }
    
    /**
    *   社員番号
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isTanto($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A\d{5}ITC\z', $val);
    }
    
    /**
    *   TEL番号
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isTel($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A\d{2,4}-\d{2,4}-\d{4}\z', $val);
    }
    
    /**
    *   文字列
    *
    *   @param mixed $val
    *   @param ?int $min_length 最短文字数
    *   @param ?int $max_length 最長文字数
    *   @return bool
    */
    public static function isText(
        $val,
        ?int $min_length = null,
        ?int $max_length = null
    ): bool {
        $ans = true;
        if (
            !is_string($val)
            || !mb_check_encoding($val)
            || !is_string($val)
        ) {
            return false;
        }
        
        if (
            isset($min_length)
            && mb_strlen(mb_convert_kana($val, 'KV')) < $min_length
        ) {
            return false;
        }
        
        if (
            isset($max_length)
            && mb_strlen(mb_convert_kana($val, 'KV')) > $max_length
        ) {
            return false;
        }
        return true;
    }
    
    /**
    *   文字列エスケープ
    *
    *   @param mixed $val
    *   @param ?int $min_length 最短文字数
    *   @param ?int $max_length 最長文字数
    *   @param ?string $accept 許可記号文字列
    *   @param ?string $refuse 不許可記号文字列
    *   @return bool
    *   @example    ($accept != null) => base Deny
    *               ($accept == null)&&($refuse != null) => base Allow
    *
    *               英数漢字許可 記号不許可          Validate::isTextEscape($data, [null, null, ''])
    *               英数漢字許可 記号不許可 指定許可 Validate::isTextEscape($data, [null, null, '@'])
    *               英数漢字許可 記号許可             Validate::isTextEscape($data, null, null, null, '')
    *               英数漢字許可 記号許可 指定不許可 Validate::isTextEscape($data, null, null, null, '@')
    */
    public static function isTextEscape(
        $val,
        ?int $min_length = null,
        ?int $max_length = null,
        ?string $accept = null,
        ?string $refuse = null
    ): bool {
        $reg = '0-9A-Za-z\x80-\xff';
        $symbols = array_merge(
            range(0x20, 0x2f, 1),
            range(0x3a, 0x40, 1),
            range(0x5b, 0x60, 1),
            range(0x7b, 0x7e, 1),
            array(0x09, 0x0a, 0x0d)
        );  //36 symbols
        
        if (!is_null($accept)) {
            $reg .= $accept;
        } elseif (!is_null($refuse)) {
            $escape = false;
            $deny = [];
            
            foreach ((array)MbString::split($refuse) as $c) {
                if ($escape) {
                    switch ($c) {
                        case 'r':
                            $deny[] = ord("\r");
                            break;
                        case 'n':
                            $deny[] = ord("\n");
                            break;
                        case 't':
                            $deny[] = ord("\t");
                            break;
                    }
                    $escape = false;
                } elseif ($c == '\\') {
                    $escape = true;
                } else {
                    $deny[] = ord($c);
                }
            }
            
            $allow = (!empty($deny)) ?
                ArrayUtil::without($symbols, $deny, false) : $symbols;
            
            $add_symbol = array_map(
                function ($val) {
                    return sprintf("\\x%02x", $val);
                },
                $allow
            );
            
            $reg .= implode('', $add_symbol);
        }
        
        if (
            is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A[' . $reg . ']*\z', $val)
        ) {
            return static::isText($val, $min_length, $max_length);
        }
        return false;
    }
    
    /**
    *   文字列フラグ
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isTextBool($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A(0|1)\z', $val);
    }
    
    /**
    *   日付文字列yyyymmdd
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isTextDate($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A\d{8}\z', $val)
            && checkdate(
                (int)mb_substr($val, 4, 2),
                (int)mb_substr($val, 6, 2),
                (int)mb_substr($val, 0, 4)
            )
            && (new DateTime(mb_substr($val, 0, 8)))->format('Ymd')
                == mb_substr($val, 0, 8);
    }
    
    /**
    *   日付文字列yyyymmdd HHiiss
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isTextDateTime($val): bool
    {
        $checkTime = function ($val) {
            $unix_time = mktime(
                (int)substr($val, 9, 2),
                (int)mb_substr($val, 11, 2),
                (int)mb_substr($val, 13, 2)
            );
            
            if ($unix_time === false) {
                return false;
            }
            return date('His', $unix_time) == substr($val, 9, 6);
        };
        
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A\d{8} \d{6}\z', $val)
            && checkdate(
                (int)mb_substr($val, 4, 2),
                (int)mb_substr($val, 6, 2),
                (int)mb_substr($val, 0, 4)
            )
            && (new DateTime(mb_substr($val, 0, 8)))->format('Ymd')
                == mb_substr($val, 0, 8)
            && $checkTime($val);
    }
    
    /**
    *   日付文字列yyyymm
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isTextDateYYYYMM($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A\d{6}\z', $val)
            && checkdate(
                (int)mb_substr($val, 4, 2),
                1,
                (int)mb_substr($val, 0, 4)
            )
            && (new DateTime(mb_substr($val, 0, 6) . '01'))->format('Ym')
                == mb_substr($val, 0, 6);
    }
    
    /**
    *   日付文字列yyyy-mm-dd
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isTextDateYYYYMMDDHyphen($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A\d{4}-\d{2}-\d{2}\z', $val)
            && checkdate(
                (int)mb_substr($val, 5, 2),
                (int)mb_substr($val, 8, 2),
                (int)mb_substr($val, 0, 4)
            )
            && (new DateTime(mb_substr($val, 0, 10)))->format('Y-m-d')
                == mb_substr($val, 0, 10);
    }
    
    /**
    *   時刻文字列hhiiss
    *
    *   @param mixed  $val
    *   @return bool
    */
    public static function isTextTime($val): bool
    {
        $chekcTime = function ($val) {
            $hh = (int)mb_substr($val, 0, 2);
            $ii = (int)mb_substr($val, 2, 2);
            $ss = (int)mb_substr($val, 4, 2);
            
            return $hh >= 0
                && $hh <= 23
                && $ii >= 00
                && $ii <= 59
                && $ss >= 00
                && $ss <= 59;
        };
        
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A\d{6}\z', $val)
            && $chekcTime($val);
    }
    
    /**
    *   時刻文字列hhii
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isTextTimeHHII($val): bool
    {
        $chekcTime = function ($val) {
            $hh = (int)mb_substr($val, 0, 2);
            $ii = (int)mb_substr($val, 2, 2);
            
            return $hh >= 0
                && $hh <= 23
                && $ii >= 00
                && $ii <= 59;
        };
        
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A\d{4}\z', $val)
            && $chekcTime($val);
    }
    
    /**
    *   文字列浮動小数
    *
    *   @param mixed $val
    *   @param ?float $min 最小値
    *   @param ?float $max 最大値
    *   @return bool
    */
    public static function isTextFloat(
        $val,
        ?float $min = null,
        ?float $max = null
    ): bool {
        $ans = true;
        if (
            !is_string($val)
            || !mb_check_encoding($val)
            || !mb_ereg_match('\A[+,-]?[0-9]*\.[0-9]*\z', $val)
        ) {
            return false;
        }
        
        if (isset($min) && (float)$val < $min) {
            return false;
        }
        
        if (isset($max) && (float)$val > $max) {
            return false;
        }
        return true;
    }
    
    /**
    *   文字列整数
    *
    *   @param mixed $val
    *   @param ?int $min 最小値
    *   @param ?int $max 最大値
    *   @return bool
    */
    public static function isTextInt(
        $val,
        ?int $min = null,
        ?int $max = null
    ): bool {
        $ans = true;
        if (
            !is_string($val)
            || !mb_check_encoding($val)
            || !mb_ereg_match('\A[+,-]?[0-9]*\z', $val)
        ) {
            return false;
        }
        
        if (isset($min) && (int)$val < $min) {
            return false;
        }
        
        if (isset($max) && (int)$val > $max) {
            return false;
        }
        return true;
    }
    
    /**
    *   文字列ひらがな
    *
    *   @param mixed $val
    *   @param ?int $min_length 最短文字数
    *   @param ?int $max_length 最長文字数
    *   @return bool
    */
    public static function isTextHiragana(
        $val,
        ?int $min_length = null,
        ?int $max_length = null
    ): bool {
        $ans = true;
        if (
            !is_string($val)
            || !mb_check_encoding($val)
            || !mb_ereg_match('\A[ぁ-ん]*\z', $val)
        ) {
            return false;
        }
        
        if (isset($min_length) && mb_strlen($val) < $min_length) {
            return false;
        }
        
        if (isset($max_length) && mb_strlen($val) > $max_length) {
            return false;
        }
        return true;
    }
    
    /**
    *   文字列カタカナ
    *
    *   @param mixed $val
    *   @param ?int $min_length 最短文字数
    *   @param ?int $max_length 最長文字数
    *   @return bool
    */
    public static function isTextKatakana(
        $val,
        ?int $min_length = null,
        ?int $max_length = null
    ): bool {
        $ans = true;
        if (
            !is_string($val)
            || !mb_check_encoding($val)
            || !mb_ereg_match('\A[ァ-ヶ]*\z', $val)
        ) {
            return false;
        }
        
        if (isset($min_length) && mb_strlen($val) < $min_length) {
            return false;
        }
        
        if (isset($max_length) && mb_strlen($val) > $max_length) {
            return false;
        }
        return true;
    }
    
    /**
    *   文字列半角カタカナ
    *
    *   @param mixed $val
    *   @param ?int $min_length 最短文字数
    *   @param ?int $max_length 最長文字数
    *   @return bool
    */
    public static function isTextHankaku(
        $val,
        ?int $min_length = null,
        ?int $max_length = null
    ): bool {
        $ans = true;
        if (
            !is_string($val)
            || !mb_check_encoding($val)
            || !mb_ereg_match('\A[｡-ﾟ]*\z', $val)
        ) {
            return false;
        }
        
        if (
            isset($min_length)
            && mb_strlen(mb_convert_kana($val, 'KV')) < $min_length
        ) {
            return false;
        }
        
        if (
            isset($max_length)
            && mb_strlen(mb_convert_kana($val, 'KV')) > $max_length
        ) {
            return false;
        }
        return true;
    }
    
    /**
    *   統一ユーザID
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isUser($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('\A[0-9,A-Z,a-z]{8}\z', $val);
    }
    
    /**
    *   URL
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function isUrl($val): bool
    {
        return filter_var($val, FILTER_VALIDATE_URL)
            && mb_ereg_match('\Ahttps?://.+', $val);
    }
    
    /**
    *   存在 DBリスキー文字
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function hasTextDatabase($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('.*[%_\'\"]', $val);
    }
    
    /**
    *   存在 文字列半角カタカナ
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function hasTextHankaku($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('.*[｡-ﾟ]', $val);
    }
    
    /**
    *   存在 HTMLリスキー文字
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function hasTextHtml($val): bool
    {
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('.*[<>&\"\']', $val);
    }
    
    /**
    *   存在 文字列記号
    *
    *   @param mixed $val
    *   @return bool
    */
    public static function hasTextSymbole($val): bool
    {
        $symbols = array_merge(
            range(0x20, 0x2f, 1),
            range(0x3a, 0x40, 1),
            range(0x5b, 0x60, 1),
            range(0x7b, 0x7e, 1)
        );
        
        $add_symbol = array_map(
            function ($val) {
                return sprintf("\\x%02x", $val);
            },
            $symbols
        );
        
        $reg = implode('', $add_symbol);
        
        return is_string($val)
            && mb_check_encoding($val)
            && mb_ereg_match('.*[' . $reg . ']', $val);
    }
}
