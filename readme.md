# HHI Generator #

A command line tool for generating Hack HHI definitions.

To use, simply clone the repo and setup Composer.

```
git clone git@github.com:milesj/hhi.git
cd hhi/
composer install
composer dump-autoload -o
```

Then run any of the following commands to generate a definition.

```
hhi class "Name\Space\For\ClassName"
hhi namespace "Name\Space"
hhi extension spl
```

To save the output to a file, simply pipe it.

```
hhi extension spl > spl.hhi
```

The output *will not* work 100%. You will need to manually fix specific aspects of the definition based on the result of Hack's type checker.
