<?php

namespace PHPAlchemist\Traits;

/**
 * @deprecated  Will be removed in v4.0.0
 */
trait PerformanceTrait
{
    const int ONE_KILOBYTE_IN_BYTES = 1024;
    const int ONE_MEGABYTE_IN_BYTES = 1048576;

    /**
     * get the performance data (Peak Memory Usage) for a given script or
     * class.
     *
     * @return string
     */
    public function getPerformance() : string
    {
        $memUsage = memory_get_peak_usage();
        if ($memUsage < self::ONE_KILOBYTE_IN_BYTES) {
            // These two are ignored as the nature of phpUnit testing will not allow me to come in under a meg
            // and run coverage
            // @codeCoverageIgnoreStart
            $displayData = $memUsage.' bytes';
        } elseif ($memUsage < self::ONE_MEGABYTE_IN_BYTES) {
            $displayData = round($memUsage / self::ONE_KILOBYTE_IN_BYTES, 2).' kilobytes';
            // @codeCoverageIgnoreEnd
        } else {
            $displayData = round($memUsage / self::ONE_MEGABYTE_IN_BYTES, 2).' megabytes';
        }

        return $displayData;
    }
}
