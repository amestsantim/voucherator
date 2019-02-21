<?php
namespace AmestSantim\Voucherator;

class AlphaNumericGenerator implements Generator
{
    protected $charSet = [];
    protected $length = 8;
    protected $transformations = [];

    public function __construct()
    {
        $this->charSet = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
    }

    public function charSet()
    {
        return $this->charSet;
    }

    public function generate($count = 1)
    {
        $poolSize = count($this->charSet);
        $vouchers = [];
        for ($i = 0; $i < $count; $i++) {
            $generatedString = '';
            while (strlen($generatedString) < $this->length) {
                try {
                    $pickedPosition = random_int(0, $poolSize);
                    $generatedString .= $this->charSet[$pickedPosition];
                    $generatedString = str_shuffle($generatedString);
                } catch (\Exception $e) {
                    // Loop back for another try
                }
            }
            array_push($vouchers, $generatedString);
        }
        $this->transformations = array_reverse($this->transformations);
        while ($transformation = array_pop($this->transformations)) {
            $vouchers = array_map($transformation, $vouchers);
        }
        return $vouchers;
    }

    public function length($length)
    {
        $this->length = $length;
        return $this;
    }

    /*  The following methods (numerals, letters, upperCase, lowerCase, exclude and include) affect the character
        set (charSet)  */

    public function numerals()
    {
        $this->charSet = range(0, 9);
        return $this;
    }

    public function letters()
    {
        $this->charSet = array_merge(range('a', 'z'), range('A', 'Z'));
        return $this;
    }

    public function upperCase()
    {
        $upper = collect($this->charSet)->map(function ($item) {
            return strtoupper($item);
        });
        $this->charSet = $upper->unique()->toArray();
        return $this;
    }

    public function lowerCase()
    {
        $lower = collect($this->charSet)->map(function ($item) {
            return strtolower($item);
        });
        $this->charSet = $lower->unique()->toArray();
        return $this;
    }

    public function exclude($charsAsString)
    {
        $exclusionList = str_split($charsAsString);
        $this->charSet = collect($this->charSet)->reject(function ($item) use ($exclusionList) {
            return in_array($item, $exclusionList);
        })->toArray();
        return $this;
    }

    public function include($charsAsString)
    {
        $inclusionList = str_split($charsAsString);
        $this->charSet = collect($this->charSet)->merge($inclusionList)->unique()->toArray();
        return $this;
    }

    /*  The following three methods (capitalizeFirstCharacter, addSeparator and perfix) will transform the
        vouchers after they have been generated  */

    public function capitalizeFirstCharacter()
    {
        if (!array_key_exists("capitalizeFirstCharacter", $this->transformations)) {
            $this->transformations["capitalizeFirstCharacter"] = function ($item) {
                return ucfirst($item);
            };
        }
        return $this;
    }

    public function addSeparator($chunkSize, $separator)
    {
        if (!array_key_exists("addSeparator", $this->transformations)) {
            $this->transformations["addSeparator"] = function ($item) use ($chunkSize, $separator) {
                return rtrim(chunk_split($item, $chunkSize, $separator), $separator);
            };
        }
        return $this;
    }

    public function prefix($prefix)
    {
        if (!array_key_exists("prefix", $this->transformations)) {
            $this->transformations["prefix"] = function ($item) use ($prefix) {
                return $prefix . $item;
            };
        }
        return $this;
    }
}