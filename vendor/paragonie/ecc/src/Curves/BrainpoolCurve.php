<?php
declare(strict_types=1);
namespace Mdanter\Ecc\Curves;

use Mdanter\Ecc\Math\GmpMathInterface;
use Mdanter\Ecc\Optimized\BP256;
use Mdanter\Ecc\Optimized\BP384;
use Mdanter\Ecc\Optimized\BP512;
use Mdanter\Ecc\Primitives\CurveParameters;
use Mdanter\Ecc\Primitives\GeneratorPoint;
use Mdanter\Ecc\Random\RandomNumberGeneratorInterface;

class BrainpoolCurve
{
    const NAME_P256R1 = 'brainpoolP256r1';
    const NAME_P384R1 = 'brainpoolP384r1';
    const NAME_P512R1 = 'brainpoolP512r1';

    /**
     * @var GmpMathInterface
     */
    private $adapter;

    /**
     * @param GmpMathInterface $adapter
     */
    public function __construct(GmpMathInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Returns a Brainpool P256 curve.
     *
     * @return NamedCurveFp
     */
    public function curve256r1(): NamedCurveFp
    {
        $p = gmp_init('A9FB57DBA1EEA9BC3E660A909D838D726E3BF623D52620282013481D1F6E5377', 16);
        $a = gmp_init('7D5A0975FC2C3057EEF67530417AFFE7FB8055C126DC5C6CE94A4B44F330B5D9', 16);
        $b = gmp_init('26DC5C6CE94A4B44F330B5D9BBD77CBF958416295CF7E1CE6BCCDC18FF8C07B6', 16);

        $parameters = new CurveParameters(256, $p, $a, $b);

        return new NamedCurveFp(self::NAME_P256R1, $parameters, $this->adapter);
    }

    /**
     * Returns a Brainpool P256 curve.
     *
     * @return OptimizedCurveFp
     */
    public function optimizedCurve256r1(): OptimizedCurveFp
    {
        $p = gmp_init('A9FB57DBA1EEA9BC3E660A909D838D726E3BF623D52620282013481D1F6E5377', 16);
        $a = gmp_init('7D5A0975FC2C3057EEF67530417AFFE7FB8055C126DC5C6CE94A4B44F330B5D9', 16);
        $b = gmp_init('26DC5C6CE94A4B44F330B5D9BBD77CBF958416295CF7E1CE6BCCDC18FF8C07B6', 16);

        $parameters = new CurveParameters(256, $p, $a, $b);

        return (new OptimizedCurveFp(self::NAME_P256R1, $parameters, $this->adapter))
            ->setOptimizedCurveOps(new BP256());
    }

    /**
     * Returns a Brainpool P256 generator.
     *
     * @param  ?RandomNumberGeneratorInterface $randomGenerator
     * @param bool $optimized
     * @return GeneratorPoint
     */
    public function generator256r1(RandomNumberGeneratorInterface $randomGenerator = null, bool $optimized = false): GeneratorPoint
    {
        if ($optimized) {
            $curve = $this->optimizedCurve256r1();
        } else {
            $curve = $this->curve256r1();
        }

        $order = gmp_init('A9FB57DBA1EEA9BC3E660A909D838D718C397AA3B561A6F7901E0E82974856A7', 16);
        $x = gmp_init('8BD2AEB9CB7E57CB2C4B482FFC81B7AFB9DE27E1E3BD23C23A4453BD9ACE3262', 16);
        $y = gmp_init('547EF835C3DAC4FD97F8461A14611DC9C27745132DED8E545C1D54C72F046997', 16);

        return $curve->getGenerator($x, $y, $order, $randomGenerator);
    }

    /**
     * Returns a Brainpool P384 curve.
     *
     * @return NamedCurveFp
     */
    public function curve384r1(): NamedCurveFp
    {
        $p = gmp_init('8CB91E82A3386D280F5D6F7E50E641DF152F7109ED5456B412B1DA197FB71123ACD3A729901D1A71874700133107EC53', 16);
        $a = gmp_init('7BC382C63D8C150C3C72080ACE05AFA0C2BEA28E4FB22787139165EFBA91F90F8AA5814A503AD4EB04A8C7DD22CE2826', 16);
        $b = gmp_init('4A8C7DD22CE28268B39B55416F0447C2FB77DE107DCD2A62E880EA53EEB62D57CB4390295DBC9943AB78696FA504C11', 16);

        $parameters = new CurveParameters(384, $p, $a, $b);

        return new NamedCurveFp(self::NAME_P384R1, $parameters, $this->adapter);
    }

    /**
     * Returns a Brainpool P384 curve.
     *
     * @return OptimizedCurveFp
     */
    public function optimizedCurve384r1(): OptimizedCurveFp
    {
        $p = gmp_init('8CB91E82A3386D280F5D6F7E50E641DF152F7109ED5456B412B1DA197FB71123ACD3A729901D1A71874700133107EC53', 16);
        $a = gmp_init('7BC382C63D8C150C3C72080ACE05AFA0C2BEA28E4FB22787139165EFBA91F90F8AA5814A503AD4EB04A8C7DD22CE2826', 16);
        $b = gmp_init('4A8C7DD22CE28268B39B55416F0447C2FB77DE107DCD2A62E880EA53EEB62D57CB4390295DBC9943AB78696FA504C11', 16);

        $parameters = new CurveParameters(384, $p, $a, $b);

        return (new OptimizedCurveFp(self::NAME_P384R1, $parameters, $this->adapter))
            ->setOptimizedCurveOps(new BP384());
    }

    /**
     * Returns a Brainpool P384 generator.
     *
     * @param  ?RandomNumberGeneratorInterface $randomGenerator
     * @param bool $optimized
     * @return GeneratorPoint
     */
    public function generator384r1(RandomNumberGeneratorInterface $randomGenerator = null, bool $optimized = false): GeneratorPoint
    {
        if ($optimized) {
            $curve = $this->optimizedCurve384r1();
        } else {
            $curve = $this->curve384r1();
        }

        $order = gmp_init('8CB91E82A3386D280F5D6F7E50E641DF152F7109ED5456B31F166E6CAC0425A7CF3AB6AF6B7FC3103B883202E9046565', 16);
        $x = gmp_init('1D1C64F068CF45FFA2A63A81B7C13F6B8847A3E77EF14FE3DB7FCAFE0CBD10E8E826E03436D646AAEF87B2E247D4AF1E', 16);
        $y = gmp_init('8ABE1D7520F9C2A45CB1EB8E95CFD55262B70B29FEEC5864E19C054FF99129280E4646217791811142820341263C5315', 16);

        return $curve->getGenerator($x, $y, $order, $randomGenerator);
    }

    /**
     * Returns a Brainpool P512 curve.
     *
     * @return NamedCurveFp
     */
    public function curve512r1(): NamedCurveFp
    {
        $p = gmp_init('AADD9DB8DBE9C48B3FD4E6AE33C9FC07CB308DB3B3C9D20ED6639CCA703308717D4D9B009BC66842AECDA12AE6A380E62881FF2F2D82C68528AA6056583A48F3', 16);
        $a = gmp_init('7830A3318B603B89E2327145AC234CC594CBDD8D3DF91610A83441CAEA9863BC2DED5D5AA8253AA10A2EF1C98B9AC8B57F1117A72BF2C7B9E7C1AC4D77FC94CA', 16);
        $b = gmp_init('3DF91610A83441CAEA9863BC2DED5D5AA8253AA10A2EF1C98B9AC8B57F1117A72BF2C7B9E7C1AC4D77FC94CADC083E67984050B75EBAE5DD2809BD638016F723', 16);

        $parameters = new CurveParameters(512, $p, $a, $b);

        return new NamedCurveFp(self::NAME_P512R1, $parameters, $this->adapter);
    }

    /**
     * Returns a Brainpool P512 curve.
     *
     * @return OptimizedCurveFp
     */
    public function optimizedCurve512r1(): OptimizedCurveFp
    {
        $p = gmp_init('AADD9DB8DBE9C48B3FD4E6AE33C9FC07CB308DB3B3C9D20ED6639CCA703308717D4D9B009BC66842AECDA12AE6A380E62881FF2F2D82C68528AA6056583A48F3', 16);
        $a = gmp_init('7830A3318B603B89E2327145AC234CC594CBDD8D3DF91610A83441CAEA9863BC2DED5D5AA8253AA10A2EF1C98B9AC8B57F1117A72BF2C7B9E7C1AC4D77FC94CA', 16);
        $b = gmp_init('3DF91610A83441CAEA9863BC2DED5D5AA8253AA10A2EF1C98B9AC8B57F1117A72BF2C7B9E7C1AC4D77FC94CADC083E67984050B75EBAE5DD2809BD638016F723', 16);

        $parameters = new CurveParameters(512, $p, $a, $b);

        return (new OptimizedCurveFp(self::NAME_P512R1, $parameters, $this->adapter))
            ->setOptimizedCurveOps(new BP512());
    }

    /**
     * Returns a Brainpool P512 generator.
     *
     * @param  ?RandomNumberGeneratorInterface $randomGenerator
     * @param  bool $optimized
     * @return GeneratorPoint
     */
    public function generator512r1(RandomNumberGeneratorInterface $randomGenerator = null, bool $optimized = false): GeneratorPoint
    {
        if ($optimized) {
            $curve = $this->optimizedCurve512r1();
        } else {
            $curve = $this->curve512r1();
        }

        $order = gmp_init('AADD9DB8DBE9C48B3FD4E6AE33C9FC07CB308DB3B3C9D20ED6639CCA70330870553E5C414CA92619418661197FAC10471DB1D381085DDADDB58796829CA90069', 16);
        $x = gmp_init('81AEE4BDD82ED9645A21322E9C4C6A9385ED9F70B5D916C1B43B62EEF4D0098EFF3B1F78E2D0D48D50D1687B93B97D5F7C6D5047406A5E688B352209BCB9F822', 16);
        $y = gmp_init('7DDE385D566332ECC0EABFA9CF7822FDF209F70024A57B1AA000C55B881F8111B2DCDE494A5F485E5BCA4BD88A2763AED1CA2B2FA8F0540678CD1E0F3AD80892', 16);

        return $curve->getGenerator($x, $y, $order, $randomGenerator);
    }
}
