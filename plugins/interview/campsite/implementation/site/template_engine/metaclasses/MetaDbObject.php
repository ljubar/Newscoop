<?php
/**
 * @package Campsite
 */

/**
 * Includes
 */
// We indirectly reference the DOCUMENT_ROOT so we can enable
// scripts to use this file from the command line, $_SERVER['DOCUMENT_ROOT']
// is not defined in these cases.
$g_documentRoot = $_SERVER['DOCUMENT_ROOT'];

require_once($g_documentRoot.'/template_engine/classes/Exceptions.php');


/**
 * @package Campsite
 */
class MetaDbObject {
    //
    protected $m_dbObject = null;

    protected $m_properties = null;

    protected $m_customProperties = null;

    protected $m_getPropertyMethod = 'getProperty';


    public function __get($p_property)
    {
        if (!$this->defined()) {
            return null;
        }
        $property = $this->translateProperty($p_property);

        try {
            if (array_search($property, $this->m_properties)) {
                $methodName = $this->m_getPropertyMethod;
                return $this->m_dbObject->$methodName($property);
            } elseif (array_key_exists($property, $this->m_customProperties)) {
                return $this->getCustomProperty($property);
            } else {
                $this->trigger_invalid_property_error($p_property);
                return null;
            }
        } catch (InvalidPropertyException $e) {
            $this->trigger_invalid_property_error($p_property);
        	return null;
        }
    } // fn __get


    final public function __set($p_property, $p_value)
    {
        throw new InvalidFunctionException(get_class($this), '__set');
    } // fn __set


    final public function __unset($p_property)
    {
        throw new InvalidFunctionException(get_class($this), '__unset');
    } // fn __set


    /**
     * Returns true if the article has a property with the given name
     *
     * @return bool
     */
    public function has_property($p_property) {
        $p_property = $this->translateProperty($p_property);
        return (is_array($this->m_properties)
        && array_key_exists($p_property, $this->m_properties))
        || (is_array($this->m_customProperties)
        && array_key_exists($p_property, $this->m_customProperties));
    }


    final public function defined()
    {
        return is_object($this->m_dbObject) && $this->m_dbObject->exists();
    } // fn defined


    final public function translateProperty($p_property)
    {
        $p_property = strtolower($p_property);
        if (is_array($this->m_properties) && isset($this->m_properties[$p_property])) {
        	return $this->m_properties[$p_property];
        }
    	return $p_property;
    }


    protected function getCustomProperty($p_property)
    {
    	if (!is_array($this->m_customProperties)
    			|| !array_key_exists($p_property, $this->m_customProperties)) {
	    	throw new InvalidPropertyException(get_class($this->m_dbObject), $p_property);
    	}
    	if (!method_exists($this, $this->m_customProperties[$p_property])) {
    		throw new InvalidPropertyHandlerException(get_class($this->m_dbObject), $p_property);
    	}
    	$methodName = $this->m_customProperties[$p_property];
    	return $this->$methodName();
    }


    protected function trigger_invalid_property_error($p_property, $p_smarty = null)
    {
    	$errorMessage = INVALID_PROPERTY_STRING . " $p_property "
        				. OF_OBJECT_STRING . ' ' . get_class($this->m_dbObject);
		CampTemplate::singleton()->trigger_error($errorMessage, $p_smarty);
    }


    final public function trigger_invalid_value_error($p_property, $p_value, $p_smarty = null)
    {
    	$errorMessage = INVALID_VALUE_STRING . " $p_value "
        				. OF_PROPERTY_STRING . " $p_property "
        				. OF_OBJECT_STRING . ' ' . get_class($this->m_dbObject);
		CampTemplate::singleton()->trigger_error($errorMessage, $p_smarty);
    }
}

?>