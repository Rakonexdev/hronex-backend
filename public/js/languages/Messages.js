/* 
// [INSASOFT][14-May-2023][BEGIN]
// Enhancement  : Globalization & Localization.
// @File        : Messages.js
// @Date        : 14-May-2023
// @Description : Defines the messages used in the application locale is English-UnitedStates 
*/

Messages = {
    /*
    * Represents the locale which is being currently used in the application.
    */
    activeLocale : "en_US",
    
    /*
    * @param {string}  : Message identifier. Made type string to avoid repeating lengthy namespace & to make generic by 
                         avoiding locale specific constants.
    * @returns {string}: Message to be displayed.
    */
    getText: function (id) {
        return Messages[this.activeLocale].getText(id);
    },

    /*
    * @param {string}  : Locale identifier.
    * @param {string}  : Message identifier.
    * @returns {string}: Message to be displayed for the specified locale.
    * Dynamically constructs the accessor to point to the desired constant.
    */
    getLocale: function (localeid, id) {
        var accessors = id.split('.');

        for (var index = 0; index < accessors.length; index++) {
            localeid = localeid[accessors[index]];
        }

        return localeid;
    }
};