<?php

namespace Qcm\Bundle\AdminBundle\Listener;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class QuestionListener
 */
class QuestionListener
{
    protected $manager;

    /**
     * Construct
     *
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Update question
     *
     * @param GenericEvent $event
     */
    public function update(GenericEvent $event)
    {
        $originalAnswers = new ArrayCollection();

        foreach ($event->getSubject()->getAnswers()->getSnapshot() as $answer) {
            $originalAnswers->add($answer);
        }

        /** @var ArrayCollection $answers */
        $answers = $event->getSubject()->getAnswers();

        foreach ($originalAnswers as $answer) {
            if ($answers->contains($answer) == false) {
                $answers->removeElement($answer);

                $this->manager->persist($answer);
                $this->manager->remove($answer);
            }
        }
    }
}
