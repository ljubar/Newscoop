<?php
/**
 * @package Campsite
 *
 * @author Sebastian Goebel <sebastian.goebel@web.de>
 * @copyright 2007 MDLF, Inc.
 * @license http://www.gnu.org/licenses/gpl.txt
 * @version $Revision$
 * @link http://www.campware.org
 */

final class MetaBlog extends MetaDbObject {

    private function InitProperties()
    {
        if (!is_null($this->m_properties)) {
            return;
        }
        $this->m_properties['identifier'] = 'blog_id';
        $this->m_properties['language_id'] = 'fk_language_id';
        $this->m_properties['user_id'] = 'fk_user_id';
        $this->m_properties['title'] = 'title';
        $this->m_properties['name'] = 'title';
        $this->m_properties['published'] = 'published';
        $this->m_properties['info'] = 'info';
        //$this->m_properties['tags'] = 'tags';
        $this->m_properties['admin_remark'] = 'admin_remark';
        $this->m_properties['request_text'] = 'request_text';
        $this->m_properties['status'] = 'status';
        $this->m_properties['admin_status'] = 'admin_status';
        $this->m_properties['entries_online'] = 'entries_online';
        $this->m_properties['entries_offline'] = 'entries_offline';
        $this->m_properties['feature'] = 'feature';
    }


    public function __construct($p_blog_id=null)
    {
        $this->m_dbObject = new Blog($p_blog_id);

        $this->InitProperties();
        $this->m_customProperties['defined'] = 'defined';
    } // fn __construct

} // class MetaBlog

?>