<?php
/**
 * @copyright   Copyright (C) 2016 - 2018 Yaniz Corporation, All rights reserved.
 * @license     BSD 2 Clause; see LICENSE.txt or https://www.yaniz.co/resources/license/bsd-2-clause.html
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

$item = $this->item;
$params = $item->params;
$canEdit = $params->get('access-edit');
$posBlock = $params->get('info_block_position', 0);
$datetime = strtotime(JFactory::getDate());

// Check if associations are implemented. If they are, define the parameter.
$assocParam = (JLanguageAssociations::isEnabled() && $params->get('show_associations'));

// Is the article unpublished?
$unpublished = ($item->state == 0 || strtotime($item->publish_up) > $datetime
	              || ((strtotime($item->publish_down) < $datetime)
                && $item->publish_down != JFactory::getDbo()->getNullDate()));

$useDefList = ($params->get('show_modify_date')
               || $params->get('show_publish_date')
               || $params->get('show_create_date')
               || $params->get('show_hits')
               || $params->get('show_category')
               || $params->get('show_parent_category')
               || $params->get('show_author')
               || $assocParam);

if ($unpublished) {
	echo '<div class="system-unpublished">';
}

//Header

echo '<h3>' . $this->escape($item->title) . '</h3>';
echo '<div>';
echo JLayoutHelper::render('joomla.content.intro_image', $item);

if (!$params->get('show_intro')) {
	// Content is generated by content plugin event "onContentAfterTitle"
	echo $item->event->afterDisplayTitle;
}

// Content is generated by content plugin event "onContentBeforeDisplay"
echo $item->event->beforeDisplayContent;

echo $item->introtext;

if ($params->get('show_readmore') && $item->readmore) {
	if ($params->get('access-view')) {
		$link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language));
	} else {
		$menu = JFactory::getApplication()->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;
		$link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
		$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language)));
	}

	echo JLayoutHelper::render('joomla.content.readmore', array('item' => $item, 'params' => $params, 'link' => $link));
}

if ($unpublished) {
  echo '</div>';
}

// Content is generated by content plugin event "onContentAfterDisplay"
echo $item->event->afterDisplayContent;

echo '</div>';
