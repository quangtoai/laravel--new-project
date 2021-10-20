import Vue from 'vue';
import VueI18n from 'vue-i18n';

import en from './en.json';
import ja from './ja.json';

import { getLanguage } from '../utils/getLang';

Vue.use(VueI18n);

export const languages = {
    en: en,
    ja: ja,
};

const messages = Object.assign(languages);

export default new VueI18n({
    locale: getLanguage(),
    fallbackLocale: getLanguage(),
    messages: messages,
    silentTranslationWarn: true,
});
