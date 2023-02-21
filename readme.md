# Kaltura Moodle Plugin Fork
This repository is a fork of the original Kaltura Moodle Plugin at https://github.com/kaltura/moodle_plugin

This fork addresses 3 issues that have been reported, provided pull requests and waiting for merge in original code:

  - **Add capabilities to control the Kaltura button in HTML editors** (https://github.com/kaltura/moodle_plugin/pull/379)
  - **Fix UX issue with submit capability in kaltura assignment** (https://github.com/kaltura/moodle_plugin/pull/380)
  - **Allow plugins of type ltisource to update LTI launch parameters** (https://github.com/kaltura/moodle_plugin/issues/367)

If you can't wait for this fixes to be merged in the original plugin, you can use the code on this repository. Note that the only branches that are updated with the fixes are:

 - MOODLE_311_DEV
 - MOODLE_400_DEV

For moodle 3.x, use the MOODLE_311_DEV branch, and for moodle 4.x use the MOODLE_400_DEV branch.

## Installation

1. Clone the repository in your server, providing the 3.x or 4.x branch.
```bash
$ git clone https://github.com/estevebadia/kaltura_moodle_plugin.git -b MOODLE_311_DEV
```
2. Replace the files of the kaltura plugins. Provide the Moodle path if it is not the default /var/www/html:
```bash
$ cp -rv kaltura_moodle_plugin/*/ /var/www/html/
```
You can find the detailed relation of changes here:  
https://github.com/kaltura/moodle_plugin/compare/MOODLE_311_DEV...estevebadia:kaltura_moodle_plugin:MOODLE_311_DEV

3. Finally visit your Moodle site, log in as administrator and follow the update steps.
