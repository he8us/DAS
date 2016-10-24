<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),

            new \Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\TranslationBundle\JMSTranslationBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),

            new Oneup\FlysystemBundle\OneupFlysystemBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new \Vich\UploaderBundle\VichUploaderBundle(),

            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new \Sg\DatatablesBundle\SgDatatablesBundle(),

            new DZunke\FeatureFlagsBundle\DZunkeFeatureFlagsBundle(),

            new Gregwar\CaptchaBundle\GregwarCaptchaBundle(),
            new He8us\FeedbackBundle\He8usFeedbackBundle(),
            new Bazinga\Bundle\JsTranslationBundle\BazingaJsTranslationBundle(),

            new CoreBundle\CoreBundle(),
            new UserBundle\UserBundle(),
            new CMSBundle\CMSBundle(),
            new CourseBundle\CourseBundle(),
            new StudentBundle\StudentBundle(),
            new FeedbackBundle\FeedbackBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test', 'acceptance'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new Hautelook\AliceBundle\HautelookAliceBundle();
            $bundles[] = new Trappar\AliceGeneratorBundle\TrapparAliceGeneratorBundle();
        }

        return $bundles;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__) . '/var/cache/' . $this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__) . '/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    public function getRootDir()
    {
        return __DIR__;
    }
}
