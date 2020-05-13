<?php
namespace Kanboard\Plugin\CanoastecAutomaticActions;

use Kanboard\Core\Plugin\Base;
use Kanboard\Plugin\CanoastecAutomaticActions\Action\TaskAssignToProjectOwner;
use Kanboard\Plugin\CanoastecAutomaticActions\Action\TaskAssignToRandomUserFromGroup;
use Kanboard\Plugin\CanoastecAutomaticActions\Action\TaskAssignTimeSpendOnLastColumn;
use Kanboard\Plugin\CanoastecAutomaticActions\Action\TaskAssignToUserFromOtherColumn;

class Plugin extends Base
{
    public function initialize()
    {

		    $this->actionManager->register(new TaskAssignToProjectOwner($this->container));
        $this->actionManager->register(new TaskAssignToRandomUserFromGroup($this->container));
        $this->actionManager->register(new TaskAssignToUserFromOtherColumn($this->container));

    }

    public function getPluginName()
    {
        return 'CanoastecAutomaticActions';
    }

    public function getPluginDescription()
    {
        return t('Ações automáticas para projetos da Canoastec - RS - Brasil');
    }

    public function getPluginAuthor()
    {
        return 'Canoastec';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/canoastec/kanboard-automatic-actions';
    }

    public function getCompatibleVersion()
    {
        return '>=1.0.44';
    }
}
