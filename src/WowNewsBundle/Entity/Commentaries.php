<?php

namespace WowNewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaries
 *
 * @ORM\Table(name="commentaries")
 * @ORM\Entity(repositoryClass="WowNewsBundle\Repository\CommentariesRepository")
 */
class Commentaries
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
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_published", type="datetime")
     */
    private $datePublished;

    public function __construct()
    {
        $this->datePublished = new \DateTime('now');
    }

    public function __toString()
    {
         return $this->content;
    }

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
     * Set content
     *
     * @param string $content
     *
     * @return Commentaries
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set datePublished
     *
     * @param \DateTime $datePublished
     *
     * @return Commentaries
     */
    public function setDatePublished($datePublished)
    {
        $this->datePublished = $datePublished;

        return $this;
    }

    /**
     * Get datePublished
     *
     * @return \DateTime
     */
    public function getDatePublished()
    {
        return $this->datePublished;
    }

   
    //Association

     /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="commentaries")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
     private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Articles", inversedBy="commentaries")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    private $article;

    /**
     * Set article
     *
     * @param \WowNewsBundle\Entity\Articles $article
     *
     * @return Commentaries
     */
    public function setArticle(\WowNewsBundle\Entity\Articles $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \WowNewsBundle\Entity\Articles
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set user
     *
     * @param \WowNewsBundle\Entity\User $user
     *
     * @return Commentaries
     */
    public function setUser(\WowNewsBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \WowNewsBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

   
}
