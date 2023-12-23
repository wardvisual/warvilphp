@echo off
set /p controllerName="Enter the name of the controller: "

echo ^<?php > "app/controllers/%controllerName%.php"
echo. >> "app/controllers/%controllerName%.php"
echo use \app\core\Controller; >> "app/controllers/%controllerName%.php"
echo. >> "app/controllers/%controllerName%.php"
echo class %controllerName% extends Controller >> "app/controllers/%controllerName%.php"
echo { >> "app/controllers/%controllerName%.php"
echo. >> "app/controllers/%controllerName%.php"
echo     /** >> "app/controllers/%controllerName%.php"
echo      * Display the index page. >> "app/controllers/%controllerName%.php"
echo      */ >> "app/controllers/%controllerName%.php"
echo     public function index(): void >> "app/controllers/%controllerName%.php"
echo     { >> "app/controllers/%controllerName%.php"
echo         $this-^>view('%controllerName%/index'); >> "app/controllers/%controllerName%.php"
echo     } >> "app/controllers/%controllerName%.php"
echo } >> "app/controllers/%controllerName%.php"
echo. >> "app/controllers/%controllerName%.php"

echo Controller %controllerName%.php has been created in the app/controllers directory.