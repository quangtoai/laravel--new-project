<template>
  <main id="veho_empupdate">
    <h2 class="title">{{ $t("routes.employee-edit") }}</h2>
    <form>
      <div v-if="isLoading" class="loading"><i class="spinner-border" /></div>
      <section class="general">
        <b-form-group id="fieldset-1" :label="$t('views.employee.employee-code')" label-size="lg">
          <b-form-input
            v-model="emp_code"
            class="input"
            type="number"
            readonly
            :placeholder="$t('views.employee.employee-number')"
          />
        </b-form-group>
        <div class="group">
          <b-form-group class="pull_left" :label="$t('views.employee.first-name')" label-size="lg">
            <b-form-input
              v-model="first_name"
              class="first_name"
              type="text"
              readonly
              :placeholder="$t('views.employee.first-name')"
            />
          </b-form-group>
          <b-form-group class="pull_right" :label="$t('views.employee.last-name')" label-size="lg">
            <b-form-input
              v-model="last_name"
              class="input-last-name"
              type="text"
              readonly
              :placeholder="$t('views.employee.last-name')"
            />
          </b-form-group>
        </div>
        <b-form-group id="fieldset-4" :label="$t('views.employee.mail-address')" label-size="lg">
          <b-form-input
            v-model="mail_address"
            type="email"
            name="email"
            class="email"
            :placeholder="$t('views.employee.mail-address')"
          />
        </b-form-group>
      </section>
      <section v-if="isManager" class="manager_field">
        <b-form-group id="fieldset-5" :label="$t('views.employee.user-authority')" label-size="lg">
          <b-form-select id="select_role" v-model="user_authority">
            <b-form-select-option
              v-for="(option, index) in AuthorityList"
              :key="index"
              :value="option.value"
            >
              {{ (option.text) }}
            </b-form-select-option>
          </b-form-select>
        </b-form-group>
        <div class="input_line">
          <b-form-group id="fieldset-6" :label="$t('views.employee.retirement')" label-size="lg">
            <b-form-checkbox v-model="isRetirement" style="margin-top: 10px;" size="lg" class="check_box" />
            <b-form-input
              v-if="isRetirement"
              id="retirement"
              v-model="retirement"
              class="input_medium"
              type="date"
              name="retirement"
              :placeholder="$t('views.employee.input-retirement')"
              trim
            />
          </b-form-group>
        </div>
      </section>
      <section v-if="!isManager" class="crew_fields">
        <b-form-group id="fieldset-7" :label="$t('views.employee.current-password')" label-size="lg">
          <b-form-input
            v-model="current_password"
            autocomplete="new-password"
            type="password"
            name="current_password"
            :placeholder="$t('views.employee.current-password')"
          />
        </b-form-group>
        <b-form-group id="fieldset-87" :label="$t('views.employee.new-password')" label-size="lg">
          <b-form-input
            v-model="new_password"
            type="password"
            name="new_password"
            :placeholder="$t('views.employee.new-password')"
          />
        </b-form-group>
        <b-form-group id="fieldset-9" :label="$t('views.employee.confirm-new-password')" label-size="lg">
          <b-form-input
            v-model="confirm_new_password"
            type="password"
            name="confirm_new_password"
            :placeholder="$t('views.employee.confirm-new-password')"
          />
        </b-form-group>
      </section>
      <div class="form_action text-center">
        <button class="btn btn-footer" type="button" @click="returnToSalaryDetail()">
          {{ $t('views.employee.back') }}
        </button>
        <button class="btn btn-footer btn_submit" type="button" @click="submit()">
          {{ $t('views.employee.save') }}
        </button>
      </div>
    </form>
  </main>
</template>

<script>

import { changeSpecifyUserInfo, getSpecifyUserInfo } from '../../api/employee';
import { vToast } from '../../utils/toast_message';

export default {
    name: 'EmpUpdate',
    data() {
        return {
            AuthorityList: [],
            isManager: this.$store.state.user.auth.isManager,
            emp_code: this.$route.params.emp_code,
            first_name: '',
            last_name: '',
            mail_address: null,
            current_password: '',
            new_password: null,
            confirm_new_password: '',
            user_authority: '',
            retirement: '',
            isRetirement: false,
            isLoading: false,
            err: '',
        };
    },
    mounted() {
        this.getUserInfo();
    },
    methods: {
        async getUserInfo() {
            this.isLoading = true;
            await getSpecifyUserInfo(this.emp_code)
                .then((response) => {
                    const RAW_DATA = response.data;
                    if (response.code === 200) {
                        // this.employee_number = RAW_DATA.emp_code;
                        this.first_name = RAW_DATA.first_name;
                        this.last_name = RAW_DATA.last_name;
                        this.mail_address = RAW_DATA.email;
                        this.user_authority = RAW_DATA.role;
                        this.retirement = RAW_DATA.retirement_at;
                        this.isRetirement = RAW_DATA.retirement_at !== null;
                        this.AuthorityList = [
                            { value: 'CREW', text: 'CREW', disabled: false },
                            { value: 'MANAGER', text: 'MANAGER', disabled: false },
                        ];
                    } else {
                        vToast(response.message);
                    }
                })
                .catch(() => {
                    vToast('views.employee.warning');
                });
            this.isLoading = false;
        },
        submit() {
            this.err = '';
            if (!this.mail_address){
                this.err = 'notify.email_required';
            } else if (!this.mail_address.includes('@') || !this.mail_address.includes('.')){
                this.err = 'notify.email_wrong_format';
            }
            if (this.current_password) {
                if (!this.new_password) {
                    this.err = 'notify.password_required';
                }
                if (!this.new_password || this.new_password.length < 8) {
                    this.err = 'notify.password_min_length';
                }
                if (!this.confirm_new_password) {
                    this.err = 'notify.confirm_password_required';
                }
                if (this.confirm_new_password !== this.new_password) {
                    this.err = 'notify.confirm_password_notmatch';
                }
            }
            if (this.err){
                vToast(this.err);
                return;
            }
            this.authUpdateEmployeeInfo();
        },

        async authUpdateEmployeeInfo() {
            this.isLoading = true;
            let EMP_DATA = { email: this.mail_address };
            if (!this.isManager) {
                if (this.new_password){
                    EMP_DATA = {
                        ...EMP_DATA,
                        current_password: this.current_password,
                        password: this.new_password,
                        confirm_password: this.confirm_new_password,
                    };
                }
            } else {
                if (this.user_authority){
                    EMP_DATA.role = this.user_authority;
                }
                if (this.retirement){
                    EMP_DATA.retirement_at = this.retirement;
                }
                if (!this.isRetirement){
                    EMP_DATA.retirement_at = null;
                }
            }
            changeSpecifyUserInfo(this.emp_code, EMP_DATA)
                .then((response) => {
                    if (response.code === 200) {
                        vToast('views.employee.save-employee-info-successfully', 1);
                        this.returnToSalaryDetail();
                    } else {
                        vToast(response.message);
                    }
                })
                .catch((error) => {
                    vToast(error.message);
                });
            this.isLoading = false;
        },
        returnToSalaryDetail() {
            this.$router.push({ path: `/employee/index` }, (onAbort) => {});
        },
    },
};
</script>
