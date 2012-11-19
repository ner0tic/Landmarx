<?php

namespace Landmarx\Bundle\LandmarxBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Landmarx\Bundle\LandmarxBundle\DependencyInjection\Compiler\LandmarkPass;
use Landmarx\Bundle\LandmarxBundle\DependencyInjection\Compiler\AddProvidersPass;
use Landmarx\Bundle\LandmarxBundle\DependencyInjection\Compiler\AddRenderersPass;
use Landmarx\Bundle\LandmarxBundle\DependencyInjection\Compiler\AddTemplatePathPass;
use Landmarx\Bundle\LandmarxBundle\DependencyInjection\Compiler\AddVotersPass;

class LandmarxBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new LandmarkPass());
        $container->addCompilerPass(new AddProvidersPass());
        $container->addCompilerPass(new AddRenderersPass());
        $container->addCompilerPass(new AddTemplatePathPass());
        $container->addCompilerPass(new AddVotersPass());
    }
}
