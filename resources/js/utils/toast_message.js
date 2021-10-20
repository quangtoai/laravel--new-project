import Vue from 'vue';
import i18n from '../lang/index';
export const MakeToast = ({ variant = null, title, content }) => {
    const vm = new Vue();
    vm.$bvToast.toast(content, {
        title: title,
        variant: variant,
        toaster: 'b-toaster-top-center',
        solid: true,
        autoHideDelay: 1500,
        appendToast: true,
    });
};
export const vToast = (mes, isSuccess = false) => {
    const variant = isSuccess ? 'success' : 'danger';
    const code = errCode[mes] || '';
    const title = i18n.t(variant) + ' ' + code;
    const content = i18n.t(mes);
    MakeToast({ variant, title, content });
};
export const errCode = {
    'notify.emp_code_max_length': 'ERR01',
    'notify.emp_code_required': 'ERR02',
    'notify.password_required': 'ERR03',
    'notify.password_min_length': 'ERR04',
    'notify.data_notfound': 'ERR05',
    'notify.cannot_access': 'ERR06',
    'notify.confirm_password_required': 'ERR07',
    'notify.confirm_password_notmatch': 'ERR08',
    'notify.current_password_wrong': 'ERR09',
    'notify.retirement_required': 'ERR10',
    'notify.email_required': 'ERR11',
    'notify.email_wrong_format': 'ERR12',

    'server.emp_code_not_exist': 'ERR20',
    'server.temp_pass_not_match': 'ERR21',
    'server.temp_pass_not_active': 'ERR22',
    'server.temp_pass_incorrect': 'ERR23',
    'server.server_error': 'ERR24  ',
    'server.payslip_existed': 'ERR25',
    'server.confirm_pass_not_match': 'ERR26',
    'server.current_pass_incorrect': 'ERR27',
    'server.token_not_provided': 'ERR28',
    'server.session_expire': 'ERR29',
    'server.email_invalid': 'ERR30',
    'server.current_pass_confirm_pass_not_null': 'ERR31',
    'server.emp_code_or_password_incorrect': 'ERR32',
    'server.account_deactivated': 'ERR33',
    'server.csv_file_invalid': 'ERR34',
};
