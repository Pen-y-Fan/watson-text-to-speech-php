# Contributing

This is a **personal project**. Contributions are **not** required. Anyone interested in developing this project are welcome to 
 fork or clone for your own use.

## Testing

### Unit Tests

PHPUnit is used to run tests, to help this can be run using a composer script. To run the unit tests, from the root of
 the project run:

```shell script
composer test:unit
```

Unit tests do not perform API calls, the **API_KEY** does not need to be set to run the unit tests.

### Run all the tests

To run the full test suite, including unit and feature tests, which include calling the IBM Watson API. The **API_KEY**
 needs to be set in tests/**AbstractSecret.php**. For security reasons this file is excluded from version control (Git
  and Github), instructions on how to configure the test:

- Rename File: tests/**AbstractSecretExample.php** to tests/**AbstractSecret.php**
- Open the **AbstractSecret.php** file 
- Rename Class: **AbstractSecretExample** to **AbstractSecret**
- Add the API key: 
  - Open <https://cloud.ibm.com/> and sign in.
  - Click Services 
  - Click Text to Speech (under services)
  - Under Credentials click Show credentials. The API key will be shown.
  - Copy and paste the key into the constant **API_KEY**
  
```shell script
composer test
```

On Windows a batch file has been created, similar to an alias on Linux/Mac (e.g. `alias pu="composer test"`), the same
 PHPUnit `composer test` can be run:

```shell script
pu
```

### Tests with Coverage Report

To run all test and generate a html coverage report run:

```shell script
composer test:coverage
```

The coverage report is created in /builds, it is best viewed by opening **index.html** in your browser.

## Code Standard

Easy Coding Standard (ECS) is used to check for style and code standards, **PSR-12** is used.

### Check Code

To check code, but not fix an errors:

```shell script
composer check-cs
``` 

On Windows a batch file has been created, similar to an alias on Linux/Mac (e.g. `alias cc="composer check-cs"`), the
 same PHPUnit `composer check-cs` can be run:

```shell script
cc
```

### Fix Code

May code fixes are automatically provided by ECS, if advised to run --fix, the following script can be run:

```shell script
composer fix-cs
```

On Windows a batch file has been created, similar to an alias on Linux/Mac (e.g. `alias fc="composer fix-cs"`), the same
 PHPUnit `composer fix-cs` can be run:

```shell script
fc
```

## Static Analysis

PHPStan is used to run static analysis checks:

```shell script
composer phpstan
```

On Windows a batch file has been created, similar to an alias on Linux/Mac (e.g. `alias ps="composer phpstan"`), the
 same PHPUnit `composer phpstan` can be run:

```shell script
ps
```

## Github Actions

Github Actions have been configured to automatically run on pull request, this is configured to run the **unit tests**,
 **code standard** and **static analysis**. Any failures will need to be corrected and re-push.
 
These can be checked locally by running:

```shell script
cc
ps
pu
``` 

**Happy coding**!
