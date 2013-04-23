<?php

namespace Retry;

class Retry
{
    private $closure;

    public function __construct($closure)
    {
        $this->closure = $closure;
    }

    public function run($n)
    {
        $exception = null;

        while ($n--) {
            try {
                $closure = $this->closure;

                return $closure();
            } catch (\Exception $e) {
                $exception = $e;
            }
        }

        if ($exception) {
            throw new Exception('Max attempt reached.', 0, $exception);
        }
    }
}
