<?php
/**
 * API form element
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       (c) 2000-2016 API Project (www.api.org)
 * @license             GNU GPL 2 (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package             kernel
 * @subpackage          form
 * @since               2.0.0
 * @author              Kazumi Ono (AKA onokazu) http://www.myweb.ne.jp/, http://jp.api.org/
 */

defined('API_ROOT_PATH') || exit('Restricted access');

/**
 * Parent
 */
api_load('APIFormElement');

/**
 * A select field with a choice of available groups
 */
class APIFormSelectGroup extends APIFormSelect
{
    /**
     * Constructor
     *
     * @param string $caption
     * @param string $name
     * @param bool   $include_anon Include group "anonymous"?
     * @param mixed  $value        Pre-selected value (or array of them).
     * @param int    $size         Number or rows. "1" makes a drop-down-list.
     * @param bool   $multiple     Allow multiple selections?
     */
    public function __construct($caption, $name, $include_anon = false, $value = null, $size = 1, $multiple = false)
    {
        parent::__construct($caption, $name, $value, $size, $multiple);
        /* @var $member_handler APIMemberHandler */
        $member_handler = api_getHandler('member');
        if (!$include_anon) {
            $this->addOptionArray($member_handler->getGroupList(new Criteria('groupid', API_GROUP_ANONYMOUS, '!=')));
        } else {
            $this->addOptionArray($member_handler->getGroupList());
        }
    }
}
