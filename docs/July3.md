## July 3 Progress

1.	Created 'ui_helper' helper.
2.	Load the backend method from helper class without passing any argument but to use the same method for frontend pass the boolean false on first argument.(todo later).

## Backend Controller
1.	Added a common `$templateData['modulePath']` on the constructor which inturn calls the `getModulePath()`.
2.	Now, we can only define the subview location inside the `modules/views/backend/` folder on `$this->templateData['content']=<filename>`.