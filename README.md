# idnumber generator #

The plugin _idnumber generator_ generates idnumbers for different usages.

At the moment plugin provides idnumbers for questions and question categories.

Plugin creates a new submenu link in the question bank menu.

This submenu propose acces to the form, that allows:

 - to define idnumber template for course
 - to generate (missing) idnumbers
 - to regenerate all idnumbers

## template definition

Template supports the next patterns:

 * `uuid` - unique identifier`
 * `category` - category order number in parent category
 * `number` - question order number
 * `type` - type of question
 * `point` - question points

Examples of tempaltes:

 * `[uuid]`
 * `c[category]t[type]p[point][number]`

## Installing via uploaded ZIP file ##

1. Log in to your Moodle site as an admin and go to _Site administration >
   Plugins > Install plugins_.
2. Upload the ZIP file with the plugin code. You should only be prompted to add
   extra details if your plugin type is not automatically detected.
3. Check the plugin validation report and finish the installation.

## Installing manually ##

The plugin can be also installed by putting the contents of this directory to

    {your/moodle/dirroot}/local/idnumber

Afterwards, log in to your Moodle site as an admin and go to _Site administration >
Notifications_ to complete the installation.

Alternatively, you can run

    $ php admin/cli/upgrade.php

to complete the installation from the command line.

## License ##

2021 Mihail Croitor <mcroitor@gmail.com>

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <https://www.gnu.org/licenses/>.

## TODO

 * keep idnumber template for each course
 * UI is available from question bank menu
 * generate UUID idnumber for question
 * generate UUID idnumber for question category
 * options for module: 
   * select generator type;
   * generate idnumbers for empty;
   * regenerate all idnumbers
 * implement idnumber generation, question type based
 * generate idnumbers (for questions and question categories) when course is created or updated