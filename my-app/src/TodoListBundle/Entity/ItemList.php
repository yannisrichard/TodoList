<?php

namespace TodoListBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * ItemList.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TodoListBundle\Repository\ItemListRepository")
 */
class ItemList
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="datetime")
     * @Assert\DateTime()
     */
    private $deadline;

    /**
     * @var bool
     *
     * @ORM\Column(name="done", type="boolean")
     */
    private $done;

    /**
     * @ORM\ManyToOne(targetEntity="TodoListBundle\Entity\MainList", inversedBy="itemlists")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mainlist;

    /**
     * Default Constructor.
     */
    public function __construct()
    {
        $this->deadline = new \DateTime();
        $this->done = false;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return ItemList
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return ItemList
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set deadline.
     *
     * @param \DateTime $deadline
     *
     * @return ItemList
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline.
     *
     * @return \DateTime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set done.
     *
     * @param bool $done
     *
     * @return ItemList
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done.
     *
     * @return bool
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Inverse the boolean value of done.
     */
    public function inverseDone()
    {
        if ($this->done) {
            $this->done = false;
        } else {
            $this->done = true;
        }
    }

    /**
     * Set mainlist.
     *
     * @param \TodoListBundle\Entity\MainList $mainlist
     *
     * @return ItemList
     */
    public function setMainlist(\TodoListBundle\Entity\MainList $mainlist)
    {
        $this->mainlist = $mainlist;

        return $this;
    }

    /**
     * Get mainlist.
     *
     * @return \TodoListBundle\Entity\MainList
     */
    public function getMainlist()
    {
        return $this->mainlist;
    }
}
