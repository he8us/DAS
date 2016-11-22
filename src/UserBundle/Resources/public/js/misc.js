/* global Translator */

/* eslint-disable no-unused-vars */
function render_role(data) {
    return translateRole(data[0]);
}
/* eslint-enable no-unused-vars */

function translateRole(role) {
    switch (role) {
        case 'ROLE_STUDENT':
            return Translator.trans("user.role.student");

        case 'ROLE_STUDENT_PARENT':
            return Translator.trans("user.role.parent");

        case 'ROLE_TEACHER':
            return Translator.trans("user.role.teacher");

        case 'ROLE_TITULAR':
            return Translator.trans("user.role.titular");

        case 'ROLE_COURSE_TITULAR':
            return Translator.trans("user.role.course_titular");

        case 'ROLE_COORDINATOR':
            return Translator.trans("user.role.coordinator");

        case 'ROLE_SUPER_ADMIN':
            return Translator.trans("user.role.super_admin");
    }


}
