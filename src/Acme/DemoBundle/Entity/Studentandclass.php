<?php


namespace Acme\DemoBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="studentandclass")
 */
class Studentandclass
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="classes")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     **/
    private $student;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Studentclass", inversedBy="students")
     * @ORM\JoinColumn(name="class_id", referencedColumnName="id")
     **/
    private $class;

/**
     * @ORM\Column(name="datefrom",type="date")
     * @Assert\NotBlank()
     */
  
    private $datefrom;

/**
     * @ORM\Column(name="dateto",type="date")
     * @Assert\NotBlank()
     */
  
    private $dateto;


    /**
     * Set student
     *
     * @param \Acme\DemoBundle\Entity\Student $student
     * @return Studentandclass
     */
    public function setStudent(\Acme\DemoBundle\Entity\Student $student = null)
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Get student
     *
     * @return \Acme\DemoBundle\Entity\Student 
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * Set class
     *
     * @param \Acme\DemoBundle\Entity\Studentclass $class
     * @return Studentandclass
     */
    public function setClass(\Acme\DemoBundle\Entity\Studentclass $class = null)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return \Acme\DemoBundle\Entity\Studentclass 
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set datefrom
     *
     * @param \DateTime $datefrom
     * @return Studentandclass
     */
    public function setDatefrom($datefrom)
    {
        $this->datefrom = $datefrom;

        return $this;
    }

    /**
     * Get datefrom
     *
     * @return \DateTime 
     */
    public function getDatefrom()
    {
        return $this->datefrom;
    }

    /**
     * Set dateto
     *
     * @param \DateTime $dateto
     * @return Studentandclass
     */
    public function setDateto($dateto)
    {
        $this->dateto = $dateto;

        return $this;
    }

    /**
     * Get dateto
     *
     * @return \DateTime 
     */
    public function getDateto()
    {
        return $this->dateto;
    }
}
