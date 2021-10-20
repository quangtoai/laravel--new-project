<template>
  <main id="veho_recovery">
    <form class="form_auth">
      <b-form-group id="fieldset-1" :label="$t('views.login.employee-number')" label-size="lg">
        <b-form-input
          v-model="Employee.number"
          name="emp_code"
          type="number"
          :placeholder="$t('views.login.employee-number')"
          @keyup.enter="handleRecovery()"
        />
      </b-form-group>
      <div class="action text-center">
        <button type="button" class="btn btn_submit" @click="handleRecovery()">
          {{ $t('views.login.btn-recovery') }}
        </button>
      </div>
    </form>
  </main>
</template>

<script>

// Import recovery api.
import { recoveryPassword } from '../../api/recovery';

// Import MakeToast function helper.
import { vToast } from '../../utils/toast_message';

export default {
    name: 'Recovery',

    data() {
        return {
            // Emaployee data.
            Employee: {
                number: '',
            },
        };
    },

    mounted() {},

    methods: {
        toNotificationScreen() {
            this.$router.push({ path: `/notification` }, (onAbort) => {});
        },
        async handleRecovery() {
            if (this.Employee.number === '') {
                vToast('views.login.require-employee-number');
            } else {
                const RECOVERY_DATA = {
                    emp_code: this.Employee.number,
                };
                await recoveryPassword(RECOVERY_DATA)
                    .then((response) => {
                        if (response.code === 200) {
                            vToast('views.recovery.success', 1);
                            this.toNotificationScreen();
                        } else {
                            vToast(response.message);
                        }
                    })
                    .catch(() => {
                        vToast('views.recovery.danger');
                    });
            }
        },
    },
};
</script>
