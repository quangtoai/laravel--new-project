<template>
  <main id="veho_changepassword">
    <form class="form_auth">
      <b-form-group id="fieldset-1" :label="$t('views.login.email')" label-size="lg">
        <b-form-input
          v-model="params.email"
          name="email"
          type="email"
          :placeholder="$t('views.login.email-placeholder')"
          trim
          :disabled="isCheckProxyEmail"
          @keyup.enter="submit"
        />
      </b-form-group>

      <label class="labelcheck">
        <b-form-checkbox
          v-model="isCheckProxyEmail"
          checked="checked"
          class="check_input"
          size="lg"
        />
        {{ $t('views.login.email-description') }}
      </label>
      <!-- Employee's proxy contact input field -->
      <b-form-group v-if="isCheckProxyEmail" :label="$t('views.login.proxy-contact')" label-size="lg">
        <b-form-select id="proxy-contact-input" v-model="params.proxy_email">

          <b-form-select-option
            v-for="(option, index) in ProxyUserList"
            :key="index"
            :value="option.email"
            @keyup.enter="submit"
          >
            {{ (option.name + ' ⌿ ' + option.email) }}
          </b-form-select-option>
        </b-form-select>
      </b-form-group>
      <!-- Employee's password input field -->
      <b-form-group :label="$t('views.login.password')" label-size="lg">
        <b-form-input
          v-model="params.password"
          name="password"
          type="password"
          :placeholder="$t('views.login.password')"
          autocomplete="new-password"
          trim
          @keyup.enter="submit"
        />
        <div style="margin-top: 10px;">
          <span>{{ $t('views.login.password-description') }}</span>
        </div>
      </b-form-group>
      <!-- Button registration -->
      <div class="action" style="text-align: center;">
        <b-button class="btn_submit" type="button" @click="submit()">
          {{ $t('views.login.btn-registration') }}
        </b-button>
      </div>
    </form>
  </main>
</template>

<script>
import { vToast } from '../../utils/toast_message';
import { getUserProxyContacts, registrationUser } from '../../api/login';

export default {
    name: 'ChangePassword',
    data() {
        return {
            ProxyUserList: [],
            emp_code: this.$store.state.user.auth.emp_code,
            params: {
                email: this.$store.state.user.auth.email,
                password: '',
                temp_pass: this.$store.state.user.auth.temp_pass,
                proxy_email: '',
            },
            err: '',
            isCheckProxyEmail: false,
        };
    },
    mounted() {
        this.getUserProxyContactsList();
    },

    methods: {
        async getUserProxyContactsList() {
            await getUserProxyContacts()
                .then((response) => {
                    this.ProxyUserList = response.data.result;
                    this.ProxyUserList.unshift({ email: '', name: this.$t('notify.email_proxy_required') });
                })
                .catch((error) => {
                    vToast(error.message);
                });
        },
        validateForm() {
            this.err = '';
            if (this.isCheckProxyEmail && !this.params.proxy_email) {
                this.err = 'notify.email_proxy_required';
            } else if (!this.isCheckProxyEmail && !this.params.email) {
                this.err = 'notify.email_required';
            } else if (!this.isCheckProxyEmail && !this.params.email.includes('@')) {
                this.err = 'notify.email_invalid';
            } else if (!this.params.password) {
                this.err = 'notify.password_required';
                return;
            } else if (this.params.password.length < 8) {
                this.err = 'notify.password_min_length';
            }
        },
        async submit() {
            this.validateForm();
            if (this.err){
                vToast(this.err);
                return false;
            }
            const params = this.params;
            if (this.checkboxStatus) {
                delete params.email;
            } else {
                delete params.proxy_email;
            }
            await registrationUser(this.emp_code, params)
                .then((response) => {
                    if (response.code === 200) {
                        this.auth = { ...response.data.profile };
                        this.auth.token = response.data.access_token;
                        this.auth.isManager = false;
                        this.auth.password = this.params.password;
                        this.$store.dispatch('saveLogin', this.auth, response.data.access_token)
                            .then(() => {
                                vToast('views.login.login-success', 1);
                                this.$router.push({ name: 'EmpShow' });
                            })
                            .catch(() => {
                                vToast('views.login.login-fail');
                            });
                    } else {
                        vToast(response.message);
                    }
                })
                .catch(() => {
                    vToast('views.login.login-fail');
                });
        },
    },
};
</script>
