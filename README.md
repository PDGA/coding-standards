The `PDGA.xml` file in this directory is the rule set for this repo.

Install [PHP Code Sniffer](https://github.com/squizlabs/PHP_CodeSniffer) globally and use it like this:

```
~/.composer/vendor/squizlabs/php_codesniffer/bin/phpcs --ignore=src/vendor,src/node_modules -v --standard=src/tests/rulesets/PDGA.xml ./src
```

Set up VSCode with this plugin: https://marketplace.visualstudio.com/items?itemName=ValeryanM.vscode-phpsab

Add these to your settings.json file:

Note: placeholder; these will likely need to go into `vendor` and be called differently.
```json
    "phpsab.snifferEnable": true,
    "phpsab.snifferMode": "onType",
    "phpsab.snifferArguments": ["-n", "--ignore=tests/*"],
    "phpsab.fixerArguments": ["-n", "--ignore=tests/*"],
    "phpsab.executablePathCBF": "/Users/ha/.composer/vendor/squizlabs/php_codesniffer/bin/phpcbf",
    "phpsab.executablePathCS": "/Users/ha/.composer/vendor/squizlabs/php_codesniffer/bin/phpcs",
    "phpsab.standard": "/Users/ha/Code/php-api/src/tests/rulesets/PDGA.xml",
    "phpsab.allowedAutoRulesets": [
      ".phpcs.xml",
      ".phpcs.xml.dist",
      "phpcs.xml",
      "phpcs.xml.dist",
      "phpcs.ruleset.xml",
      "ruleset.xml"
    ],
    "phpsab.debug": true,
```
