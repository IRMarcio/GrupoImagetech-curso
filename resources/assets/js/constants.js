import {datepicker} from './defaultconfigs';

// Privado
const PREFIXO_ROTA = $('meta[name="_prefixoRota"]').attr('content');

// Exportados
export const SITE_PATH = $('meta[name="_sitepath"]').attr('content');
export const URL = SITE_PATH + '/' + PREFIXO_ROTA;
export const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

export const datepickerConfig = datepicker;
