<?php declare(strict_types=1);

namespace freetought\Distributions\Tests;

use freetought\Distributions\Weibull;
use PHPUnit\Framework\TestCase;
use SplFixedArray;

class WeibullDistributionTest extends TestCase
{
    public function testWeibullInstantiateDistribution()
    {
        $this->assertIsObject(new Weibull(2.0, 3.1));
    }

    public function testWeibullInvalidInstantiation()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Weibull(0, 1);
    }

    public function testWeibullInvalidInstantiation2()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Weibull(1, 0);
    }

    public function testWeibullInvalidInstantiation3()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Weibull(1, -1);
    }

    public function testWeibullInvalidInstantiation4()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Weibull(-1, 1);
    }

    public function testWeibullInvalidInstantiation5()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Weibull("a", 2);
    }

    public function testObjectDraw()
    {
        mt_srand(1);

        $d = new Weibull(3.2, 1.4);

        $scale = 5000;
        $cutoff = 0.9;
        $counter = 0;

        $draws = new SplFixedArray($scale);
        for ($i = 0; $i < $scale; $i++) {
            $x = $d->rand();
            $draws[$i] = $x;

            if ($x > $cutoff) $counter = $counter + 1;
        }


        // These perform differently on PHP <= 7.0. I think the RNG changed: As of PHP 7.1.0, rand() uses the same random number generator as mt_rand(). To preserve backwards compatibility rand() allows max to be smaller than min as opposed to returning FALSE as mt_rand().
        $number = array_sum((array)$draws) / count($draws);
        $mean = $d->mean();
        $this->assertEqualsWithDelta($number, $mean, 0.015, "Attempting to draw from Weibull(3.2, 1.4)) {$scale} times gives us a value too far from the expected mean. This could be just random chance.");

        $p = $counter / $scale;
        $this->assertEqualsWithDelta($p, 1 - $d->cdf($cutoff), 0.015, "Attempting to draw from  Weibull(3.2, 1.4))  {$scale} times gives the wrong number of values greater than {$cutoff}. This could be just random chance.");
    }

    public function testWeibullPDF()
    {
        $accuracy = 1e-10;

        $d = new Weibull(3.2, 1.4);

        $this->assertEqualsWithDelta(0, $d->pdf(-0.5), $accuracy, "PDF incorrect");
        $this->assertEqualsWithDelta(0, $d->pdf(0), $accuracy, "PDF incorrect");
        $this->assertEqualsWithDelta(0.228650585918, $d->pdf(0.5), $accuracy, "PDF incorrect");
        $this->assertEqualsWithDelta(0.775478835655, $d->pdf(1.0), $accuracy, "PDF incorrect");
        $this->assertEqualsWithDelta(0.764462234801, $d->pdf(1.5), $accuracy, "PDF incorrect");
        $this->assertEqualsWithDelta(0.218786337871, $d->pdf(2.0), $accuracy, "PDF incorrect");
        $this->assertEqualsWithDelta(0.0136761908489, $d->pdf(2.5), $accuracy, "PDF incorrect");

        $d = new Weibull(0.2, 3.0);

        $this->assertEqualsWithDelta(0, $d->pdf(-0.5), $accuracy, "PDF incorrect");
        $this->assertEqualsWithDelta(INF, $d->pdf(0), $accuracy, "PDF incorrect");
        $this->assertEqualsWithDelta(0.138973815055, $d->pdf(0.5), $accuracy, "PDF incorrect");
        $this->assertEqualsWithDelta(0.0719415041934, $d->pdf(1.0), $accuracy, "PDF incorrect");
        $this->assertEqualsWithDelta(0.0486023682443, $d->pdf(1.5), $accuracy, "PDF incorrect");
        $this->assertEqualsWithDelta(0.0366703766322, $d->pdf(2.0), $accuracy, "PDF incorrect");
        $this->assertEqualsWithDelta(0.0294110313310, $d->pdf(2.5), $accuracy, "PDF incorrect");
    }


    public function testWeibullCDF()
    {
        $accuracy = 1e-10;

        $d = new Weibull(3.2, 1.4);

        $this->assertEqualsWithDelta(0, $d->cdf(-0.5), $accuracy, "CDF incorrect");
        $this->assertEqualsWithDelta(0, $d->cdf(0), $accuracy, "CDF incorrect");
        $this->assertEqualsWithDelta(0.0363972185799547, $d->cdf(0.5), $accuracy, "CDF incorrect");
        $this->assertEqualsWithDelta(0.288737870976856, $d->cdf(1.0), $accuracy, "CDF incorrect");
        $this->assertEqualsWithDelta(0.712647485622632, $d->cdf(1.5), $accuracy, "CDF incorrect");
        $this->assertEqualsWithDelta(0.956326907614828, $d->cdf(2.0), $accuracy, "CDF incorrect");
        $this->assertEqualsWithDelta(0.998329075336515, $d->cdf(2.5), $accuracy, "CDF incorrect");

        $d = new Weibull(0.2, 3.0);

        $this->assertEqualsWithDelta(0, $d->cdf(-0.5), $accuracy, "CDF incorrect");
        $this->assertEqualsWithDelta(0, $d->cdf(0), $accuracy, "CDF incorrect");
        $this->assertEqualsWithDelta(0.502831918930007, $d->cdf(0.5), $accuracy, "CDF incorrect");
        $this->assertEqualsWithDelta(0.551901211916264, $d->cdf(1.0), $accuracy, "CDF incorrect");
        $this->assertEqualsWithDelta(0.581279046613598, $d->cdf(1.5), $accuracy, "CDF incorrect");
        $this->assertEqualsWithDelta(0.602320117031642, $d->cdf(2.0), $accuracy, "CDF incorrect");
        $this->assertEqualsWithDelta(0.618709033608360, $d->cdf(2.5), $accuracy, "CDF incorrect");
    }


    public function testWeibullMean()
    {
        $accuracy = 1e-10;

        $d = new Weibull(3.2, 1.4);
        $this->assertEqualsWithDelta(1.253915138, $d->mean(), $accuracy, "Mean incorrect");

        $d = new Weibull(0.2, 3.0);
        $this->assertEqualsWithDelta(360, $d->mean(), $accuracy, "Mean incorrect");
    }

    public function testWeibullVariance()
    {
        $accuracy = 1e-10;

        $d = new Weibull(3.2, 1.4);
        $this->assertEqualsWithDelta(0.1849824157, $d->variance(), $accuracy, "Variance incorrect");

        $d = new Weibull(0.2, 3.0);
        $this->assertEqualsWithDelta(3.25296000000e7, $d->variance(), 1e-6, "Variance incorrect");
        $this->assertEqualsWithDelta(sqrt(3.25296000000e7), $d->sd(), 1e-6, "Variance incorrect");


    }

    public function testWeibullCDFICDF()
    {
        $accuracy = 1e-8;

        for ($i = 0; $i < 100; $i++) {
            $k = 3 * mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
            $lambda = 4 * mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
            $d = new Weibull($k, $lambda);
            $p = mt_rand() / mt_getrandmax();
            $this->assertEqualsWithDelta($p, $d->cdf($d->icdf($p)), $accuracy, "CDF and inverse CDF mismatch");
        }
    }
}
