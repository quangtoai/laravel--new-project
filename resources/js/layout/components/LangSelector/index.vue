<template>

  <b-dropdown
    id="dropdown-lang"
    text="Block Level Dropdown"
    block
  >
    <template #button-content>
      <b-icon
        icon="globe"
        font-scale="1.0"
        class="icon-globe"
      />

      <span>{{ $t('views.login.current_language') }}</span>
    </template>

    <b-dropdown-item
      :disabled="language ==='en'"
      @click="handleSetLanguage('en')"
    >
      {{ $t('navbar.languages.en') }}
    </b-dropdown-item>

    <b-dropdown-item
      :disabled="language ==='ja'"
      @click="handleSetLanguage('ja')"
    >
      {{ $t('navbar.languages.ja') }}
    </b-dropdown-item>
  </b-dropdown>

</template>

<script>
import { MakeToast } from '@/utils/toast_message';

export default {
    computed: {
        language() {
            return this.$store.getters.language;
        },
    },
    methods: {
        handleSetLanguage(lang) {
            this.$i18n.locale = lang;
            this.$store.dispatch('app/setLanguage', lang);
            var title = this.$t('notify.title');
            var content = this.$t('notify.content');
            MakeToast({ variant: 'success', title: title, content: content });
        },
    },
};
</script>

<style scoped>
  .icon-globe {
    margin-right: 8px;
  }
  #dropdown-lang{
    position: absolute;
        left: 30%;
  }
</style>
