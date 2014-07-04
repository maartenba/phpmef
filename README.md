# PHPMEF - PHP Managed Extensibility Framework 
PHPMEF is a PHP port of the .NET Managed Extensibility Framework, allowing easy composition and extensibility in an application using the Inversion of Control principle and 2 easy keywords: @export and @import.

## Downloads
Latest download can be found under [releases](https://github.com/maartenba/phpmef/releases).

## Hello, PHPMEF!
Here's a simple example on how PHPMEF can be used:

<pre><code>
  class HelloWorld {
      /**
       * @import-many MessageToSay
       */
      public $Messages;
  
      public function sayIt() {
          echo implode(', ', $this->Messages);
      }
  }
  
  class Hello {
      /**
       * @export MessageToSay
       */
      public $HelloMessage = 'Hello';
  }
  
  class World {
      /**
       * @export MessageToSay
       */
      public $WorldMessage = 'World!';
  }
  
  $helloWorld = new HelloWorld();
  
  $compositionInitializer = new MEF_CompositionInitializer(new MEF_Container_Default());
  $compositionInitializer->satisfyImports($helloWorld);
  
  $helloWorld->sayIt(); // Hello, World!
<code></pre>

Check [the wiki](https://github.com/maartenba/phpmef/wiki) for more information.
