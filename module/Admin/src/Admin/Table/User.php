<?php
/**
 * Created by PhpStorm.
 * User: matveev
 * Date: 5/25/15
 * Time: 12:03 PM
 */

namespace Admin\Table;


use ZfTable\AbstractTable;

/**
 * Class User
 *
 * @package Admin\Table
 */
class User extends AbstractTable
{
    const ALIAS = 'Admin\UserTable';

    /**
     * @var array
     */
    protected $config = [
        'name'              => 'Users',
        'showPagination'    => true,
        'showQuickSearch'   => false,
        'showItemPerPage'   => true,
        'showColumnFilters' => true
    ];

    /**
     * @var array
     */
    protected $headers = array(
        'id'       => ['tableAlias' => 'u', 'title' => 'Id', 'width' => '50'],
        'username' => ['tableAlias' => 'u', 'title' => 'Username', 'filters' => 'text'],
        'email'    => ['tableAlias' => 'u', 'title' => 'Email', 'width' => '250', 'filters' => 'text'],
        'roles'    => [
            'tableAlias' => 'r',
            'title'      => 'roles',
            'sortable'   => false,
            'width'      => '150',
            'filters'    => [
                null      => 'All',
                'admin'   => 'Admin',
                'user'    => 'User',
                'staffer' => 'Staffer'
            ]
        ],
        'state'     => [
            'tableAlias' => 'u', 'title' => 'state', 'sortable' => false, 'width' => '150',
            'filters'    => [
                null         => 'All',
                '1'     => 'Active',
                '2' => 'Registered',
                '3'    => 'Blocked'
            ]
        ],
        'actions'  => [
            'title' => 'Actions', 'width' => '200', 'sortable' => false
        ]
    );

    public function init()
    {
        $this->getHeader('roles')->getCell()->addDecorator('callable', array(
            'callable' => function ($context, $record) {
                $result = '';
                foreach ($record->getRoles() as $role) {
                    $result .= $role->getRoleId() . ' ';
                }

                return $result;
            }
        ));

        $this->getHeader('state')->getCell()->addDecorator('mapper', array(
            '1' => 'Active',
            '2' => 'Registered',
            '3' => 'Blocked'
        ));

        $this->getHeader('username')->getCell()->addDecorator('link', array(
            'url' => '/admin/user/%s',
            'vars' => array('id')
        ));

        $this->getHeader('actions')->getCell()->addDecorator('template', array(
            'template' => '<a href=\'user/edit/%s\'> edit</a>',
            'vars' => ['id', 'id']
        ));
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder $query
     */
    protected function initFilters($query)
    {
        if ($value = $this->getParamAdapter()->getValueOfFilter('roles')) {
            $query->andWhere('r.roleId = ?1')->setParameter('1', $value);
        }

        if ($value = $this->getParamAdapter()->getValueOfFilter('state')) {
            $query->andWhere('u.state = ?2')->setParameter('2', $value);
        }

        if ($value = $this->getParamAdapter()->getValueOfFilter('email')) {
            $query->andWhere($query->expr()->like('u.email', '?3'))->setParameter('3','%' . $value . '%');
        }

        if ($value = $this->getParamAdapter()->getValueOfFilter('username')) {
            $query->andWhere($query->expr()->like('u.username', '?4'))->setParameter('4','%' . $value . '%');
        }
    }


}