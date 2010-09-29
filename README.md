# AWS SDK for PHP

The AWS SDK for PHP enables developers to build solutions for Amazon Simple Storage Service (Amazon S3),
Amazon Elastic Compute Cloud (Amazon EC2), Amazon SimpleDB, and more. With the AWS SDK for PHP, developers
can get started in minutes with a single, downloadable package.

The SDK features:

* **AWS PHP Libraries:** Build PHP applications on top of APIs that take the complexity out of coding directly
  against a web service interface. The toolkit provides APIs that hide much of the lower-level implementation.
* **Code Samples:** Practical examples for how to use the toolkit to build applications.
* **Documentation:** Complete SDK reference documentation with samples demonstrating how to use the SDK.
* **PEAR package:** The ability to install the AWS SDK for PHP as a PEAR package.
* **SDK Compatibility Test:** Includes both an HTML-based and a CLI-based SDK Compatibility Test that you can
  run on your server to determine whether or not your PHP environment meets the minimum requirements.

For more information about the AWS SDK for PHP, including a complete list of supported services, see
[aws.amazon.com/sdkforphp](http://aws.amazon.com/sdkforphp).


## Signing up for Amazon Web Services

Before you can begin, you must sign up for each service you want to use.

To sign up for a service:

* Go to the home page for the service. You can find a list of services on
  [aws.amazon.com/products](http://aws.amazon.com/products).
* Click the Sign Up button on the top right corner of the page. If you don't already have an AWS account, you
  are prompted to create one as part of the sign up process.
* Follow the on-screen instructions.
* AWS sends you a confirmation e-mail after the sign-up process is complete. At any time, you can view your
  current account activity and manage your account by going to [aws.amazon.com](http://aws.amazon.com) and
  clicking "Your Account".


## Source
The source tree for includes the following files and directories:

* `_compatibility_test` -- Includes both an HTML-based and a CLI-based SDK Compatibility Test that you can
  run on your server to determine whether or not your PHP environment meets the minimum requirements.
* `lib` -- Contains any third-party libraries that the SDK depends on. The licenses for these projects will
  always be Apache 2.0-compatible.
* `services` -- Contains the service-specific classes that communicate with AWS. These classes are always
  prefixed with `Amazon`.
* `utilities` -- Contains any utility-type methods that the SDK uses. Includes extensions to built-in PHP
  classes, as well as new functionality that is entirely custom. These classes are always prefixed with `CF`.
* `CHANGELOG`, `CONTRIBUTORS`, `LICENSE`, `NOTICE`, `README` -- File names that are all-caps are informational
  documents; the contents of which should be fairly self-explanatory.
* `config-sample.inc.php` -- A sample configuration file that should be filled out and renamed to `config.inc.php`.
* `sdk.class.php` -- The SDK loader that you would include in your projects. Contains the base functionality
  that the rest of the SDK depends on.


## Minimum Requirements in a nutshell

* You are at least an intermediate-level PHP developer and have a basic understanding of object-oriented PHP.
* You have a valid AWS account, and you've already signed up for the services you want to use.
* PHP 5.2 or newer (5.2.14 or latest 5.3.x highly recommended)
* [SimpleXML](http://php.net/simplexml) extension
* [JSON](http://php.net/json) (JavaScript Object Notation) extension
* [PCRE](http://php.net/pcre) (Perl-Compatible Regular Expressions) extension
* [SPL](http://php.net/spl) (Standard PHP Library) extension
* [cURL](http://php.net/curl) extension (compiled with [OpenSSL](http://openssl.org) for HTTPS support)
* Ability to write to the file system

We've included an [SDK Compatibility Test](http://github.com/amazonwebservices/aws-sdk-for-php/tree/master/_compatibility_test/)
that you can run to determine whether or not your PHP environment meets the minimum requirements.


## Installation

### Via GitHub

Amazon Web Services publishes releases of the AWS SDK for PHP to [GitHub](http://github.com/amazonwebservices),
which is a hosted service for [Git](http://git-scm.com) repositories.

If you're unfamiliar with Git, there are a variety of resources on the net that will help you learn more:

* [Everyday Git](http://www.kernel.org/pub/software/scm/git/docs/everyday.html) will teach you just enough
  about Git to get by.
* The [PeepCode screencast](https://peepcode.com/products/git) on Git ($9) is easier to follow.
* [GitHub](http://github.com/guides/home) offers links to a variety of Git resources.
* [Pro Git](http://progit.org/book/) is an entire book about Git with a Creative Commons license.
* [Git for the lazy](http://www.spheredev.org/wiki/Git_for_the_lazy) is a great mini-reference to remind you
  how to do things.
* If you want to dig even further, I've bookmarked [other Git references](http://delicious.com/skyzyx/git).

Here's how you would check out the source code from GitHub:

	git clone git://github.com/amazonwebservices/aws-sdk-for-php.git AWSSDKforPHP
	cd ./AWSSDKforPHP

### Via PEAR

Amazon Web Services also publishes releases of the AWS SDK for PHP to a self-hosted
[PEAR repository](http://pear.amazonwebservices.com).

If you're unfamiliar with how to install PEAR packages, check out
[Command line installer](http://pear.php.net/manual/en/guide.users.commandline.cli.php) in the PEAR user guide.

	sudo pear channel-discover pear.amazonwebservices.com
	sudo pear install aws/sdk

### Configuration

1. Copy the contents of [config-sample.inc.php](https://github.com/amazonwebservices/aws-sdk-for-php/raw/master/config-sample.inc.php)
   and add your credentials as instructed in the file.
2. Move your file to `~/.aws/sdk/config.inc.php`.
3. Make sure that `getenv('HOME')` points to your user directory. If not you'll need to set
   `putenv('HOME=<your-user-directory>')`.


## Additional Information

* AWS SDK for PHP: <http://aws.amazon.com/sdkforphp>
* PHP Developer Center: <http://aws.amazon.com/php>
* Documentation: <http://docs.amazonwebservices.com/AWSSDKforPHP/latest/>
* License: <http://aws.amazon.com/apache2.0/>
* Discuss: <http://aws.amazon.com/forums>
