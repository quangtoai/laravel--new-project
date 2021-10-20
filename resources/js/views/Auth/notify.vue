<template>
  <main class="page_notify">
    <h2 class="notify">
      {{ $t('views.notification.password-reissue-notification-registered') }}<br>
      {{ $t('views.notification.sent-to-email-address') }}
    </h2>
    <p class="notify" style="margin-top: 50px;">
      {{ $t('views.notification.second-notify') }}
    </p>
    <p class="notify" style="margin-top: 20px;">
      {{ $t('views.notification.third-notify') }}
    </p>
    <p class="notify" style="margin-top: 20px;">
      {{ $t('views.notification.fourth-notify') }}
    </p>
    <br><br>
    <a class="btn btn_blue btn_submit" @click="goToLogin()">
      {{ $t('views.employee.goto-login') }}
    </a>
  </main>
</template>

<script>

export default {
    name: 'Notification',

    data() {
        return {

        };
    },

    mounted() {},

    methods: {
        goToLogin() {
            this.$router.push({ path: `/login` }, (onAbort) => {});
        },
    },
};
</script>
