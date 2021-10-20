<template>
  <main id="veho_login">
    <form class="form_auth">
      <b-form-group id="fieldset-1" :label="$t('views.login.employee-number')" label-size="lg">
        <b-form-input
          v-model="Account.number"
          name="emp_code"
          type="number"
          :placeholder="$t('views.login.employee-number')"
          @keyup.enter="handleLogin"
        />
      </b-form-group>
      <b-form-group id="fieldset-2" :label="$t('views.login.password')" label-size="lg">
        <b-form-input
          v-model="Account.password"
          name="password"
          type="password"
          autocomplete="new-password"
          :placeholder="$t('views.login.password')"
          trim
          @keyup.enter="handleLogin"
        />
      </b-form-group>
      <div class="action text-center">
        <button type="button" class="btn btn_login btn_submit" @click="handleLogin">
          {{ $t('views.login.btn-login') }}
        </button>
      </div>
      <div class="link_forgot_password" @click="toRecoveryPassword">{{ $t('views.login.forgot-password') }} </div>
    </form>
  </main>
</template>

<script>
import { vToast } from '../../utils/toast_message';
import { authenticateLogin } from '../../api/login';
export default {
    name: 'Login',

    data() {
        return {
            Account: {
                number: '',
                password: '',
            },
            auth: { isManager: false, token: '' },
            err: '',
            isLogin: false,
        };
    },
    mounted(){
        document.title = this.$route.name === 'LoginAdmin' ? this.$t('routes.manager_system') : this.$t('routes.crew_system');
    },
    methods: {
        validate() {
            // console.log(,333);
            this.err = '';
            if (!this.Account.number) {
                this.err = 'notify.emp_code_required';
            } else if (!this.Account.password) {
                this.err = 'notify.password_required';
                return;
            } else if (this.Account.number.length > 6) {
                this.err = 'notify.emp_code_max_length';
            } else if (this.Account.password.length < 8) {
                this.err = 'notify.password_min_length';
            }
        },
        async handleLogin() {
            this.validate();
            if (this.err){
                vToast(this.err);
                return false;
            }
            const DATA = {
                emp_code: parseInt(this.Account.number),
                password: this.Account.password,
            };

            await authenticateLogin(DATA)
                .then((response) => {
                    if (response.code === 200) {
                        this.auth = { ...response.data.profile };
                        this.auth.token = response.data.access_token;
                        if (this.$route.name === 'LoginAdmin'){
                            if (response.data.profile.role === 'MANAGER'){
                                this.auth.isManager = true;
                            } else {
                                vToast('notify.cannot_access');
                                return;
                            }
                        }
                        // this.auth.isManager = this.$route.name === 'LoginAdmin' && response.data.profile.role === 'MANAGER';
                        this.isLogin = true;
                        this.$store.dispatch('saveLogin', this.auth, response.data.access_token)
                            .then(() => {
                                vToast('views.login.login-success', true);
                                let urlName = this.auth.is_new_pw ? 'change-password' : 'payslip/detail';
                                if (this.auth.isManager){
                                    urlName = 'payslip/index';
                                }
                                this.$router.push(urlName);
                                // window.location.href = process.env.MIX_LARAVEL_PATH + urlName;
                            })
                            .catch(() => {
                                vToast('views.login.login-fail');
                            });
                    } else {
                        vToast(response.message);
                    }
                })
                .catch(() => {
                    vToast('views.login.undefined-error');
                });
        },
        toRecoveryPassword() {
            this.$router.push({ path: `/recovery` }, (onAbort) => {});
        },
    },
};
</script>
