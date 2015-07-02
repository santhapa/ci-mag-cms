## Backend Controller
1. Load session library for all the controller that extends backend controller.
2. Make controller abstract such that the controller extending backend must declare the method `setModulePath()` and returning module path.

## Other works
1. Creating backend and frontend folders on views folder for different templating.
2. Set `$this->templateData['content'] = $this->getModulePath()."<file to load under modules views backend folder>"`.
3. Also declare, `setModulePath()` method to return module path for backend.

That's all for today!