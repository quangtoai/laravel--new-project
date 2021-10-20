<template>
  <!-- Start navbar -->
  <b-navbar toggleable="lg" type="dark">
    <!-- Navbar brand -->
    <b-navbar-brand @click.prevent.stop="$emit('toggle')">
      <b-icon id="toggle-menu" class="icon-justify" icon="justify" />
    </b-navbar-brand>

    <!-- Title -->
    <!-- <b-navbar-nav class="icon-justify">
      <b-navbar-toggle target="sidebar-collapse">
        <b-icon icon="justify" />
      </b-navbar-toggle>
      <b-collapse id="sidebar-collapse" is-nav>
        <SideBar />
      </b-collapse>
    </b-navbar-nav> -->

    <b-navbar-nav>
      <img id="logo" src="../../../assets/images/logo3.png" alt="">
    </b-navbar-nav>

    <!-- Navbar toggle -->
    <b-navbar-toggle target="nav-collapse">
      <template #default="{ expanded }">
        <b-icon v-if="expanded" icon="chevron-bar-up" />
        <b-icon v-else icon="chevron-bar-down" />
      </template>
    </b-navbar-toggle>

    <!-- Navbar collapse -->
    <b-collapse id="nav-collapse" is-nav>

      <!-- Employee's name display and Logout area -->
      <b-navbar-nav class="ml-auto">
        <!-- Language selector -->
        <LangSelector />
        <span class="btn-gray">{{ employeeName }}</span>
        <button id="btn_logout" class="btn-gray" @click="doLogout()">
          {{ $t('navbar.logout') }}
        </button>
      </b-navbar-nav>
    </b-collapse>

    <!-- End of navbar -->
  </b-navbar>
</template>
<script>
import { MakeToast } from '../../../utils/toast_message';
import LangSelector from '../LangSelector/index.vue';

export default {
    name: 'Navbar',

    components: {
        LangSelector: LangSelector,
    },

    computed: {
        employeeName() {
            return this.$store.state.user.auth.first_name + ' ' + this.$store.state.user.auth.last_name;
        },
        title() {
            return this.$route.meta.title;
        },
    },
    methods: {
        doLogout() {
            this.$store.dispatch('logout').then(() => {
                MakeToast({
                    variant: 'success',
                    title: this.$t('views.logout.title'),
                    content: this.$t('views.logout.content'),
                });
                this.$router.push('/login');
            });
        },
    },
};
</script>
