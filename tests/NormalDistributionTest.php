<?php declare(strict_types=1);

namespace freetought\Distributions\Tests;

use freetought\Distributions\Normal;
use PHPUnit\Framework\TestCase;
use SplFixedArray;

class NormalDistributionTest extends TestCase
{
    public function testNormalInstantiateDistribution(): void
    {
        $this->assertIsObject(new Normal(0, 2.0));
        $this->assertIsObject(new Normal(-3, 1.0));
    }

    public function testNormalInvalidInstantiation()
    {
        $this->expectException(\InvalidArgumentException::class);
        $invalid = new Normal(0, -2.0);
    }

    public function testNormalInvalidInstantiation2()
    {
        $this->expectException(\InvalidArgumentException::class);
        $invalid = new Normal(1, 0);
    }

    public function testObjectDraw()
    {
        mt_srand(1);

        $d = new Normal();

        $scale = 50000;
        $cutoff = 0.4;
        $counter = 0;

        $draws = new SplFixedArray($scale);
        for ($i = 0; $i < $scale; $i++) {
            $x = $d->rand();
            $draws[$i] = $x;

            if ($x > $cutoff) {
                $counter = $counter + 1;
            }
        }

        $number = array_sum((array)$draws) / count($draws);
        $this->assertEqualsWithDelta(0, $number, 0.01, "Attempting to draw from N(0,1) {$scale} times gives us a value too far from the expected mean. This could be just random chance.");

        $p = $counter / $scale;
        $this->assertEqualsWithDelta(1 - $d->cdf($cutoff), $p, 0.01, "Attempting to draw from N(0,1) {$scale} times gives the wrong number of values greater than {$cutoff}. This could be just random chance.");
    }

    public function testClassDraw()
    {
        mt_srand(1);

        $scale = 50000;
        $draws = new SplFixedArray($scale);
        for ($i = 0; $i < $scale; $i++) {
            $draws[$i] = Normal::draw(0, 1);
        }

        $number = array_sum((array)$draws) / count($draws);
        $this->assertEqualsWithDelta(0, $number, 0.01, "Attempting to draw from N(0,1) {$scale} times gives us a value too far from the expected mean. This could be just random chance.");
    }

    public function testNormalPDF()
    {
        $d = new Normal(0, 1);

        $this->assertEqualsWithDelta(0.000001486719514, $d->pdf(-5), 1e-9, "PDF incorrect");
        $this->assertEqualsWithDelta(0.01752830049, $d->pdf(-2.5), 1e-9, "PDF incorrect");
        $this->assertEqualsWithDelta(0.3520653267, $d->pdf(-0.5), 1e-9, "PDF incorrect");
        $this->assertEqualsWithDelta(0.1295175956, $d->pdf(1.5), 1e-9, "PDF incorrect");
        $this->assertEqualsWithDelta(0.0008726826947, $d->pdf(3.5), 1e-9, "PDF incorrect");

        $d = new Normal(0, 0.2);

        $this->assertEqualsWithDelta(6.4119473711506E-28, $d->pdf(-5), 1e-9, "PDF incorrect");
        $this->assertEqualsWithDelta(1.460642012962E-7, $d->pdf(-2.5), 1e-9, "PDF incorrect");
        $this->assertEqualsWithDelta(0.89206205807639, $d->pdf(0), 1e-9, "PDF incorrect");
        $this->assertEqualsWithDelta(0.47748641153356, $d->pdf(-0.5), 1e-9, "PDF incorrect");
        $this->assertEqualsWithDelta(0.0032172781336966, $d->pdf(1.5), 1e-9, "PDF incorrect");
        $this->assertEqualsWithDelta(4.4681378118755E-14, $d->pdf(3.5), 1e-9, "PDF incorrect");
    }

    public function testNormalCDF()
    {
        $d = new Normal(0, 1);

        $this->assertEqualsWithDelta(0.000232629079035525, $d->cdf(-3.5), 1e-7, "CDF incorrect");
        $this->assertEqualsWithDelta(0.0668072012688581, $d->cdf(-1.5), 1e-7, "CDF incorrect");
        $this->assertEqualsWithDelta(0.308537538725987, $d->cdf(-0.5), 1e-7, "CDF incorrect");
        $this->assertEqualsWithDelta(0.691462461274013, $d->cdf(0.5), 1e-7, "CDF incorrect");
        $this->assertEqualsWithDelta(0.933192798731142, $d->cdf(1.5), 1e-7, "CDF incorrect");
        $this->assertEqualsWithDelta(0.999767370920964, $d->cdf(3.5), 1e-7, "CDF incorrect");
        $this->assertEqualsWithDelta(0.99999971346, $d->cdf(5.0), 1e-7, "CDF incorrect");
    }

    public function testNormalICDF()
    {
        $d = new Normal(0, 1);

        $this->assertEqualsWithDelta(-0.841621233572216, $d->icdf(0.2), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta(-0.253347103135800, $d->icdf(0.4), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta(0.524400512708049, $d->icdf(0.7), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta(1.28155156554473, $d->icdf(0.9), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta(1.64485362695213, $d->icdf(0.95), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta(1.95996398453944, $d->icdf(0.975), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta(2.32634787404074, $d->icdf(0.99), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta(3.71901648545454, $d->icdf(0.9999), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta(4.75342430881908, $d->icdf(0.999999), 1e-7, "Inverse CDF incorrect");
    }

    public function testNormalICDFWithNonzeroMean()
    {
        $mu = 0.78135;
        $d = new Normal($mu, 1);

        $this->assertEqualsWithDelta($mu - 0.841621233572216, $d->icdf(0.2), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu - 0.253347103135800, $d->icdf(0.4), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + 0.524400512708049, $d->icdf(0.7), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + 1.28155156554473, $d->icdf(0.9), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + 1.64485362695213, $d->icdf(0.95), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + 1.95996398453944, $d->icdf(0.975), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + 2.32634787404074, $d->icdf(0.99), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + 3.71901648545454, $d->icdf(0.9999), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + 4.75342430881908, $d->icdf(0.999999), 1e-7, "Inverse CDF incorrect");
    }

    public function testNormalICDFWithOtherVariance()
    {
        $mu = 1;
        $sigma = 0.7;
        $d = new Normal($mu, $sigma * $sigma);

        $this->assertEqualsWithDelta($mu - $sigma * 0.841621233572216, $d->icdf(0.2), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu - $sigma * 0.253347103135800, $d->icdf(0.4), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + $sigma * 0.524400512708049, $d->icdf(0.7), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + $sigma * 1.28155156554473, $d->icdf(0.9), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + $sigma * 1.64485362695213, $d->icdf(0.95), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + $sigma * 1.95996398453944, $d->icdf(0.975), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + $sigma * 2.32634787404074, $d->icdf(0.99), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + $sigma * 3.71901648545454, $d->icdf(0.9999), 1e-7, "Inverse CDF incorrect");
        $this->assertEqualsWithDelta($mu + $sigma * 4.75342430881908, $d->icdf(0.999999), 1e-7, "Inverse CDF incorrect");
    }

    public function testMeanAndVariance()
    {
        $d = new Normal(8, 0.1);
        $this->assertEquals(8, $d->mean());
        $this->assertEquals(0.1, $d->variance());
    }

    public function testRationalApproximation()
    {
        $d = new Normal(8, 0.1);
        $this->assertEqualsWithDelta(7.2643442088140445358, $d->icdf(0.01), 1e-9, "Inverse CDF incorrect");
    }

    public function testInfICDF()
    {
        $d = new Normal(8, 0.1);
        $this->assertEquals(INF, $d->icdf(1));
    }

    public function testOutOfRangeICDF()
    {
        $d = new Normal(8, 0.1);
        $this->expectException(\InvalidArgumentException::class);
        $d->icdf(2);
    }

    public function testBoxMuller()
    {
        $this->assertIsFloat(Normal::boxMuller());
    }

    public function testInvalidParameters()
    {
        $this->expectException(\InvalidArgumentException::class);
        Normal::validateParameters("x", 1, 1, 1);
    }
}
