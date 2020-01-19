import {formValidator as formValidatorConfig} from "../defaultconfigs";

export default {
    inserted(el, binding, vnode) {
        $(el).validate(formValidatorConfig);
    },
}
