Usage
================
Basic Usage:
```php
<?php
  use Landmarx\LandmarkFacory;
  use Landmarx\Renderer\ListRenderer;

  $factory = new LandmarkFactory();
  $landmarks = $factory->createItem('Landmarks');
  $landmarks->addChild('Appalachian Mountain Range', array());
  $landmarks->getChild('Appalachian Mountain Range')->addChild('Mt. Katahdin');

  $renderer = new ListRenderer();
  echo $renderer->render($landmarks);
```

This would render:
```html
<ul>
  <li>
    <a href="/appalachian-mountain-range">Appalachian Mountain Range</a>
  </li>
  <li>
    <a href="/appalachian-mountain-range/mt-katahdin">Mt. Katahdin</a>
  </li>
</ul>
```