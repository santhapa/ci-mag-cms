<?php

use Knp\Menu\Renderer\ListRenderer;
use Knp\Menu\ItemInterface;

class MenuRenderer extends ListRenderer
{
    protected function renderItem(ItemInterface $item, array $options)
    {
        if(!\App::isGranted($item->getPermissions()))
            return '';

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
        // $childrenClass[] = 'menu_level_'.$item->getLevel();

        $childrenAttributes = $item->getChildrenAttributes();
        // has been set implocitly here, can use ->setChildrenAttributes(array('class'=> 'treeview-menu')) while menu creating
        $childrenAttributes['class'] = 'treeview-menu';
        $childrenAttributes['class'] .= implode(' ', $childrenClass);

        $html .= $this->renderList($item, $childrenAttributes, $options);

        // closing li tag
        $html .= $this->format('</li>', 'li', $item->getLevel(), $options);

        return $html;
    }

    protected function renderSpanElement(ItemInterface $item, array $options)
    {
        return sprintf('<span%s>%s</span>', $this->renderHtmlAttributes($item->getLabelAttributes()), $item->getName());
    }

    protected function renderLabel(ItemInterface $item, array $options)
    {
        $html = '<i class="'.$item->getIcon().'"></i> ';
        $html .= '<span>'.$item->getLabel().'</span>';

        if($item->hasChildren())
        {
            $drop = false;
            foreach ($item->getChildren() as $child) {
                if(\App::isGranted($child->getPermissions()))
                    $drop = true;
            }
            if($drop)
                $html .= '<i class="fa fa-angle-left pull-right"></i>';
        }

        return $html;
    }
}
