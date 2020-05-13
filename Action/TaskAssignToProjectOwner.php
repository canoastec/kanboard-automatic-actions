<?php

namespace Kanboard\Plugin\CanoastecAutomaticActions\Action;

use Kanboard\Model\TaskModel;
use Kanboard\Action\Base;

/**
 * Assign a task to the logged user on column change
 *
 * @package Kanboard\Action
 * @author  Frederic Guillot
 */
class TaskAssignToProjectOwner extends Base
{
    /**
     * Get automatic action description
     *
     * @access public
     * @return string
     */
    public function getDescription()
    {
        return t('Atribuir tarefa para o lider do projeto');
    }

    /**
     * Get the list of compatible events
     *
     * @access public
     * @return array
     */
    public function getCompatibleEvents()
    {
        return array(
            TaskModel::EVENT_MOVE_COLUMN,
        );
    }

    /**
     * Get the required parameter for the action (defined by the user)
     *
     * @access public
     * @return array
     */
    public function getActionRequiredParameters()
    {
        return array(
            'column_id' => t('Column'),
        );
    }

    /**
     * Get the required parameter for the event
     *
     * @access public
     * @return string[]
     */
    public function getEventRequiredParameters()
    {
        return array(
            'task_id',
            'task' => array(
                'project_id',
                'column_id',
            ),
        );
    }

    /**
     * Execute the action
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool            True if the action was executed or false when not executed
     */
    public function doAction(array $data)
    {
        if (! $this->userSession->isLogged()) {
            return false;
        }

        $project = $this->projectModel->getById($data['project_id']);
        $owner = $project['owner_id'];

        if(!$owner)
          return false;

        $values = array(
            'id' => $data['task_id'],
            'owner_id' => $owner,
        );

        return $this->taskModificationModel->update($values);
    }

    /**
     * Check if the event data meet the action condition
     *
     * @access public
     * @param  array   $data   Event data dictionary
     * @return bool
     */
    public function hasRequiredCondition(array $data)
    {
        return $data['task']['column_id'] == $this->getParam('column_id');
    }
}
