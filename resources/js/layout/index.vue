<template>
  <div id="wrapper" :class="toggle">
    <Navbar @toggle="toggleMenu()" />
    <Sidebar />
    <div id="page-content-wrapper">
      <AppMain />
    </div>
  </div>
</template>

<script>
import Navbar from './components/Navbar/index';
import Sidebar from './components/Sidebar/index';
import AppMain from './components/AppMain';

export default {
    name: 'Layout',
    components: {
        AppMain,
        Sidebar,
        Navbar,
    },
    data() {
        return {
            toggle: '',
            toggleBool: false,
            timeNow: '',
        };
    },
    computed: {
        timeNowChange() {
            return this.timeNow;
        },
    },
    watch: {
        timeNowChange() {
            const EXP = (parseInt(this.$store.getters.token_expired) * 1000);

            if (this.timeNow >= EXP) {
                this.$store.dispatch('logout').then(() => {
                    this.$router.push('/login');
                });
            }
        },
    },
    mounted() {
        document.title = this.$store.state.user.auth.isManager ? this.$t('routes.manager_system') : this.$t('routes.crew_system');
        // window.setTimeout(this.getTimeNow, 1000);
    },
    methods: {
        getTimeNow() {
            this.timeNow = Date.now();
            window.setTimeout(this.getTimeNow, 1000);
        },
        toggleMenu(){
            this.toggleBool = !this.toggleBool;
            if (this.toggleBool === true){
                this.toggle = 'toggled';
            } else {
                this.toggle = '';
            }
        },
    },
};
</script>
