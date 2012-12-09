Landmarx Landmark Mapping Library
=================================
The Landmarx Landmark library provides object oriented nodes that connect to map given data.  
It is used by the [LandmarxBundle](https://github.com/ner0tic/LandmarxBundle) for Symfony2 but can now be used stand-alone.

Docs
============
1. [Installation](Landmarx/blob/master/README.md)
2. [Usage](Landmarx/blob/master/doc/usage.md)
3. [Renderers](Landmarx/blob/master/doc/renderers.md)
4. [Twig Integration](Landmarx/blob/master/doc/helpers.md)
5. [TODO](Landmarx/blob/master/doc/todo.md)



Installation
============
Landmarx does not provide an autoloader but does follow the `PSR-0` convention.  
You can use any compliant autoloader for the library.  

Add to your autoloader, example below assumes library is in `vendor/Landmarx`
```php
<?php
  $loader->registerNamespaces(array(
      'Landmarx\Landmark' => __DIR__.'/vendor/Landmarx/src'
      // ...
  ));
```

Related
============
[LandmarxBundle](https://github.com/ner0tic/LandmarxBundle) - A Symfony 2 bundle wrapping the library.
[Landmarx Application](https://github.com/ner0tic/LandmarxApp) - A working application built around this library. (under heavy development)

Credits
============
Based on [KnpMenu](https://github.com/KnpLabs/KnpMenu)
