<?php
namespace Findmyrice\Models;


use Phalcon\Mvc\Collection;

/**
 * Topic for help section
 */
class HelpTopics extends Collection
{
    public function getSource()
    {
        return 'help_topics';
    }

    /**
     *
     * @var integer
     */
    public $_id;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $alias;

    /**
     *
     * @var string
     */
    public $content;

    /**
     *
     * @var string
     */
    public $category_id;

    /**
     *
     * @var boolean
     */
    public $top_faq;

    /**
     *
     * @var integer
     */
    public $order;

    public function beforeCreate()
    {
        $lastOrder = HelpTopics::findFirst(array(
            'sort' =>array('order' => -1)
        ));

        $this->order = !$lastOrder ? 1 : $lastOrder->order + 1;
        $this->top_faq = ($this->top_faq == 'on');
    }

    public function getCategory()
    {
        if (!$this->_id) {
            return null;
        }

        return HelpCategories::findById($this->category_id);
    }
}