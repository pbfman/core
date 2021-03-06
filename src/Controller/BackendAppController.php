<?php
/**
 * Wasabi Core
 * Copyright (c) Frank Förster (http://frankfoerster.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Frank Förster (http://frankfoerster.com)
 * @link          https://github.com/wasabi-cms/core Wasabi Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Wasabi\Core\Controller;

use Cake\Controller\Component\AuthComponent;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Session;
use Cake\Utility\Text;
use Wasabi\Core\Model\Entity\User;
use Wasabi\Core\Nav;
use Wasabi\Core\Wasabi;

/**
 * Class BackendAppController
 *
 * @property \Wasabi\Core\Controller\Component\GuardianComponent $Guardian
 */
class BackendAppController extends AppController
{
    /**
     * Default Flash message when form errors are present.
     *
     * @var string
     */
    public $formErrorMessage;

    /**
     * Default Flash message when a request is invalid.
     *
     * @var string
     */
    public $invalidRequestMessage;

    /**
     * Default Flash message when a database request produced an error.
     *
     * @var string
     */
    public $dbErrorMessage;

    /**
     * The name of the View class this controller sends output to.
     *
     * @var string
     */
    public $viewClass = 'Wasabi/Core.App';

    /**
     * @var \Mobile_Detect
     */
    public $detect;

    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $fieldIdentity = Wasabi::setting('Core.auth.identity_field') ?? 'email';
        $fieldPassword = Wasabi::setting('Core.auth.password_field') ?? 'password';

        $this->loadComponent('Auth', [
            'authenticate' => [
                AuthComponent::ALL => [
                    'userModel' => 'Wasabi/Core.Users',
                ],
                'Form' => [
                    'fields' => [
                        'username' => $fieldIdentity,
                        'password' => $fieldPassword
                    ]
                ]
            ],
            'loginAction' => [
                'plugin' => 'Wasabi/Core',
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginRedirect' => [
                'plugin' => 'Wasabi/Core',
                'controller' => 'Dashboard',
                'action' => 'index'
            ],
            'unauthorizedRedirect' => [
                'plugin' => 'Wasabi/Core',
                'controller' => 'Users',
                'action' => 'unauthorized'
            ],
            'authorize' => 'Controller',
            'authError' => __d('wasabi_core', 'You are not authorized to access that location.')
        ]);

        $this->loadComponent('Wasabi/Core.Guardian');
        $this->loadComponent('Wasabi/Core.Flash');

        // Setup default flash messages.
        $this->formErrorMessage = __d('wasabi_core', 'Please correct the marked errors.');
        $this->invalidRequestMessage = __d('wasabi_core', 'Invalid Request.');
        $this->dbErrorMessage = __d('wasabi_core', 'Something went wrong. Please try again.');

        $this->detect = new \Mobile_Detect();
    }

    /**
     * beforeFilter callback
     *
     * @param Event $event An Event instance.
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->deny();

        if (!$this->Auth->user()) {
            $this->Auth->config('authError', false);
        } else {
            Wasabi::user(new User($this->Auth->user()));

            $currentUrlArray = Wasabi::getCurrentUrlArray();
            $currentRequestPath = join('.', [
                $currentUrlArray['plugin'],
                $currentUrlArray['controller'],
                $currentUrlArray['action']
            ]);

            if (!$this->request->is('ajax') || $currentRequestPath !== 'Wasabi/Core.Users.heartBeat') {
                $this->request->session()->write('loginTime', time());
            }
        }

        $this->_allow();

        Wasabi::loadLanguages(null, true);

        // Load all menu items from all plugins.
        $this->eventManager()->dispatch(new Event('Wasabi.Backend.Menu.initMain', Nav::createMenu('backend.main')));

        $this->_setSectionCssClass();

        $this->set('heartBeatFrequency', $this->_calculateHeartBeatFrequency());
        if (isset($_COOKIE['sidebar-collapsed'])) {
            $this->set('sidebarCollapsed', (bool)$_COOKIE['sidebar-collapsed'] ? 'sidebar-is-collapsed' : '');
        }

        if ($this->request->is('ajax')) {
            $this->viewClass = null;
        }
    }

    /**
     * beforeRender callback
     *
     * - setup global view/layout variables
     *
     * @param Event $event An Event instance.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);

        $this->set('detect', $this->detect);
    }

    /**
     * Check if the current request needs an authenticated user.
     * Check if the user is authorized to complete the request.
     *
     * @return bool
     */
    public function isAuthorized()
    {
        $url = Wasabi::getCurrentUrlArray();
        return $this->Guardian->hasAccess($url);
    }

    /**
     * Allow all guest actions.
     *
     * @return void
     */
    protected function _allow()
    {
        $url = Wasabi::getCurrentUrlArray();
        if ($this->Guardian->isGuestAction($url)) {
            $this->Auth->allow($this->request->params['action']);
        }
    }

    /**
     * Set the section css class that is applied to the html body of the action.
     * Format is "prefix--controller-action" where prefix is either "app" or the name of the plugin.
     *
     * @return void
     */
    protected function _setSectionCssClass()
    {
        $plugin = $this->request->params['plugin'];
        $prefix = ($plugin !== null) ? $plugin : 'app';
        $this->set(
            'sectionCssClass',
            strtolower(
                Text::slug($prefix) . '--' .
                preg_replace('/\\//', '--', $this->request->params['controller']) . '-' .
                $this->request->params['action']
            )
        );
    }

    /**
     * Calculate the heartBeat frequency 1/5th of session.gc_maxlifetime.
     *
     * @return int frequency in ms
     */
    protected function _calculateHeartBeatFrequency()
    {
        return (int)floor(((int)ini_get('session.gc_maxlifetime')) / 5) * 1000;
    }
}
