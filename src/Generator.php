<?php

namespace AmestSantim\Voucherator;

interface Generator
{
    public function generate($count);

    public function length($length);

    public function exclude($charsAsString);
}