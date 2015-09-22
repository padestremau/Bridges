<?php

namespace Bridges\UserBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Bridges\UserBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /*   *********      construct  *************  */

    public function __construct()
    {
        parent::__construct();
        $username = $this->getEmail();
        $usernameCanonical = $this->getEmailCanonical();
    }


    /*   *********     Setter and getter Functions  *************  */

    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function setUsernameToEmail()
    {
        $this->username = $this->email;
        $this->usernameCanonical = $this->emailCanonical;
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
}

