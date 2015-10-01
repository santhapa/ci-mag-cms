<?php
use Knp\Menu\MenuItem as BaseMenuItem;

class MenuItem extends BaseMenuItem
{
	protected $icon;

    protected $permissions = array();

	public function getIcon()
	{
		return $this->icon ? 'fa fa-'.$this->icon : 'fa fa-circle-o';
	}

	public function setIcon($icon)
	{
		$this->icon = $icon;
		return $this;
	}

    public function setPermissions($perms = array())
    {
        if(is_array($perms))
        {
            $this->permissions = $perms;
            return $this;
        }else{
            $permission = array();
            $permission[] = $perms;
            $this->permissions = $permission;
            return $this;
        }
    }

    public function getPermissions()
    {
        return $this->permissions;
    }
}

use Knp\Menu\MenuFactory as BaseMenuFactory;
class MenuFactory extends BaseMenuFactory
{
    private $extensions = array();

    private $sorted;

    public function createItem($name, array $options = array())
    {
        foreach ($this->getExtensions() as $extension) {
            $options = $extension->buildOptions($options);
        }

        $item = new MenuItem($name, $this);

        foreach ($this->getExtensions() as $extension) {
            $extension->buildItem($item, $options);
        }

        return $item;
    }

    private function getExtensions()
    {
        if (null === $this->sorted) {
            krsort($this->extensions);
            $this->sorted = !empty($this->extensions) ? call_user_func_array('array_merge', $this->extensions) : array();
        }

        return $this->sorted;
    }
}
