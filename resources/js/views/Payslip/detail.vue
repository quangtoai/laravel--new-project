<template>
  <main class="payslip_detail">
    <h2 class="title">{{ $t('routes.salary-details') }}</h2>
    <div v-if="isLoading" class="loading"><i class="spinner-border" /></div>
    <section class="header">
      <b-form-select v-model="params.month" class="select_month">
        <b-form-select-option v-for="(v, k) in listMonth" :key="k" :value="k">
          {{ (v) }}
        </b-form-select-option>
      </b-form-select>
      <div class="pull_right">
        <b-button id="btn-print-pdf" @click="prePrintPDF">PDF</b-button>
        <b-button id="helper" @click="showExplaination">
          <i class="icofont-question" />
          <b-tooltip target="helper" triggers="click" placement="leftbottom" variant="warning">
            <p class="explain-text helper_master">
              ?マークをクリックすると、<br>
              各項目の解説が表示されます。
            </p>
          </b-tooltip>
        </b-button>
      </div>
    </section>

    <div id="GeneralPDF" :style="printFontsize" class="content">
      <div v-if="windowWidth > 767">
        <h2 v-if="isPrint" class="text-center">{{ year_month }}</h2>
        <!-- Employee Table -->
        <empinfo :obj="obj" :isprint="isPrint" />
        <!-- Service Record table -->
        <servicerecord :obj="obj" :isprint="isPrint" />
        <!-- Payment table -->
        <payment :obj="obj" :isprint="isPrint" />
        <!-- Deduction table -->
        <deduction :obj="obj" :isprint="isPrint" />

        <section class="clearfix">
          <!-- Excess Tax table -->
          <excesstax :obj="obj" :isprint="isPrint" />
          <!-- Payment amount table -->
          <paymentamount :obj="obj" :isprint="isPrint" />
        </section>
      </div>

      <div v-else>
        <PayslipDetailMB :obj="obj" />
      </div>
    </div>
  </main>

</template>

<script>

import { getOne, getListMonthPayslip } from '../../api/payslip';

import { vToast } from '../../utils/toast_message';

import html2PDF from 'jspdf-html2canvas';

import empinfo from './detail_part/empinfo.vue';
import servicerecord from './detail_part/servicerecord';
import payment from './detail_part/payment.vue';
import deduction from './detail_part/deduction.vue';
import excesstax from './detail_part/excesstaxoriginal.vue';
import paymentamount from './detail_part/paymentamount.vue';

import PayslipDetailMB from './detail_mb/index.vue';

export default {
    name: 'PayslipDetail',
    components: {
        empinfo,
        servicerecord,
        payment,
        deduction,
        excesstax,
        paymentamount,
        PayslipDetailMB,
    },
    data() {
        return {
            params: {
                'emp_code': this.$route.params.emp_code,
                'month': this.$route.params.month,
            },
            printFontsize: 'font-size: 16px;',
            printStyle: 'background: #082e52;',
            isPrint: false,
            listMonth: {},
            obj: {},
            isLoading: false,
            year_month: '',
            isManager: this.$store.state.user.auth.isManager,
            windowWidth: window.innerWidth,
        };
    },

    computed: {
        isChangeMonth() {
            return this.params.month;
        },
    },

    watch: {
        isChangeMonth() {
            this.getDetail();
        },
    },
    created() {
        this.handleGetListMonth();
    },
    mounted() {
        if (!this.params.emp_code && this.$store.state.user.auth.isManager){
            window.location.href = process.env.MIX_LARAVEL_PATH + 'payslip/index';
        }
        this.$nextTick(() => {
            window.addEventListener('resize', this.onResize);
        });
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize);
    },
    methods: {
        onResize() {
            this.windowWidth = window.innerWidth;
        },

        async getDetail() {
            this.isLoading = true;
            await getOne(this.params)
                .then((response) => {
                    if (response.code === 200) {
                        this.obj = response.data;
                        if (this.obj.emp_code === undefined){
                            vToast('notify.data_notfound');
                        }
                    } else {
                        vToast(response.message);
                    }
                    this.isLoading = false;
                });
        },

        async handleGetListMonth() {
            await getListMonthPayslip().then((res) => {
                if (res.code === 200) {
                    this.listMonth = res.data.list_month;
                    this.params.month = res.data.current_month;
                    if (this.isManager){
                        this.getDetail();
                    }
                }
            });
        },

        prePrintPDF() {
            this.isPrint = true;
            this.printStyle = 'background: #545454;';
            this.printFontsize = 'font-size: 12px;';
            this.$nextTick().then(() => {
                this.printPDF();
                this.$nextTick().then(() => {
                    this.isPrint = false;
                    this.printStyle = 'background: #082e52;';
                    this.printFontsize = 'font-size: 16px;';
                });
            });
        },

        printPDF() {
            const container = document.getElementById('GeneralPDF');
            const filename = 'Payslip_' + this.params.month + '_' + this.params.emp_code;

            html2PDF(container, {
                jsPDF: {
                    format: 'a4',
                    orientation: 'l',
                },
                margin: {
                    top: 0,
                    right: 20,
                    bottom: 20,
                    left: 20,
                },
                imageType: 'image/jpeg',
                imageQuality: 1,
                output: `${filename}.pdf`,
            });
        },

        showExplaination() {

        },
    },
};
</script>
