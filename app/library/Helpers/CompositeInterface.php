<?php

namespace WBDB\Helpers;

interface CompositeInterface
{

    public function merge();

    public function with($element);
}
