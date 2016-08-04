<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 04/08/16
 * Time: 13:13
 */

namespace AppBundle\Entity;

use AppBundle\Traits\BaseTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Annotation as Gedmo;

/**
 * Class WorkflowStep
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkflowStepRepository")
 * @ORM\Table(name="workflow_step")
 */
class WorkflowStep
{
    use BaseTrait;
    /**
     * @var integer $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @var string $label
     * @ORM\Column(name="label", type="string", length=50)
     */
    protected $label;
    /**
     * @var int $order
     * @ORM\Column(name="order", type="integer", nullable=false)
     */
    protected $order;
    /**
     * @var WorkflowModel $workflow
     * @ORM\OneToMany(targetEntity="WorkflowModel", mappedBy="wfStep")
     */
    protected $workflow;

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return WorkflowModel
     */
    public function getWorkflow()
    {
        return $this->workflow;
    }

    /**
     * @param WorkflowModel $workflow
     */
    public function setWorkflow($workflow)
    {
        $this->workflow = $workflow;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param int $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->workflow = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add workflow
     *
     * @param \AppBundle\Entity\WorkflowModel $workflow
     *
     * @return WorkflowStep
     */
    public function addWorkflow(\AppBundle\Entity\WorkflowModel $workflow)
    {
        $this->workflow[] = $workflow;

        return $this;
    }

    /**
     * Remove workflow
     *
     * @param \AppBundle\Entity\WorkflowModel $workflow
     */
    public function removeWorkflow(\AppBundle\Entity\WorkflowModel $workflow)
    {
        $this->workflow->removeElement($workflow);
    }
}
