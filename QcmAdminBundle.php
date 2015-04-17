<?php

namespace Qcm\Bundle\AdminBundle;

use Qcm\Bundle\AdminBundle\DependencyInjection\Compiler\RegisterValidationAnswerCheckersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class QcmAdminBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterValidationAnswerCheckersPass());
    }
}
