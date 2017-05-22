<?php

namespace Wasabi\Core\View\Helper;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\View\Helper;
use FrankFoerster\Filter\Model\Table\FiltersTable;
use Wasabi\Core\Model\Entity\User;

class RouteHelper extends Helper
{
    /**
     * Register route.
     *
     * @return array
     */
    public static function register()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Users',
            'action' => 'register'
        ];
    }

    /**
     * Login route.
     *
     * @return array
     */
    public static function login()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Users',
            'action' => 'login'
        ];
    }

    /**
     * Logout route.
     *
     * @return array
     */
    public static function logout()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Users',
            'action' => 'logout'
        ];
    }

    /**
     * Lost password route.
     *
     * @return array
     */
    public static function lostPassword()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Users',
            'action' => 'lostPassword'
        ];
    }

    /**
     * Profile route.
     *
     * @return array
     */
    public static function profile()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Users',
            'action' => 'profile'
        ];
    }

    /**
     * Dashboard index route.
     *
     * @return array
     */
    public static function dashboardIndex()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Dashboard',
            'action' => 'index'
        ];
    }

    /**
     * Users index route.
     *
     * @return array
     */
    public static function usersIndex()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Users',
            'action' => 'index'
        ];
    }

    /**
     * Users index route filtered by active users.
     *
     * @return array
     */
    public static function usersIndexActive()
    {
        return self::_filterUrl(self::usersIndex(), [
            'status' => User::STATUS_ACTIVE
        ]);
    }

    /**
     * Users index route filtered by inactive users.
     *
     * @return array
     */
    public static function usersIndexInactive()
    {
        return self::_filterUrl(self::usersIndex(), [
            'status' => User::STATUS_INACTIVE
        ]);
    }

    /**
     * Users index route filtered by verified users.
     *
     * @return array
     */
    public static function usersIndexVerified()
    {
        return self::_filterUrl(self::usersIndex(), [
            'status' => User::STATUS_VERIFIED
        ]);
    }

    /**
     * Users index route filtered by not verified users.
     *
     * @return array
     */
    public static function usersIndexNotVerified()
    {
        return self::_filterUrl(self::usersIndex(), [
            'status' => User::STATUS_NOTVERIFIED
        ]);
    }

    /**
     * Add user route.
     *
     * @return array
     */
    public static function usersAdd()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Users',
            'action' => 'add'
        ];
    }

    /**
     * Edit user route.
     *
     * @param integer|string $id
     * @return array
     */
    public static function usersEdit($id)
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Users',
            'action' => 'edit',
            'id' => $id
        ];
    }

    /**
     * Delete user route.
     *
     * @param integer|string $id
     * @return array
     */
    public static function usersDelete($id)
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Users',
            'action' => 'delete',
            'id' => $id
        ];
    }

    /**
     * Verify user route.
     *
     * @param integer|string $id
     * @return array
     */
    public static function usersVerify($id)
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Users',
            'action' => 'verify',
            'id' => $id
        ];
    }

    /**
     * Activate user route.
     *
     * @param integer|string $id
     * @return array
     */
    public static function usersActivate($id)
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Users',
            'action' => 'activate',
            'id' => $id
        ];
    }

    /**
     * Deactivate user route.
     *
     * @param integer|string $id
     * @return array
     */
    public static function usersDeactivate($id)
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Users',
            'action' => 'deactivate',
            'id' => $id
        ];
    }

    /**
     * Groups index route.
     *
     * @return array
     */
    public static function groupsIndex()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Groups',
            'action' => 'index'
        ];
    }

    /**
     * Add group route.
     *
     * @return array
     */
    public static function groupsAdd()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Groups',
            'action' => 'add'
        ];
    }

    /**
     * Edit group route.
     *
     * @param integer|string $id
     * @return array
     */
    public static function groupsEdit($id)
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Groups',
            'action' => 'edit',
            'id' => $id
        ];
    }

    /**
     * Delete group route.
     *
     * @param integer|string $id
     * @return array
     */
    public static function groupsDelete($id)
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Groups',
            'action' => 'delete',
            'id' => $id
        ];
    }

    /**
     * Languages index route.
     *
     * @return array
     */
    public static function languagesIndex()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Languages',
            'action' => 'index'
        ];
    }

    /**
     * Add language route.
     *
     * @return array
     */
    public static function languagesAdd()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Languages',
            'action' => 'add'
        ];
    }

    /**
     * Edit language route.
     *
     * @param integer|string $id
     * @return array
     */
    public static function languagesEdit($id)
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Languages',
            'action' => 'edit',
            'id' => $id
        ];
    }

    /**
     * Delete language route.
     *
     * @param integer|string $id
     * @return array
     */
    public static function languagesDelete($id)
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Languages',
            'action' => 'delete',
            'id' => $id
        ];
    }

    /**
     * Change language route.
     *
     * @param integer|string $id
     * @return array
     */
    public static function languagesChange($id)
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Languages',
            'action' => 'change',
            'id' => $id
        ];
    }

    /**
     * Sort languages route.
     *
     * @return array
     */
    public static function languagesSort()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Languages',
            'action' => 'sort'
        ];
    }

    /**
     * Permissions index route.
     *
     * @return array
     */
    public static function permissionsIndex()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Permissions',
            'action' => 'index'
        ];
    }

    /**
     * Update permissions route.
     *
     * @return array
     */
    public static function permissionsUpdate()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Permissions',
            'action' => 'update'
        ];
    }

    /**
     * Cache settings route.
     *
     * @return array
     */
    public static function settingsCache()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Settings',
            'action' => 'cache'
        ];
    }

    /**
     * General settings route.
     *
     * @return array
     */
    public static function settingsGeneral()
    {
        return [
            'plugin' => 'Wasabi/Core',
            'controller' => 'Settings',
            'action' => 'general'
        ];
    }

    /**
     * Create or get an existing filter url for the given $url array and the provided $filterData.
     *
     * @param array $url
     * @param array $filterData
     * @return array
     */
    protected static function _filterUrl(array $url, array $filterData)
    {
        // Find or create a filter slug for each category to link to Ideas::index() and only
        // display a single category/topic.
        $fakeRequest = clone Router::getRequest();
        $fakeRequest->params = $url;

        /** @var FiltersTable $FiltersTable */
        $FiltersTable = TableRegistry::get('FrankFoerster/Filter.Filters');

        $filter = $FiltersTable->find('slugForFilterData', [
            'request' => $fakeRequest,
            'filterData' => $filterData
        ])->first();
        if (!$filter) {
            $slug = $FiltersTable->createFilterForFilterData($fakeRequest, $filterData);
        } else {
            $slug = $filter->slug;
        }

        $url['sluggedFilter'] = $slug;

        return $url;
    }
}