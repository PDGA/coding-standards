The `src/ruleset.xml` file in this directory is the rule set for PDGA coding standards.

## Adding to a repository

* Edit composer.json, add these sections:

```json
  "scripts": {
    "sniff": "bin/codesniffer phpcs",
    "format": "bin/codesniffer phpcbf",
    "format-verbose": "bin/codesniffer phpcbf -v"
  },
```

```json
    "repositories":[
        {
            "type": "vcs",
            "url": "https://github.com/PDGA/coding-standards.git"
        }
    ],
```

```json
  "require-dev": {
    "pdga/coding-standards": "^1.0"
  }
```

**Note: If any section already exists, add the new information under/inside of it.**

* Run `composer install` from that repository to install.
* Copy `example/script` to `bin/codesniffer` in that repository and modify the script to use the proper container.

## Using in a repository

Once you have the repository's `composer.json` file set up and have run `composer install` to install the new dependency,
you can run using `composer run` and choose either `sniff`, `format` or `format-verbose`.

## VSCode Plugin Setup

### Clone main repo

`git clone https://github.com/PDGA/coding-standards.git`

`cd coding-standards && composer install`

### Plugin

Set up VSCode with this plugin: https://marketplace.visualstudio.com/items?itemName=ValeryanM.vscode-phpsab

Add the JSON configuration below to your `settings.json` file, usually in:

* Windows `%APPDATA%\Code\User\settings.json`
* macOS `$HOME/Library/Application\ Support/Code/User/settings.json`
* Linux `$HOME/.config/Code/User/settings.json`

**Note**: you will have to change the path to where you cloned `coding-standards`.

Thus, if you installed it at `~/Code/coding-standards`, the full path on a Mac would be `/Users/<username>/Code/coding-standards`

```json
    "phpsab.snifferEnable": true,
    "phpsab.snifferMode": "onType",
    "phpsab.snifferArguments": ["-n", "--ignore=tests/*"],
    "phpsab.fixerArguments": ["-n", "--ignore=tests/*"],
    "phpsab.executablePathCBF": "<full path to repo>/coding-standards/vendor/bin/phpcbf",
    "phpsab.executablePathCS": "<full path to repo>/coding-standards/vendor/bin/phpcs",
    "phpsab.standard": "<full path to repo>/coding-standards/src/ruleset.xml",
    "phpsab.autoRulesetSearch": false,
```

### Debugging the Codesniffer plugin configuration

To enable debugging, add to settings.json:

```json
    "phpsab.debug": true,
```

Then open `Terminal -> New Terminal` in vscode, after it opens click 'OUTPUT' and from the dropdown, choose
`PHP Sniffer & Beautifier`.

### Per Repo or VSC workspace specific configuration

Open the `.code-workspace` file for that workspace and add:

#### Disable

```json
    "phpsab.snifferEnable": false,
```

This should override the settings for that one workspace, turning off the file.

#### Rules

```json
    "phpsab.standard": "<full path to repo>/coding-standards/src/<different ruleset>.xml",
```

## PhpStorm PHP_CodeSniffer Setup

PhpStorm has native support for configuring PHP_CodeSniffer as a Quality Tool per project.

Follow the setup instructions here: [PhpStorm Setup](https://www.jetbrains.com/help/phpstorm/using-php-code-sniffer.html#installing-configuring-code-sniffer)

### Configuring for a project that runs on a Docker image
The setup instructions will use a local PHP interpreter and local file paths for the CodeSniffer configuration. 
When setting this up for a project that runs within a Docker image, there are some things to be aware of. 
Since `Composer` commands should run on the image instead of locally, you will need everything configured from the perspective of the image.
- Use the interpreter from the Docker image. (eg Use the `pdga-api-php` interpreter instead of `System PHP`)
- Use the file paths from the Docker image (eg Use soemthing like `/var/www/html/vendor/squizlabs/php_codesniffer/bin/phpcs` for the PHP_CodeSniffer path).
