![GitHub release](https://img.shields.io/github/release/lotgd-core/lodge-title-change-bundle.svg)
![GitHub Release Date](https://img.shields.io/github/release-date/lotgd-core/lodge-title-change-bundle.svg)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/lotgd-core/lodge-title-change-bundle)
[![Build in PHP](https://img.shields.io/badge/PHP-^7.3-8892BF.svg?logo=php)](http://php.net/)

![GitHub issues](https://img.shields.io/github/issues/lotgd-core/lodge-title-change-bundle.svg)
![GitHub pull requests](https://img.shields.io/github/issues-pr/lotgd-core/lodge-title-change-bundle.svg)
![Github commits (since latest release)](https://img.shields.io/github/commits-since/lotgd-core/lodge-title-change-bundle/latest.svg)
![GitHub commit activity](https://img.shields.io/github/commit-activity/w/lotgd-core/lodge-title-change-bundle.svg)
![GitHub last commit](https://img.shields.io/github/last-commit/lotgd-core/lodge-title-change-bundle.svg)

![GitHub top language](https://img.shields.io/github/languages/top/lotgd-core/lodge-title-change-bundle.svg)
![GitHub language count](https://img.shields.io/github/languages/count/lotgd-core/lodge-title-change-bundle.svg)

[![PayPal.Me - The safer, easier way to pay online!](https://img.shields.io/badge/donate-help_my_project-ffaa29.svg?logo=paypal&cacheSeconds=86400)](https://www.paypal.me/idmarinas)
[![Liberapay - Donate](https://img.shields.io/liberapay/receives/IDMarinas.svg?logo=liberapay&cacheSeconds=86400)](https://liberapay.com/IDMarinas/donate)
[![Twitter](https://img.shields.io/twitter/url/http/shields.io.svg?style=social&cacheSeconds=86400)](https://twitter.com/idmarinas)


## Installation ##

```bash
composer require lotgd-core/lodge-title-change-bundle
```

# Default configuration
```yaml
lotgd_lodge_title_change:
    cost:
        # How many donator points needed to get first title change?
        first: 5000
        # How many additional donator points needed for subsequent title changes?
        other: 25
    allowed:
        # Can use bold for title changes?
        bold: true
        # Can use italic for title changes?
        italic: true
        # Can use blank title?
        blank: true
        # Can use spaces for title changes?
        spaces: true
```
