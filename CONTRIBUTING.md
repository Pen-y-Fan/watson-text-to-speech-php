# Contributing

Contributions are **welcome** and will be fully **credited**.

Please read and understand the contribution guide before creating an issue or pull request.

## Etiquette

This project is open source, and as such, the maintainers give their free time to build and maintain the source code
held within. They make the code freely available in the hope that it will be of use to other developers. It would be
extremely unfair for them to suffer abuse or anger for their hard work.

Please be considerate towards maintainers when raising issues or presenting pull requests. Let's show the
world that developers are civilized and selfless people.

It's the duty of the maintainer to ensure that all submissions to the project are of sufficient
 quality to benefit the project. Many developers have different skillsets, strengths, and weaknesses. Respect the
 maintainer's decision, and do not be upset or abusive if your submission is not used.

## Viability

When requesting or submitting new features, first consider whether it might be useful to others. Open
source projects are used by many developers, who may have entirely different needs to your own. Think about
whether or not your feature is likely to be used by other users of the project.

## Procedure

Before filing an issue:

- Attempt to replicate the problem, to ensure that it wasn't a coincidental incident.
- Check to make sure your feature suggestion isn't already present within the project.
- Check the pull requests tab to ensure that the bug doesn't have a fix in progress.
- Check the pull requests tab to ensure that the feature isn't already in progress.

Before submitting a pull request:

- Check the codebase to ensure that your feature doesn't already exist.
- Check the pull requests to ensure that another person hasn't already submitted the feature or fix.

## Requirements

- **Add tests!** - Your patch won't be accepted if it doesn't have tests. PHPUnit has been included as a dev dependency

- **[PSR-12 Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-12-extended-coding-style-guide.md)** -
 Easy coding standard (ECS) is included as a dev dependency

- **Document any change in behaviour** - Make sure the `README.md` and any other relevant documentation are kept
 up-to-date.

- **Consider our release cycle** - We try to follow [SemVer v2.0.0](https://semver.org/). Randomly breaking public APIs
 is not an option.

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful. If you had to make
 multiple intermediate commits while developing, please
 [squash them](https://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages) before
  submitting.

### Testing

#### Unit Tests

PHPUnit is used to run tests, to help this can be run using a composer script. To run the unit tests, from the root of
 the project run:

```shell script
composer test:unit
```

Unit tests do not perform API calls, the **API_KEY** does not need to be set to run the unit tests.

#### Run all the tests

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

#### Tests with Coverage Report

To run all test and generate a html coverage report run:

```shell script
composer test:coverage
```

The coverage report is created in /builds, it is best viewed by opening **index.html** in your browser.


**Happy coding**!

### Code Standard

Easy Coding Standard (ECS) is used to check for style and code standards, **PSR-12** is used.

#### Check Code

To check code, but not fix an errors:

```shell script
composer check-cs
``` 

On Windows a batch file has been created, similar to an alias on Linux/Mac (e.g. `alias cc="composer check-cs"`), the
 same PHPUnit `composer check-cs` can be run:

```shell script
cc
```

#### Fix Code

May code fixes are automatically provided by ECS, if advised to run --fix, the following script can be run:

```shell script
composer fix-cs
```

On Windows a batch file has been created, similar to an alias on Linux/Mac (e.g. `alias fc="composer fix-cs"`), the same
 PHPUnit `composer fix-cs` can be run:

```shell script
fc
```

### Static Analysis

PHPStan is used to run static analysis checks:

```shell script
composer phpstan
```

On Windows a batch file has been created, similar to an alias on Linux/Mac (e.g. `alias ps="composer phpstan"`), the
 same PHPUnit `composer phpstan` can be run:

```shell script
ps
```

### Github Actions

Github Actions have been configured to automatically run on pull request, this is configured to run the **unit tests**,
 **code standard** and **static analysis**. Any failures will need to be corrected and re-push.
 
These can be checked locally by running:

```shell script
cc
ps
pu
``` 

**Happy coding**!
