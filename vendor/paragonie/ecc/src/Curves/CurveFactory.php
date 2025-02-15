<?php
declare(strict_types=1);

namespace Mdanter\Ecc\Curves;

use Mdanter\Ecc\Exception\UnsupportedCurveException;
use Mdanter\Ecc\Math\GmpMathInterface;
use Mdanter\Ecc\Math\MathAdapterFactory;
use Mdanter\Ecc\Primitives\GeneratorPoint;

class CurveFactory
{
    /**
     * @param string $name
     * @return NamedCurveFp
     */
    public static function getCurveByName(string $name): NamedCurveFp
    {
        $adapter = MathAdapterFactory::getAdapter();
        $nistFactory = static::getNistFactory($adapter);
        $brainpoolFactory = static::getBrainpoolFactory($adapter);
        $secpFactory = static::getSecpFactory($adapter);

        switch ($name) {
            case NistCurve::NAME_P192:
                return $nistFactory->curve192();
            case NistCurve::NAME_P224:
                return $nistFactory->curve224();
            case NistCurve::NAME_P256:
                return $nistFactory->curve256();
            case NistCurve::NAME_P384:
                return $nistFactory->curve384();
            case NistCurve::NAME_P521:
                return $nistFactory->curve521();
            case BrainpoolCurve::NAME_P256R1:
                return $brainpoolFactory->curve256r1();
            case BrainpoolCurve::NAME_P384R1:
                return $brainpoolFactory->curve384r1();
            case BrainpoolCurve::NAME_P512R1:
                return $brainpoolFactory->curve512r1();
            case SecgCurve::NAME_SECP_112R1:
                return $secpFactory->curve112r1();
            case SecgCurve::NAME_SECP_192K1:
                return $secpFactory->curve192k1();
            case SecgCurve::NAME_SECP_256K1:
                return $secpFactory->curve256k1();
            case SecgCurve::NAME_SECP_256R1:
                return $secpFactory->curve256r1();
            case SecgCurve::NAME_SECP_384R1:
                return $secpFactory->curve384r1();
            default:
                $error = new UnsupportedCurveException('Unknown curve.');
                $error->setCurveName($name);
                throw $error;
        }
    }

    /**
     * @param string $name
     * @return GeneratorPoint
     */
    public static function getGeneratorByName(string $name): GeneratorPoint
    {
        $adapter = MathAdapterFactory::getAdapter();
        $nistFactory = static::getNistFactory($adapter);
        $brainpoolFactory = static::getBrainpoolFactory($adapter);
        $secpFactory = static::getSecpFactory($adapter);

        switch ($name) {
            case NistCurve::NAME_P192:
                return $nistFactory->generator192();
            case NistCurve::NAME_P224:
                return $nistFactory->generator224();
            case NistCurve::NAME_P256:
                return $nistFactory->generator256();
            case NistCurve::NAME_P384:
                return $nistFactory->generator384();
            case NistCurve::NAME_P521:
                return $nistFactory->generator521();
            case BrainpoolCurve::NAME_P256R1:
                return $brainpoolFactory->generator256r1();
            case BrainpoolCurve::NAME_P384R1:
                return $brainpoolFactory->generator384r1();
            case BrainpoolCurve::NAME_P512R1:
                return $brainpoolFactory->generator512r1();
            case SecgCurve::NAME_SECP_112R1:
                return $secpFactory->generator112r1();
            case SecgCurve::NAME_SECP_192K1:
                return $secpFactory->generator192k1();
            case SecgCurve::NAME_SECP_256K1:
                return $secpFactory->generator256k1();
            case SecgCurve::NAME_SECP_256R1:
                return $secpFactory->generator256r1();
            case SecgCurve::NAME_SECP_384R1:
                return $secpFactory->generator384r1();
            default:
                $error = new UnsupportedCurveException('Unknown generator.');
                $error->setCurveName($name);
                throw $error;
        }
    }

    /**
     * @param GmpMathInterface $math
     * @return NistCurve
     */
    protected static function getNistFactory(GmpMathInterface $math): NistCurve
    {
        return new NistCurve($math);
    }

    /**
     * @param GmpMathInterface $math
     * @return BrainpoolCurve
     */
    protected static function getBrainpoolFactory(GmpMathInterface $math): BrainpoolCurve
    {
        return new BrainpoolCurve($math);
    }

    /**
     * @param GmpMathInterface $math
     * @return SecgCurve
     */
    protected static function getSecpFactory(GmpMathInterface $math): SecgCurve
    {
        return new SecgCurve($math);
    }
}
