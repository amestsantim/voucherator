<?php
namespace AmestSantim\Voucherator;

class VoucherTransformer
{
    public static function capitalizeFirstCharacter($vouchers)
    {
        if (is_array($vouchers)) {
            return array_map(function ($item) {
                return ucfirst($item);
            }, $vouchers);
        }
        return $vouchers;
    }

    public static function addSeparator($vouchers, $chunkSize, $separator)
    {
        if (is_array($vouchers)) {
            return array_map(function ($item) use ($chunkSize, $separator) {
                // $separator can only be a single character. Enforce that limit!
                $separator = (string)$separator;
                $separator = $separator[0];
                return rtrim(chunk_split($item, $chunkSize, $separator), $separator);
            }, $vouchers);
        }
        return $vouchers;
    }

    public static function addPrefix($vouchers, $prefix)
    {
        if (is_array($vouchers)) {
            return array_map(function ($item) use ($prefix) {
                return $prefix . $item;
            }, $vouchers);
        }
        return $vouchers;
    }
}