<?php

namespace Qcm\Bundle\AdminBundle\Form\Type;

use Qcm\Bundle\CoreBundle\Doctrine\ORM\QuestionRepository;
use Qcm\Component\Configuration\Model\ConfigurationInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class UserSessionCompleteFormType
 */
class UserSessionCompleteFormType extends AbstractType
{
    /**
     * @var string $class
     */
    private $class;

    /**
     * @var string $validationGroup
     */
    private $validationGroup;

    /**
     * Construct
     *
     * @param string                 $class
     * @param string                 $validationGroup
     */
    public function __construct($class, $validationGroup)
    {
        $this->class = $class;
        $this->validationGroup = $validationGroup;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('questions', 'entity', array(
                'label' => 'qcm_core.label.questions',
                'class' => 'Qcm\Bundle\PublicBundle\Entity\Question',
                'multiple' => true,
                'expanded' => true,
                'property' => 'name'
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'validation_groups' =>$this->validationGroup,
            'cascade_validation' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'qcm_admin_user_session_complete';
    }
}
