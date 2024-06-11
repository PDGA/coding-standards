The `src/ruleset.xml` file in this directory is the rule set for PDGA coding standards.

## General Setup

`git clone https://github.com/PDGA/coding-standards.git`
`cd coding-standards && composer install`

## VSCode Setup

### Plugin
Set up VSCode with this plugin: https://marketplace.visualstudio.com/items?itemName=ValeryanM.vscode-phpsab

Add the JSON configuration below to your `settings.json` file, usually in:

* Windows `%APPDATA%\Code\User\settings.json`
* macOS `$HOME/Library/Application\ Support/Code/User/settings.json`
* Linux `$HOME/.config/Code/User/settings.json`

**Note: you will likely have to change the path to where you cloned `coding-standards`, the example below shows it at `~/Code/coding-standards`

```json
    "phpsab.snifferEnable": true,
    "phpsab.snifferMode": "onType",
    "phpsab.snifferArguments": ["-n", "--ignore=tests/*"],
    "phpsab.fixerArguments": ["-n", "--ignore=tests/*"],
    "phpsab.executablePathCBF": "${userHome}/Code/coding-standards/vendor/bin/phpcbf",
    "phpsab.executablePathCS": "${userHome}/Code/coding-standards/vendor/bin/phpcs",
    "phpsab.standard": "${userHome}/Code/coding-standards/src/ruleset.xml",
    "phpsab.autoRulesetSearch": false,
    "phpsab.debug": true,
```

### Debugging the Codesniffer plugin configuration

To enable debugging, add to settings.json:

```json
    "phpsab.debug": true,
```

Then open `Terminal -> New Terminal` in vscode, after it opens click 'OUTPUT' and from the dropdown, choose
`PHP Sniffer & Beautifier`.
