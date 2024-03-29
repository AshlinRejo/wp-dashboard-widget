# WordPress Dashboard widget 

A WordPress plugin with react UI on Dashboard.

## Libraries used

1. [recharts](https://www.npmjs.com/package/recharts)
2. [axios](https://www.npmjs.com/package/axios)

## Installing the development version

1. Clone the directory into your plugins folder with below command.
   `git clone https://github.com/AshlinRejo/wp-dashboard-widget.git /PATH-TO-PLUGINS-FOLDER/wp-dashboard-widget`
2. Make sure you have Node.js ([Downloading and installing Node.js and npm](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm))
3. `npm install` to install the dependencies.
4. `composer install` to install dev dependencies.
5. Activate the plugin through the **Plugins** menu in WordPress.
6. Commands to run script
    1. `composer run-script phpcs` ( Check phpcs ).
    2. `composer run-script phpcs:fix` ( Fix phpcs ).
    3. `composer run-script stylelint` ( Check style coding standard ).
    4. `composer run-script stylelint:fix` ( Fix style coding standard ).
    5. `composer run-script eslint` ( Check javascript coding standard ).
    6. `composer run-script eslint` ( Fix javascript coding standard ).
    7. `composer run-script build` ( To build react js ).
    8. `composer run-script make-pot` ( To generate .pot file ).
    9. `composer run-script precommit` ( To run all above fix, build react js and generate pot ).