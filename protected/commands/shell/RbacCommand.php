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
        //ensure that an authManager is defined as this is mandatory for creating an auth heirarchy
        if(($this->_authManager=Yii::app()->authManager)===null)
        {
	        echo "Error: an authorization manager, named 'authManager' must be configured to use this command.\n";
            echo "If you already added 'authManager' component in application configuration,\n";
            echo "please quit and re-enter the yiic shell.\n";
            return;
        }  
        
//provide the oportunity for the use to abort the request
        echo "This command will create three roles: Owner, Member, and customer and the following premissions:\n";
        echo "create, read, update and delete user\n";
        echo "create, read, update and delete shops\n";
        echo "create, read, update and delete products\n";
        echo "create, read, update and delete products categories\n";
        echo "Would you like to continue? [Yes|No] ";
       
//check the input from the user and continue if they indicated yes to the above question
        if(!strncasecmp(trim(fgets(STDIN)),'y',1)) 
        {
//first we need to remove all operations, roles, child relationship and assignments
             $this->_authManager->clearAll();
//create the lowest level operations for users
             $this->_authManager->createOperation("createUser","create a new user"); 
           	 $this->_authManager->createOperation("readUser","read user profile information"); 
             $this->_authManager->createOperation("updateUser","update a users information"); 
             $this->_authManager->createOperation("deleteUser","remove a user from a Shop"); 
//create the lowest level operations for Shops
             $this->_authManager->createOperation("createShop","create a new shop"); 
             $this->_authManager->createOperation("readShop","read Shop information"); 
             $this->_authManager->createOperation("updateShop","update Shop information"); 
             $this->_authManager->createOperation("deleteShop","delete a Shop"); 
//create the lowest level operations for Products
			$this->_authManager->createOperation("createProduct","create a new Product"); 
             $this->_authManager->createOperation("readProduct","read Product information"); 
             $this->_authManager->createOperation("updateProduct","update Product information"); 
             $this->_authManager->createOperation("deleteProduct","delete an Product from a Shop");
             
             
             
//create the lowest level operation for Product_category
			$this->_authManager->createOperation("createProductCategory","create a new ProductCategory"); 
             $this->_authManager->createOperation("readProductCategory","read ProductCategory information"); 
             $this->_authManager->createOperation("updateProductCategory","update ProductCategory information"); 
             $this->_authManager->createOperation("deleteProductCategory","delete an ProductCategory from a Shop");


			//create the tasks for shop owners 
				$bizRule='return Yii::app()->user->id==$params["shop"]->user_id;';
    			$task= $this->_authManager->createTask('updateOwnShop', 'update a shop by owner himself', $bizRule);
    			$task->addChild('updateShop');
				
    			

//create the customer role and add the appropriate permissions aschildren to this role

             $role=$this->_authManager->createRole("customer"); 
             $role->addChild("readUser");
             $role->addChild("readShop"); 
             $role->addChild("readProduct"); 
//create the member role, and add the appropriate permissions, as well as the customer role itself, as children
             $role=$this->_authManager->createRole("member"); 
             $role->addChild("customer"); 
             $role->addChild("createProduct"); 
             $role->addChild("updateProduct"); 
             $role->addChild("deleteProduct"); 
//create the owner role, and add the appropriate permissions, as well as both the customer and member roles as children
             $role=$this->_authManager->createRole("owner"); 
             $role->addChild("customer"); 
             $role->addChild("member");    
             $role->addChild("createUser"); 
             $role->addChild("updateUser"); 
             $role->addChild("deleteUser");  
             $role->addChild("createShop"); 
             $role->addChild("updateShop"); 
             $role->addChild("deleteShop");    
        
             //provide a message indicating success
             echo "Authorization hierarchy successfully generated.";
        } 
    }
}












?>
