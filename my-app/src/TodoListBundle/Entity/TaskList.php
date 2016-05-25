<?php

namespace TodoListBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TaskList
 *
 * @ORM\Table(name="task_list")
 * @ORM\Entity(repositoryClass="TodoListBundle\Repository\TaskListRepository")
 */
class TaskList
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;
    
	/**
     * @ORM\Column(type="datetime", length=100)
     */
    private $limitData;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TaskList
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set limitData
     *
     * @param \DATETIME $limitData
     *
     * @return TaskList
     */
    public function setLimitData(\DATETIME $limitData)
    {
        $this->limitData = $limitData;

        return $this;
    }

    /**
     * Get limitData
     *
     * @return \DATETIME
     */
    public function getLimitData()
    {
        return $this->limitData;
    }
}
