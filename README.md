Views
=====
A simple view renderer - will read a .phtml file from the directory passed to the views.dir option, 
bind variables to it, and return the content as a string.

NO HEAVY TEMPLATE ENGINE! - PHP does templating on it's own, remember?

Options
-------

The following options are avaliable during object construction:

| Option       | Description                                      | Required           |
|:-------------|:-------------------------------------------------|:-------------------|
| views.dir    | Root path of your views directory.               | Yes                |

Usage
-----

Consider the following directory structure:

    app/
    ├── index.php
    ├── vendor
    │   └── autoload.php
    └── views
        └── Hello.phtml

Hello.phtml contains the following:

    <!doctype html>
    <html>
        <head>
            <title>Hello</title>
        </head>
        <body>
            <p>Hello <?= $name ?></p>
        </body>
    </html>

This is how we render our view from index.php:

    <?php require 'vendor/autoload.php';
    
    $views = new \CesarV\Views\View(array(
        'views.dir' => __DIR__ . '/views'
    ));

    echo $views->render('hello', array('name' => 'Cesar'));

Notice that array('name' => 'Cesar') became $name in Hello.phtml?