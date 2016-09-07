<?php

namespace Qcm\Bundle\AdminBundle\Statistics;

use Qcm\Bundle\CoreBundle\Statistics\Model\QuestionnaireStatistics as BaseQuestionnaireStatistics;
use Qcm\Component\Statistics\Model\TemplateInterface;

/**
 * Class QuestionnaireStatistics
 */
class QuestionnaireStatistics extends BaseQuestionnaireStatistics
{
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
     * Get Score by question level
     *
     * @return array
     */
    public function getScoreByLevel()
    {
        $levels = array();

        /** @var TemplateInterface $template */
        foreach ($this->getData() as $template) {
            $question = $template->getQuestion();

            if (!isset($levels[$question->getLevel()])) {
                $levels[$question->getLevel()] = array(
                    'name' => $question->getLevel(),
                    'valid' => 0,
                    'total' => 0,
                    'color' => '#'.substr('00000'.dechex(mt_rand(0, 0xffffff)), -6)
                );
            }

            if ($template->isValid()) {
                $levels[$question->getLevel()]['valid']++;
            }

            $levels[$question->getLevel()]['total']++;
        }

        sort($levels);

        return $levels;
    }

    /**
     * Get result percentage
     *
     * @return float
     */
    public function getPercentage()
    {
        $total = $this->getTotal();

        return round(($this->score->getValid()/$total) * 100);
    }

    /**
     * Get percentage valid + partial
     */
    public function getPercentagePartial()
    {
        $total = $this->getTotal();

        return round((($this->score->getValid() + $this->score->getPartial())/$total) * 100);
    }

    /**
     * Get total answers
     *
     * @return integer
     */
    public function getTotal()
    {
        return $this->score->getValid() + $this->score->getPartial() + $this->score->getNotValid();
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
