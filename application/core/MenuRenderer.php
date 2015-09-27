<?php

use Knp\Menu\Renderer\ListRenderer;
use Knp\Menu\ItemInterface;

class MenuRenderer extends ListRenderer
{
	protected function renderList(ItemInterface $item, array $attributes, array $options)
    {
        /**
         * Return an empty string if any of the following are true:
         *   a) The menu has no children eligible to be displayed
         *   b) The depth is 0
         *   c) This menu item has been explicitly set to hide its children
         */
        if (!$item->hasChildren() || 0 === $options['depth'] || !$item->getDisplayChildren()) {
            return '';
        }

        $html = $this->format('<ul '.$this->renderHtmlAttributes($attributes).'>', 'ul', $item->getLevel(), $options);
        $html .= $this->renderChildren($item, $options);
        $html .= $this->format('</ul>', 'ul', $item->getLevel(), $options);

        echo "<pre>";
        print_r($options);
        echo "</pre>";
        return $html;
    }

    protected function renderChildren(ItemInterface $item, array $options)
    {
        // render children with a depth - 1
        if (null !== $options['depth']) {
            $options['depth'] = $options['depth'] - 1;
        }

        if (null !== $options['matchingDepth'] && $options['matchingDepth'] > 0) {
            $options['matchingDepth'] = $options['matchingDepth'] - 1;
        }

        $html = '';
        foreach ($item->getChildren() as $child) {
            $html .= $this->renderItem($child, $options);
        }

        return $html;
    }

     protected function renderItem(ItemInterface $item, array $options)
    {
        // if we don't have access or this item is marked to not be shown
        if (!$item->isDisplayed()) {
            return '';
        }

        // create an array than can be imploded as a class list
        $class = (array) $item->getAttribute('class');

        if ($this->matcher->isCurrent($item)) {
            $class[] = $options['currentClass'];
        } elseif ($this->matcher->isAncestor($item, $options['matchingDepth'])) {
            $class[] = $options['ancestorClass'];
        }

        if ($item->actsLikeFirst()) {
            $class[] = $options['firstClass'];
        }
        if ($item->actsLikeLast()) {
            $class[] = $options['lastClass'];
        }

        if ($item->hasChildren() && $options['depth'] !== 0) {
            if (null !== $options['branch_class'] && $item->getDisplayChildren()) {
                $class[] = $options['branch_class'];
            }
        } elseif (null !== $options['leaf_class']) {
            $class[] = $options['leaf_class'];
        }

        // retrieve the attributes and put the final class string back on it
        $attributes = $item->getAttributes();
        if (!empty($class)) {
            $attributes['class'] = implode(' ', $class);
        }

        // opening li tag
        $html = $this->format('<li'.$this->renderHtmlAttributes($attributes).'>', 'li', $item->getLevel(), $options);

        // render the text/link inside the li tag
        //$html .= $this->format($item->getUri() ? $item->renderLink() : $item->renderLabel(), 'link', $item->getLevel());
        $html .= $this->renderLink($item, $options);

        // renders the embedded ul
        $childrenClass = (array) $item->getChildrenAttribute('class');
        $childrenClass[] = 'menu_level_'.$item->getLevel();

        $childrenAttributes = $item->getChildrenAttributes();
        $childrenAttributes['class'] = implode(' ', $childrenClass);

        $html .= $this->renderList($item, $childrenAttributes, $options);

        // closing li tag
        $html .= $this->format('</li>', 'li', $item->getLevel(), $options);

        return $html;
    }
}
