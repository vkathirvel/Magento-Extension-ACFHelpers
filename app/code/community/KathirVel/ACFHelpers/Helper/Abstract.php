<?php

/**
 * KathirVel ACFHelpers Helper Abstract
 *
 * @package     KathirVel_ACFHelpers
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class KathirVel_ACFHelpers_Helper_Abstract extends Mage_Core_Helper_Abstract
{

    /**
     * Stringify attributes for use in HTML tags.
     *
     * Helper function used to convert a string, array, or object
     * of attributes to a string.
     *
     * @param	mixed	string, array, object
     * @param	bool
     * @return	string
     */
    public function stringifyAttributes($attributes, $js = FALSE)
    {
        $atts = NULL;
        if (empty($attributes)) {
            return $atts;
        }
        if (is_string($attributes)) {
            return ' ' . $attributes;
        }
        $attributes = (array) $attributes;
        foreach ($attributes as $key => $val) {
            $atts .= ($js) ? $key . '=' . $val . ',' : ' ' . $key . '="' . $val . '"';
        }
        return rtrim($atts, ',');
    }

    public function linkHtml($linkedContent, $attributes)
    {
        $html = FALSE;
        $attributes = (array) $attributes;
        if ($linkedContent) {
            $html = $linkedContent;
            if (isset($attributes['href']) AND $attributes['href']) {
                $html = '<a' . Mage::helper('acfhelpers')->stringifyAttributes($attributes) . '>' . $linkedContent . '</a>';
            }
        }
        return $html;
    }

}
