<?php

namespace AppBundle\Manager;


use AppBundle\Entity\WorkflowStatus;

class WorkflowStatusManager extends BaseManager
{
    const SERVICE_NAME = 'app.wf_status_manager';

    /**
     * Register new status in database
     * @param string $name
     */
    public function addNewStatus($name)
    {
        $status = new WorkflowStatus();
        $status->setLabel($name);
        $this->save($status);
    }

    /**
     * @param WorkflowStatus $status
     * @param string         $newName
     */
    public function editStatus(WorkflowStatus $status, $newName)
    {
        $status->setLabel($newName);
        $this->save($status);
    }
    
}