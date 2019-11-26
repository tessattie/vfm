<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        define("ROOT_DIREC", '/vfm');

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            'loginRedirect' => [
                'controller' => 'Products',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login']
        ]);


        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }


    public function beforeFilter(Event $event){
        if($this->Auth->user()){
            $this->set('status', array(0 => "Inactif", 1 => "Actif"));
            $this->set('types_reductions', array(0 => "USD", 1 => "%"));
            $this->set('user_connected', $this->Auth->user());
        }
    }


    protected function checkfile($file, $name, $directory){
        $allowed_extensions = array('jpg', "JPG", "jpeg", "JPEG", "png", "PNG");
        if(!$file['error']){
            $extension = explode("/", $file['type'])[1];
            if(in_array($extension, $allowed_extensions)){
                $dossier = 'C:/wamp/www'.ROOT_DIREC.'/webroot/img/'.$directory.'/';
                // $dossier = '/home2/karimark/public_html'.ROOT_DIREC.'/webroot/img/'.$directory.'/';
                if(move_uploaded_file($file['tmp_name'], $dossier . $name . "." . $extension)){
                    return $name . "." . $extension;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


}
