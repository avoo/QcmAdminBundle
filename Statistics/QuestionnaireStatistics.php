<?php

namespace Qcm\Bundle\AdminBundle\Statistics;

use Doctrine\Common\Collections\ArrayCollection;
use Qcm\Bundle\AdminBundle\Statistics\Checker\CheckerValidatorInterface;
use Qcm\Bundle\AdminBundle\Statistics\Model\ScoreInterface;
use Qcm\Bundle\AdminBundle\Statistics\Model\TemplateInterface;
use Qcm\Component\User\Model\UserSessionInterface;

/**
 * Class QuestionnaireStatistics
 */
class QuestionnaireStatistics
{
    /**
     * @var ScoreInterface $score
     */
    protected $score;

    /**
     * @var ArrayCollection $data
     */
    protected $data;

    /**
     * @var string $answerTemplate
     */
    protected $answerTemplate;

    /**
     * @var CheckerValidatorInterface $checker
     */
    private $checker;

    /**
     * Construct
     *
     * @param ScoreInterface            $score
     * @param string                    $template
     * @param CheckerValidatorInterface $checker
     */
    public function __construct(ScoreInterface $score, $template, CheckerValidatorInterface $checker)
    {
        $this->score = $score;
        $this->answerTemplate = $template;
        $this->checker = $checker;
        $this->data = new ArrayCollection();
    }

    /**
     * Parse questionnaire results
     *
     * @param UserSessionInterface $userSession
     *
     * @return $this
     */
    public function execute(UserSessionInterface $userSession)
    {
        foreach ($userSession->getConfiguration()->getQuestions() as $key => $question) {
            /** @var TemplateInterface $template */
            $template = new $this->answerTemplate;
            $template->setQuestion($question);

            if (is_null($data = $userSession->getConfiguration()->getAnswers()->get($key))) {
                $this->score->addNotValid();
                $this->data->add($template);
                continue;
            }

            $template->setFlag(isset($data['flag']) ? $data['flag'] : false);
            unset($data['flag']);

            $isValid = $this->checker->get($question->getType())->validate($data, $question, $this->score);
            $template->setValid($isValid);

            $this->data->add($template);
        }

        return $this;
    }

    /**
     * Get data results
     *
     * @return ArrayCollection
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get score
     *
     * @return ScoreInterface
     */
    public function getScore()
    {
        return $this->score->getScore();
    }

    /**
     * Get score by category
     *
     * @return array
     */
    public function getScoreByCategory()
    {
        $categories = array();

        /** @var TemplateInterface $template */
        foreach ($this->getData() as $template) {
            $category = $template->getQuestion()->getCategory();

            if (!isset($categories[$category->getId()])) {
                $categories[$category->getId()] = array(
                    'name' => $category->getName(),
                    'valid' => 0,
                    'total' => 0,
                    'color' => '#' . substr('00000' . dechex(mt_rand(0, 0xffffff)), -6)
                );
            }

            if ($template->isValid()) {
                $categories[$category->getId()]['valid']++;
            }

            $categories[$category->getId()]['total']++;
        }

        return $categories;
    }

    /**
     * Get result percentage
     *
     * @return float
     */
    public function getPercentage()
    {
        $total = $this->score->getValid() +
            $this->score->getPartial() +
            $this->score->getNotValid();

        return round(($this->score->getValid()/$total) * 100);
    }

    /**
     * Get ratio
     *
     * @return float
     */
    public function getRatio()
    {
        $total = $this->score->getValid() +
            $this->score->getPartial() +
            $this->score->getNotValid();

        return $this->score->getValid() == 0 ? 0 : (float) number_format($this->score->getValid()/$total, 2);
    }
}
