<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

/** @var JPaginationObject $item */
$item = $displayData['data'];
$display = $item->text;

switch ((string) $item->text) {
	// Check for "Start" item
	case JText::_('JLIB_HTML_START') :
		$icon = 'icon-backward icon-first';
		break;

	// Check for "Prev" item
	case $item->text === JText::_('JPREV') :
		$item->text = JText::_('JPREVIOUS');
		$icon = 'icon-step-backward icon-previous';
		break;

	// Check for "Next" item
	case JText::_('JNEXT') :
		$icon = 'icon-step-forward icon-next';
		break;

	// Check for "End" item
	case JText::_('JLIB_HTML_END') :
		$icon = 'icon-forward icon-last';
		break;

	default:
		$icon = null;
		break;
}

if ($icon !== null) {
	$display = '<span class="' . $icon . '"></span>';
}

if ($displayData['active']) {
	if ($item->base > 0) {
		$limit = 'limitstart.value=' . $item->base;
	}	else	{
		$limit = 'limitstart.value=0';
	}

	$cssClasses = array();

	$title = '';

	if (!is_numeric($item->text)) {
		JHtml::_('bootstrap.tooltip');
		$cssClasses[] = 'hasTooltip';
		$title = ' title="' . $item->text . '" ';
	}

	$onClick = 'document.adminForm.' . $item->prefix . 'limitstart.value=' . ($item->base > 0 ? $item->base : '0') . '; Joomla.submitform();return false;';
} else {
	$class = (property_exists($item, 'active') && $item->active) ? 'active' : 'disabled';
}

if ($displayData['active']) {
	echo '<li>';
	echo '<a ' . ($cssClasses ? 'class="' . implode(' ', $cssClasses) . '"' : '') . ' ';
  echo $title . 'href="#" onclick="' . $onClick . '">';
	echo $display;
	echo '</a>';
	echo '</li>';
} else {
	echo '<li class="' . $class . '">';
	echo '<span>' . $display . '</span>';
	echo '</li>';
}
