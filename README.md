[![License](https://img.shields.io/badge/license-AGPLv3-blue.svg)](http://www.gnu.org/licenses/agpl-3.0.html)

# Kaltura Plugin for Moodle

Kaltura's Video Package for Moodle makes it easy to add the robust capabilities of Kaltura's open source online video platform to any Moodle site. The package was developed specifically for Moodle and integrates with other features and modules, such as resources and activities, so that users can upload and embed media easily.

Signing the Contributor License Agreement
===================
When you merge new code to the Kaltura Platform, we require that you sign the Kaltura Contributor License Agreement (or "CLA"). The CLA license is for your protection as a Contributor as well as the protection of the Project and its community members. It does not change your rights to use your own Contributions for any other purpose, and does not require any IP assignment of any kind.
If you're working on a Kaltura project, or can clearly claim ownership of copyright in what you'll be contributing to the project, the CLA will ensure that your contributions are protected and that the project will forever remain free to be used and modified by the global community. 

As references, we encourage reviewing other known projects and their respective CLAs - 
* [The Apache Software Foundation](http://www.apache.org/licenses/#clas).
* [The Fedora Project](https://fedoraproject.org/wiki/Legal:Fedora_Project_Contributor_Agreement).
* [Ubuntu, Canonical Projects](http://www.canonical.com/contributors).
* [MongoDB](http://www.mongodb.com/legal/contributor-agreement).

Please [CLICK HERE TO SIGN](https://agentcontribs.kaltura.org) the Kaltura CLA digitally using your GitHub account. 
You can also [download the Kaltura CLA in PDF format](http://knowledge.kaltura.com/node/1235/attachment/field_media), sign it and email to [community@kaltura.com](mailto:community@kaltura.com).


## How to contribute a pull-request
For each version, we keep 2 branches: MOODLE_XX_DEV and MOODLE_XX_STABLE.


MOODLE_XX_DEV is our development branch - all approved pull requests are merged to this branch. Once in a while we drop a version to our QA team.
After our QA team verifies the changes made in the corresponding DEV branch - they are merged to the STABLE branch.

So, when issuing a PR - please make sure that:
* You are checked out a DEV branch.
* In your pull-request, the base branch is indeed the DEV branch you checked-out from.
 
## Contribution Guidelines
* Please do not file big Pull Requests. It makes reviewing and ensuring correctness difficult. If possible, break it down in smaller commits/pulls, each related to a specific issue or subject
* Every commit should have a meaningful subject
* If the code has tests, they must pass before submitting the pull request
* When submitting a new feature, unit tests must be submitted as well
* Whenever possible, implement features as plugins, not by modifying Core code
* Always keep performance in mind
* If you are unsure about submitting a Pull request, ask one of the repository owners for clarification


Thank you for taking the time to read this!
