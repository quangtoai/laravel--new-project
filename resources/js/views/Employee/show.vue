<template>
  <div id="veho_empshow">
    <h2 class="title1 transparent1" />
    <div class="main_content">
      <form class="form_auth">
        <h2 class="notice">
          {{ $t('views.notification.personal_info_seting_completed') }}
        </h2>
        <b-row style="width: 98%;">
          <b-col cols="12">
            <b-form-group id="fieldset-4" :label="$t('views.employee.mail-address')">
              <b-form-input
                v-model="auth.email"
                class="input_email "
                type="email"
                name="mail-address"
                disabled
              />
            </b-form-group>
          </b-col>
        </b-row>
        <b-row style="width: 98%;">
          <b-col cols="10">
            <b-form-group id="fieldset-7" :label="$t('views.employee.password')" label-size="lg">
              <b-form-input
                v-model="auth.password"
                class="input_password"
                :type="viewType"
                disabled
              />
            </b-form-group>
          </b-col>
          <b-col cols="2">
            <div class="text-center view_pass">
              <i id="view-icon" class="btn_show" :class="viewIcon" @click="isChangeViewMode()" />
            </div>
          </b-col>
        </b-row>
        <div class="action text-center">
          <button type="button" class="btn btn_submit" @click="toPayslip">
            {{ $t("views.employee.to-payslip-screen") }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>

export default {
    name: 'EmployeeShow',
    data() {
        return {
            // Employee: {
            //     email: this.$store.getters.email !== '' ? this.$store.getters.email : this.$store.getters.proxy_email,
            //     password: this.$store.getters.new_password,
            // },
            // emp_code: this.$store.getters.employee_number,
            auth: this.$store.state.user.auth,
            // month: '',
            viewIcon: 'icofont-eye-blocked',
            viewType: 'password',
            isView: false,
        };
    },
    methods: {
        isChangeViewMode() {
            console.log(this.auth, 33);
            this.isView = !this.isView;
            if (this.isView === true) {
                this.viewIcon = 'icofont-eye-alt';
                this.viewType = 'text';
            } else {
                this.viewIcon = 'icofont-eye-blocked';
                this.viewType = 'password';
            }
        },
        toPayslip() {
            this.$router.push(`/payslip/detail`);
        },
    },
};
</script>

<style scoped>
  #view-icon {
    cursor: pointer;
  }
</style>
