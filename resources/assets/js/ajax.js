import {CSRF_TOKEN} from "./constants";

/**
 * Configura as chamadas de ajax feitas pelo sistema.
 */
export const configurarAjax = () => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Accept': "application/json"
        }
    });
};
