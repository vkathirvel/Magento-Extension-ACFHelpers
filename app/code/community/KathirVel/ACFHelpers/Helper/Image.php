<?php

/**
 * KathirVel ACFHelpers Helper Image
 *
 * @package     KathirVel_ACFHelpers
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class KathirVel_ACFHelpers_Helper_Image extends KathirVel_ACFHelpers_Helper_Abstract
{

    public function imageHtml($imageArray, $imageAttributes = array())
    {
        $imageHtml = FALSE;
        if ($imageArray) {
            if (is_object($imageArray)) {
                $imageArray = (array) $imageArray;
            }
            if (isset($imageArray['url'])) {
                // Layered Image - using caption and description
                $layeredImageArgs = FALSE;
                if (isset($imageAttributes['layered_image_options']) AND is_array($imageAttributes['layered_image_options'])) {
                    $layeredImageArgs = $imageAttributes['layered_image_options'];
                    $layeredImageArgsDefaults = array(
                            'container_div_attributes' => array('class' => 'layered-image-container'),
                            'image_div_attributes' => array('class' => 'layered-image-image'),
                            'bootstrap_container' => FALSE,
                            'caption_element' => 'div',
                            'caption_div_attributes' => array('class' => 'layered-image-caption'),
                            'description_element' => 'div',
                            'description_div_attributes' => array('class' => 'layered-image-description'),
                    );
                    $layeredImageArgs = array_merge($layeredImageArgsDefaults, $layeredImageArgs);
                }
                if (isset($imageAttributes['layered_image_options'])) {
                    unset($imageAttributes['layered_image_options']);
                }
                $imageArrayAttributes = array();
                if ($imageArray['url']) {
                    $imageArrayAttributes['src'] = $imageArray['url'];
                }
                if ($imageArray['alt']) {
                    $imageArrayAttributes['alt'] = $imageArray['alt'];
                } elseif ($imageArray['title']) {
                    $imageArrayAttributes['alt'] = $imageArray['title'];
                }
                $imageAttributes = array_merge($imageArrayAttributes, $imageAttributes);
                $imageHtml = '';
                $imageHtml .= '<img' . Mage::helper('acfhelpers')->stringifyAttributes($imageAttributes) . '>';
                // Layered Image - using caption and description
                if ($layeredImageArgs) {
                    $layeredImageHtml = '';
                    $layeredImageHtml .= '<div' . Mage::helper('acfhelpers')->stringifyAttributes($layeredImageArgs['container_div_attributes']) . '>';
                    $layeredImageHtml .= '<div' . Mage::helper('acfhelpers')->stringifyAttributes($layeredImageArgs['image_div_attributes']) . '>';
                    $layeredImageHtml .= $imageHtml;
                    $layeredImageHtml .= '</div>';
                    if ($layeredImageArgs['bootstrap_container']) {
                        $layeredImageHtml .= '<div class="container">';
                    }
                    if ($imageArray['caption']) {
                        $layeredImageHtml .= '<' . $layeredImageArgs['caption_element'] . Mage::helper('acfhelpers')->stringifyAttributes($layeredImageArgs['caption_div_attributes']) . '>';
                        $layeredImageHtml .= $imageArray['caption'];
                        $layeredImageHtml .= '</' . $layeredImageArgs['caption_element'] . '>';
                    }
                    if ($imageArray['description']) {
                        $layeredImageHtml .= '<' . $layeredImageArgs['description_element'] . Mage::helper('acfhelpers')->stringifyAttributes($layeredImageArgs['description_div_attributes']) . '>';
                        $layeredImageHtml .= $imageArray['description'];
                        $layeredImageHtml .= '</' . $layeredImageArgs['description_element'] . '>';
                    }
                    if ($layeredImageArgs['bootstrap_container']) {
                        $layeredImageHtml .= '</div>';
                    }
                    $layeredImageHtml .= '</div>';
                    $imageHtml = $layeredImageHtml;
                }
            }
        }
        return $imageHtml;
    }

    public function imageHtmlFishpig($imageArray, $imageAttributes = array())
    {
        $imageHtml = FALSE;
        $imageNewArray = array();
        if ($imageArray) {
            if (is_object($imageArray)) {
                $imageArray = (array) $imageArray;
            }
            if (isset($imageArray['object'])) {
                $image = $imageArray['object'];
                $imageNewArray['url'] = $image->getData('guid');
                $imageNewArray['alt'] = $image->getData('post_title');
                $imageNewArray['title'] = $image->getData('post_title');
                $imageNewArray['caption'] = $image->getData('post_content');
                $imageNewArray['description'] = $image->getData('post_excerpt');

                $imageHtml = $this->imageHtml($imageNewArray, $imageAttributes);
            }
        }
        return $imageHtml;
    }

}
