<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/
/*
| -------------------------------------------------------------------
| CodeIgniter 3 PSR-4 Autoloader for Application
| -------------------------------------------------------------------
| By default, all PSR-4 namespace with `app` prefix in Codeigniter would relates
| to application directory.
| - The class `/application/libraries/MemberService.php` could be called by:
| ```php
| new \app\libraries\MemberService;
| ```
|
| @filesource yidas/codeigniter-psr4-autoload
| @see        https://github.com/yidas/codeigniter-psr4-autoload
*/

$hook['pre_system'][] = [new yidas\Psr4Autoload, 'register'];
