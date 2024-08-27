<?php

namespace freetought\Distributions\Tests;

use freetought\Distributions\Accessories\IncompleteGammaFunction;
use PHPUnit\Framework\TestCase;

class IncompleteGammaFunctionTest extends TestCase
{
    public function testIncompleteGammaFunction()
    {
        $accuracy = 1e-8;

        /* Test data generated with SciPy */
        $testCases = array(
            array( 'x'  =>  0.468706317711 , 'a'  =>  0.827460474921 , 'gamma'  =>  0.464523165447 , ),
            array( 'x'  =>  0.540102623108 , 'a'  =>  0.848446425993 , 'gamma'  =>  0.495820294378 , ),
            array( 'x'  =>  0.420754629029 , 'a'  =>  0.569569726307 , 'gamma'  =>  0.593359600646 , ),
            array( 'x'  =>  0.772395380285 , 'a'  =>  0.0473019162251 , 'gamma'  =>  0.983956655099 , ),
            array( 'x'  =>  0.413786680058 , 'a'  =>  0.0730739555508 , 'gamma'  =>  0.949050412922 , ),
            array( 'x'  =>  0.990935607541 , 'a'  =>  0.345410602912 , 'gamma'  =>  0.898777661955 , ),
            array( 'x'  =>  0.292566275641 , 'a'  =>  0.19056231524 , 'gamma'  =>  0.822067835977 , ),
            array( 'x'  =>  0.369142420571 , 'a'  =>  0.640880026445 , 'gamma'  =>  0.511664120821 , ),
            array( 'x'  =>  0.317942669549 , 'a'  =>  0.505054867545 , 'gamma'  =>  0.570960743585 , ),
            array( 'x'  =>  0.525878707409 , 'a'  =>  0.168638359588 , 'gamma'  =>  0.903654514107 , ),
            array( 'x'  =>  0.184337216835 , 'a'  =>  0.0122404919792 , 'gamma'  =>  0.984237802883 , ),
            array( 'x'  =>  0.362031320217 , 'a'  =>  0.84328901985 , 'gamma'  =>  0.383397931923 , ),
            array( 'x'  =>  0.484441240335 , 'a'  =>  0.139652551055 , 'gamma'  =>  0.914342997767 , ),
            array( 'x'  =>  0.358281493381 , 'a'  =>  0.754190800835 , 'gamma'  =>  0.432075255396 , ),
            array( 'x'  =>  0.342400919833 , 'a'  =>  0.420781477088 , 'gamma'  =>  0.652586506368 , ),
            array( 'x'  =>  0.862321055124 , 'a'  =>  0.941693809108 , 'gamma'  =>  0.604756780608 , ),
            array( 'x'  =>  0.652748066788 , 'a'  =>  0.486118346552 , 'gamma'  =>  0.754520233902 , ),
            array( 'x'  =>  0.972313037352 , 'a'  =>  0.993900760567 , 'gamma'  =>  0.624462345163 , ),
            array( 'x'  =>  0.331972466127 , 'a'  =>  0.162395531272 , 'gamma'  =>  0.861616469101 , ),
            array( 'x'  =>  0.454138503301 , 'a'  =>  0.565395106156 , 'gamma'  =>  0.61579188258 , ),
            array( 'x'  =>  0.555427277598 , 'a'  =>  0.0423908114711 , 'gamma'  =>  0.978387489534 , ),
            array( 'x'  =>  0.334289829275 , 'a'  =>  0.661487749777 , 'gamma'  =>  0.472505926474 , ),
            array( 'x'  =>  0.321569101391 , 'a'  =>  0.511869152092 , 'gamma'  =>  0.56846760423 , ),
            array( 'x'  =>  0.117301416925 , 'a'  =>  0.508045738018 , 'gamma'  =>  0.36524122677 , ),
            array( 'x'  =>  0.0377585173701 , 'a'  =>  0.47521714161 , 'gamma'  =>  0.23509321818 , ),
        );

        foreach ($testCases as $test) {
            $x = $test['x'];
            $a = $test['a'];
            $gamma = $test['gamma'];
            $this->assertEquals($gamma, IncompleteGammaFunction::IncompleteGamma($a, $x), 'Expected incomplete gamma function  Γ($a, $x) not matching', $accuracy);
        }
    }

    // THIS IS WRONG
    // N[Gamma[0.233471428173, 3.87518208831], 20] = 0.00630164
    // N[Gamma[3, 2/4], 20] = 1.9712246440660586267
    // TODO: DISCUSS THIS ERROR
    // http://mathworld.wolfram.com/IncompleteGammaFunction.html
    // to check use wolfram alpha
    public function testComplementedIncompleteGammaFunction()
    {
        $accuracy = 1e-8;

        /* Test data generated with SciPy */
        $testCases = array(
            array( 'x'  =>  3.87518208831 , 'a'  =>  0.233471428173 , 'gamma'  =>  0.00161682165006 , ),
            array( 'x'  =>  4.37820157399 , 'a'  =>  2.51057789072 , 'gamma'  =>  0.120464593199 , ),
            array( 'x'  =>  3.6303817077 , 'a'  =>  3.21152519336 , 'gamma'  =>  0.341054610262 , ),
            array( 'x'  =>  3.88389312067 , 'a'  =>  2.2266709247 , 'gamma'  =>  0.129410940968 , ),
            array( 'x'  =>  1.93592253295 , 'a'  =>  0.814186177727 , 'gamma'  =>  0.103862789465 , ),
            array( 'x'  =>  2.15498825948 , 'a'  =>  3.2356474692 , 'gamma'  =>  0.688908002373 , ),
            array( 'x'  =>  1.63766390539 , 'a'  =>  1.42663776092 , 'gamma'  =>  0.327147908394 , ),
            array( 'x'  =>  4.19836039189 , 'a'  =>  1.51383767505 , 'gamma'  =>  0.0393507195678 , ),
            array( 'x'  =>  0.66545323973 , 'a'  =>  2.29504557825 , 'gamma'  =>  0.906422840361 , ),
            array( 'x'  =>  1.98233875187 , 'a'  =>  4.06872618345 , 'gamma'  =>  0.868907825079 , ),
            array( 'x'  =>  1.5776488118 , 'a'  =>  4.11280091417 , 'gamma'  =>  0.933344817711 , ),
            array( 'x'  =>  2.09160795045 , 'a'  =>  1.32270039645 , 'gamma'  =>  0.196905168751 , ),
            array( 'x'  =>  1.53485089388 , 'a'  =>  2.04346157965 , 'gamma'  =>  0.55976748008 , ),
            array( 'x'  =>  0.128459488914 , 'a'  =>  0.364455260769 , 'gamma'  =>  0.485610993344 , ),
            array( 'x'  =>  0.135891791633 , 'a'  =>  2.46847481486 , 'gamma'  =>  0.997949079852 , ),
            array( 'x'  =>  4.99303191349 , 'a'  =>  4.39339760803 , 'gamma'  =>  0.332825786263 , ),
            array( 'x'  =>  2.12210414955 , 'a'  =>  1.06962551991 , 'gamma'  =>  0.134099817226 , ),
            array( 'x'  =>  2.16682100848 , 'a'  =>  0.581991388706 , 'gamma'  =>  0.0472401610164 , ),
            array( 'x'  =>  2.18857649795 , 'a'  =>  4.7254477316 , 'gamma'  =>  0.906805073071 , ),
            array( 'x'  =>  1.16298541057 , 'a'  =>  4.14624532236 , 'gamma'  =>  0.975108029569 , ),
            array( 'x'  =>  2.69842860559 , 'a'  =>  1.45071857669 , 'gamma'  =>  0.13599456866 , ),
            array( 'x'  =>  2.74992816992 , 'a'  =>  0.0706255436905 , 'gamma'  =>  0.00143885962581 , ),
            array( 'x'  =>  3.53372688165 , 'a'  =>  4.64617055529 , 'gamma'  =>  0.657484239452 , ),
            array( 'x'  =>  2.7522918734 , 'a'  =>  2.51145796177 , 'gamma'  =>  0.360258797973 , ),
            array( 'x'  =>  1.604625837 , 'a'  =>  0.274489082575 , 'gamma'  =>  0.0326841393723 , ),
            // array( 'x'  =>  .5 , 'a'  =>  3 , 'gamma'  =>  1.9712246440660586267 )
        );

        foreach ($testCases as $test) {
            $x = $test['x'];
            $a = $test['a'];
            $gamma = $test['gamma'];
            $this->assertEquals($gamma, IncompleteGammaFunction::ComplementedIncompleteGamma($a, $x), 'Expected incomplete gamma function  Γ($a, $x) not matching', $accuracy);
        }
    }

    public function testInverseComplementedIncompleteGammaFunction()
    {
        $accuracy = 1e-8;

        /* Test data generated with SciPy */
        $testCases = array(
            array( 'x'  =>  0.846068322437 , 'a'  =>  4.22612092552 , 'gamma'  =>  2.22723525959 , ),
            array( 'x'  =>  0.223603838922 , 'a'  =>  0.895499991833 , 'gamma'  =>  1.34701391604 , ),
            array( 'x'  =>  0.350218330502 , 'a'  =>  3.99434530318 , 'gamma'  =>  4.44718691307 , ),
            array( 'x'  =>  0.435062970294 , 'a'  =>  4.39230315052 , 'gamma'  =>  4.40005663275 , ),
            array( 'x'  =>  0.800884197201 , 'a'  =>  3.3626012325 , 'gamma'  =>  1.80294282837 , ),
            array( 'x'  =>  0.00140341292478 , 'a'  =>  0.13492476626 , 'gamma'  =>  3.38362231134 , ),
            array( 'x'  =>  0.251073320896 , 'a'  =>  0.779536833986 , 'gamma'  =>  1.07279688062 , ),
            array( 'x'  =>  0.53153315904 , 'a'  =>  1.88761840449 , 'gamma'  =>  1.47158827153 , ),
            array( 'x'  =>  0.255248806271 , 'a'  =>  0.442790596337 , 'gamma'  =>  0.559090529063 , ),
            array( 'x'  =>  0.726665453808 , 'a'  =>  2.28583309 , 'gamma'  =>  1.24508568807 , ),
            array( 'x'  =>  0.272309593865 , 'a'  =>  3.91485707816 , 'gamma'  =>  4.85001259629 , ),
            array( 'x'  =>  0.572382660509 , 'a'  =>  2.24928713002 , 'gamma'  =>  1.68753965672 , ),
            array( 'x'  =>  0.0853936181905 , 'a'  =>  2.41550135107 , 'gamma'  =>  4.70743176053 , ),
            array( 'x'  =>  0.251571057962 , 'a'  =>  3.41965593761 , 'gamma'  =>  4.41209961763 , ),
            array( 'x'  =>  0.749027362486 , 'a'  =>  1.86197188274 , 'gamma'  =>  0.863233295578 , ),
            array( 'x'  =>  0.150187534551 , 'a'  =>  0.140217880909 , 'gamma'  =>  0.239385708019 , ),
            array( 'x'  =>  0.759602483022 , 'a'  =>  1.19675827381 , 'gamma'  =>  0.39123251831 , ),
            array( 'x'  =>  0.884711959773 , 'a'  =>  1.78431394833 , 'gamma'  =>  0.465258523487 , ),
            array( 'x'  =>  0.434185623333 , 'a'  =>  4.95017602325 , 'gamma'  =>  4.9843746514 , ),
            array( 'x'  =>  0.901326485317 , 'a'  =>  4.028250462 , 'gamma'  =>  1.75500792429 , ),
            array( 'x'  =>  0.631875879234 , 'a'  =>  3.65043517907 , 'gamma'  =>  2.75119792585 , ),
            array( 'x'  =>  0.155155954138 , 'a'  =>  0.0438215641205 , 'gamma'  =>  0.0125577074627 , ),
            array( 'x'  =>  0.261237897164 , 'a'  =>  0.0653585114276 , 'gamma'  =>  0.00578626587657 , ),
            array( 'x'  =>  0.286789031108 , 'a'  =>  2.62478626267 , 'gamma'  =>  3.25043506676 , ),
            array( 'x'  =>  0.98602740743 , 'a'  =>  1.78785592189 , 'gamma'  =>  0.127460923102 , ),
        );

        foreach ($testCases as $test) {
            $x = $test['x'];
            $a = $test['a'];
            $gamma = $test['gamma'];

            $this->assertEquals($gamma, IncompleteGammaFunction::InverseComplementedIncompleteGamma($a, $x), 'Expected inverse incomplete gamma function  iΓ($a, $x) not matching', $accuracy);
        }
    }
}
