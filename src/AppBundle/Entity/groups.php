<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * groups
 *
 * @ORM\Table(name="groups")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\groupsRepository")
 */
class groups
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="person", mappedBy="groups")
     */
    private $persons;


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
     * @return groups
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
     * Constructor
     */
    public function __construct()
    {
        $this->persons = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add persons
     *
     * @param \AppBundle\Entity\person $persons
     * @return groups
     */
    public function addPerson(\AppBundle\Entity\person $persons)
    {
        $this->persons[] = $persons;

        return $this;
    }

    /**
     * Remove persons
     *
     * @param \AppBundle\Entity\person $persons
     */
    public function removePerson(\AppBundle\Entity\person $persons)
    {
        $this->persons->removeElement($persons);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * @return string
     * This will save me from erros
     * when trying to print out list
     */
    public function __toString() {
        return $this->name;
    }
}
