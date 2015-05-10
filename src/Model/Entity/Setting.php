<?php
/**
 * Wasabi CMS
 * Copyright (c) Frank Förster (http://frankfoerster.com)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Frank Förster (http://frankfoerster.com)
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Wasabi\Core\Model\Entity;

use Cake\ORM\Entity;

class Setting extends Entity
{
    /**
     * Skip error checking for the actual save operation since
     * the entity is checked for errors manually within the KeyValueBehavior.
     *
     * @param string|array|null $field The field to get errors for, or the array of errors to set.
     * @param string|array|null $errors The errors to be set for $field
     * @param bool $overwrite Whether or not to overwrite pre-existing errors for $field
     * @return array|$this
     */
    public function errors($field = null, $errors = null, $overwrite = false)
    {
        if (isset($this->_properties['scope'])) {
            $this->_errors = [];
        }

        return parent::errors($field, $errors, $overwrite);
    }
}
