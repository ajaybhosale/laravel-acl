# Codebank/Laravel-ACL

Laravel ACL adds role based permissions to built in Auth System of Laravel 5. ACL middleware protects routes methods.

# Table of Contents
* [Team Members](#team-members)
* [Requirements](#requirements)
* [Getting Started](#getting-started)
* [Documentation](#documentation)
* [Roadmap](#roadmap)


# <a name="team-members"></a>Team Members

* Ajay Bhosale (ajay.bhosale@silicus.com)

# <a name="requirements"></a>Requirements

* This package requires following things 
* PHP 5.5+
* MySQL 5.5+
* Laravel 5.1

# <a name="getting-started"></a>Getting Started

1. On root level create a folder named as "packages".

2. Copy and past "Codebank/Acl" into "packages" folder.

3. Require the package in your 'composer.json' and update your dependency with 'composer update':

	"psr-4": {
			"App\\": "app/",
			"Codebank\\Acl\\": "packages/Codebank/Acl/src/" 
		}

4. Add the package to your application service providers in 'config/app.php'.

	'providers' => [
		'Codebank\Acl\AclServiceProvider',
	],

5. Publish the package migrations to your application and run these with `php artisan migrate.
	$ php artisan vendor:publish --provider="Codebank\Acl\AclServiceProvider"

6. Add the middleware to your 'app/Http/Kernel.php'.

protected $routeMiddleware = [
	'acl' => 'Codebank\Acl\Middleware\Acl',
];

7. Add the "UserPermission" trait to your 'User' model.

use Codebank\Acl\Traits\UserPermission;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword, UserPermission;
}

# <a name="documentation"></a>Documentation

1. Add permission as an array into config/view.php

	'permission' => []

2. Adding rules into 'app/Http/routs.php'. You have to specify module name as well as action name inside 'permission'  
	
Route::group(['middleware' => ['auth', 'acl']], function()
    {
        Route::get('/contact', [
            'uses'       => 'ContactController@index',
            'permission' => ['module' => 'contact', 'action' => 'view']
        ]);

        Route::get('/contact/show', [
            'uses'       => 'ContactController@show',
            'permission' => ['module' => 'contact', 'action' => 'show']
        ]);

        Route::get('/contact/create', [
            'uses'       => 'ContactController@create',
            'permission' => ['module' => 'contact', 'action' => 'create']
        ]);

        Route::get('/contact/store', [
            'uses'       => 'ContactController@store',
            'permission' => ['module' => 'contact', 'action' => 'store']
        ]);

        Route::get('/contact/edit', [
            'uses'       => 'ContactController@edit',
            'permission' => ['module' => 'contact', 'action' => 'edit']
        ]);

        Route::get('/contact/update', [
            'uses'       => 'ContactController@update',
            'permission' => ['module' => 'contact', 'action' => 'update']
        ]);

        Route::get('/contact/destroy', [
            'uses'       => 'ContactController@destroy',
            'permission' => ['module' => 'contact', 'action' => 'destroy']
        ]);
    });

3. Control the menu based on permission in view/template section. 

@if (!Auth::guest())
	<ul class="dropdown-menu" role="menu">
		@if(auth()->user()->can('view', 'contact'))
			<li><a href="{{ url('contact/show') }}">Show</a></li>
		@endif
		
		@if(auth()->user()->can('create', 'contact'))
			<li><a href="{{ url('contact/create') }}">Create</a></li>
		@endif
		
		@if(auth()->user()->can('save', 'contact'))
			<li><a href="{{ url('contact/store') }}">Store</a></li>
		@endif
		
		@if(auth()->user()->can('edit', 'contact'))
			<li><a href="{{ url('contact/edit') }}">Edit</a></li>
		@endif
		
		@if(auth()->user()->can('update', 'contact'))
			<li><a href="{{ url('contact/update') }}">Update</a></li>
		@endif
		
		@if(auth()->user()->can('delete', 'contact'))
			<li><a href="{{ url('contact/destroy') }}">Destroy</a></li>
		@endif
	</ul>
 @endif
# <a name="roadmap"></a>Roadmap

Here's the TODO list for the next release (**2.0**).

* [ ] Refactoring the source code.
* [ ] Correct all issues.
