<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class RbacCommand extends CConsoleCommand
{

    private $_authManager;

    public function getHelp () {
        return <<<EOD
USAGE
        rbac
DESCRIPTION
        This is the Command to create baisc Structure for Rolebase Access Control hierarchy.
EOD;

    }
    //execute The action Specified by Command
    public function run($args)
    {
        

    }


}












?>
