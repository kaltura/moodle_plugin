# Kaltura Moodle Plugin Fork
This repository is a fork of the original Kaltura Moodle Plugin at https://github.com/kaltura/moodle_plugin

This fork addresses 4 issues that have been reported, provided pull requests and waiting for merge in original code:

  - **Add capabilities to control the Kaltura button in HTML editors** (https://github.com/kaltura/moodle_plugin/pull/379)
  - **Fix UX issue with submit capability in kaltura assignment** (https://github.com/kaltura/moodle_plugin/pull/380)
  - **Allow plugins of type ltisource to update LTI launch parameters** (https://github.com/kaltura/moodle_plugin/issues/367)
  - **Kaltura plugin for TinyMCE 6 (for Moodle 4 branch)**

If you can't wait for this fixes to be merged in the original plugin, you can use the code on this repository. Note that the only branches that are updated with the fixes are:

 - MOODLE_311_DEV (Use for Moodle 3.x)
 - MOODLE_402_DEV (Use for Moodle 4.x)
 - MOODLE_502_DEV (Use for Moodle 5.x)

## Installation

1. Clone the repository in your server, providing the 3.x or 4.x branch.
```bash
$ git clone https://github.com/estevebadia/kaltura_moodle_plugin.git -b [MOODLE_311_DEV|MOODLE_402_DEV|MOODLE_502_DEV]
```
2a. Replace the files of the kaltura plugins. If `MOODLE_PATH` is the public folder of your Moodle installation, run the following command:
```bash
$ cp -rv kaltura_moodle_plugin/*/ MOODLE_PATH/
```
Note that from Moodle 5.0 this folder is the `public` folder inside the Moodle installation, while for previous versions is the root folder of the Moodle installation.

2b. (Only 4.x) If you're only interested in the new TinyMCE 6 plugin for Moodle 4.x, you can just copy the `/kaltura_moodle_plugin/lib/editor/tiny/plugins/kalturamedia` folder and keep the rest of the official kaltura plugin.

3. (Only 4.x) Depending on the HTML Editors you have in your system you may need to delete the TinyMCE (legacy) plugin (folder `lib/editor/tinymce`) or the TinyMCE 6 plugin (folder `lib/editor/tiny`). Otherwise the Moodle will complain about a missing dependency.

For example, for the default Moodle 4.2 installation you need to delete the TinyMCE (legacy) plugin:
```bash
$ rm -R /var/www/html/lib/editor/tinymce/plugins/kalturamedia
```

4. Finally visit your Moodle site, log in as administrator and follow the update steps.

## Code changes

You can find the detailed relation of changes here:

Moodle 3.x
https://github.com/kaltura/moodle_plugin/compare/MOODLE_311_DEV...estevebadia:kaltura_moodle_plugin:MOODLE_311_DEV


Moodle 4.x
https://github.com/kaltura/moodle_plugin/compare/MOODLE_401_DEV...estevebadia:kaltura_moodle_plugin:MOODLE_402_DEV

Moodle 5.x
https://github.com/kaltura/moodle_plugin/compare/MOODLE_501_DEV...estevebadia:kaltura_moodle_plugin:MOODLE_502_DEV

