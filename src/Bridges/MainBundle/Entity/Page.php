<?php

namespace Bridges\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bridges\MainBundle\Entity\PageRepository")
 */
class Page
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="headerEng", type="string", length=255, nullable=true)
     */
    private $headerEng;

    /**
     * @var string
     *
     * @ORM\Column(name="contentEng", type="text", nullable=true)
     */
    private $contentEng;

    /**
     * @var string
     *
     * @ORM\Column(name="headerEsp", type="string", length=255, nullable=true)
     */
    private $headerEsp;

    /**
     * @var string
     *
     * @ORM\Column(name="contentEsp", type="text", nullable=true)
     */
    private $contentEsp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="dataBaseName", type="string", length=255)
     */
    private $dataBaseName;


    /*   *********      construct  *************  */

    public function __construct()
    {
        $this->updatedAt        = new \Datetime;
        $this->createdAt        = new \Datetime;
    }



    /**
     * Get id
     *
     * @return integer
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
     * @return Page
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
     * Set header
     *
     * @param string $header
     *
     * @return Page
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Page
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Page
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Page
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set dataBaseName
     *
     * @param string $dataBaseName
     *
     * @return Page
     */
    public function setDataBaseName($dataBaseName)
    {
        $this->dataBaseName = $dataBaseName;

        return $this;
    }

    /**
     * Get dataBaseName
     *
     * @return string
     */
    public function getDataBaseName()
    {
        return $this->dataBaseName;
    }

    /**
     * Set headerEng
     *
     * @param string $headerEng
     *
     * @return Page
     */
    public function setHeaderEng($headerEng)
    {
        $this->headerEng = $headerEng;

        return $this;
    }

    /**
     * Get headerEng
     *
     * @return string
     */
    public function getHeaderEng()
    {
        return $this->headerEng;
    }

    /**
     * Set contentEng
     *
     * @param string $contentEng
     *
     * @return Page
     */
    public function setContentEng($contentEng)
    {
        $this->contentEng = $contentEng;

        return $this;
    }

    /**
     * Get contentEng
     *
     * @return string
     */
    public function getContentEng()
    {
        return $this->contentEng;
    }

    /**
     * Set headerEsp
     *
     * @param string $headerEsp
     *
     * @return Page
     */
    public function setHeaderEsp($headerEsp)
    {
        $this->headerEsp = $headerEsp;

        return $this;
    }

    /**
     * Get headerEsp
     *
     * @return string
     */
    public function getHeaderEsp()
    {
        return $this->headerEsp;
    }

    /**
     * Set contentEsp
     *
     * @param string $contentEsp
     *
     * @return Page
     */
    public function setContentEsp($contentEsp)
    {
        $this->contentEsp = $contentEsp;

        return $this;
    }

    /**
     * Get contentEsp
     *
     * @return string
     */
    public function getContentEsp()
    {
        return $this->contentEsp;
    }
}
