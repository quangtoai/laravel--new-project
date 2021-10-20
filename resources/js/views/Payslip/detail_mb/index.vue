<template>
  <div>
    <!-- Start EMP Info -->
    <div
      :class="visibleTable.empinfo ? null : 'collapsed'"
      :aria-expanded="visibleTable.empinfo ? 'true' : 'false'"
      aria-controls="collapse-empinfo"
      @click="visibleTable.empinfo = !visibleTable.empinfo"
    >
      <div class="header-table">
        <div class="header-note" />
        <div class="header-title">
          <span>{{ $t('views.salary-details.employee-table.title') }}</span>
        </div>
        <div class="icon-toggle">
          <span class="caret float-right when-opened">
            <i class="icofont-rounded-up" />
          </span>

          <span class="caret float-right when-closed">
            <i class="icofont-rounded-down" />
          </span>
        </div>
      </div>
    </div>
    <b-collapse id="collapse-empinfo" v-model="visibleTable.empinfo" class="mt-2">
      <b-card>
        <empinfoMB :obj="obj" />
      </b-card>
    </b-collapse>
    <!-- End EMP Info -->

    <!-- Start Service Record -->
    <div
      :class="visibleTable.servicerecord ? null : 'collapsed'"
      :aria-expanded="visibleTable.servicerecord ? 'true' : 'false'"
      aria-controls="collapse-servicerecord"
      @click="visibleTable.servicerecord = !visibleTable.servicerecord"
    >
      <div class="header-table">
        <div class="header-note" />
        <div class="header-title">
          <span>{{ $t('views.salary-details.service-record-table.title') }}</span>
        </div>
        <div class="icon-toggle">
          <span class="caret float-right when-opened">
            <i class="icofont-rounded-up" />
          </span>

          <span class="caret float-right when-closed">
            <i class="icofont-rounded-down" />
          </span>
        </div>
      </div>
    </div>
    <b-collapse id="collapse-servicerecord" v-model="visibleTable.servicerecord" class="mt-2">
      <b-card>
        <servicerecordMB :obj="obj" />
      </b-card>
    </b-collapse>
    <!-- End Service Record -->

    <!-- Start Payment -->
    <div
      :class="visibleTable.payment ? null : 'collapsed'"
      :aria-expanded="visibleTable.payment ? 'true' : 'false'"
      aria-controls="collapse-payment"
      @click="visibleTable.payment = !visibleTable.payment"
    >
      <div class="header-table">
        <div class="header-note" />
        <div class="header-title">
          <span>{{ $t('views.salary-details.payment-table.title') }}</span>
        </div>
        <div class="icon-toggle">
          <span class="caret float-right when-opened">
            <i class="icofont-rounded-up" />
          </span>

          <span class="caret float-right when-closed">
            <i class="icofont-rounded-down" />
          </span>
        </div>
      </div>
    </div>
    <b-collapse id="collapse-payment" v-model="visibleTable.payment" class="mt-2">
      <b-card>
        <paymentMB :obj="obj" />
      </b-card>
    </b-collapse>
    <!-- End Payment -->

    <!-- Start Deduction -->
    <div
      :class="visibleTable.deduction ? null : 'collapsed'"
      :aria-expanded="visibleTable.deduction ? 'true' : 'false'"
      aria-controls="collapse-deduction"
      @click="visibleTable.deduction = !visibleTable.deduction"
    >
      <div class="header-table">
        <div class="header-note" />
        <div class="header-title">
          <span>{{ $t('views.salary-details.deduction-table.title') }}</span>
        </div>
        <div class="icon-toggle">
          <span class="caret float-right when-opened">
            <i class="icofont-rounded-up" />
          </span>

          <span class="caret float-right when-closed">
            <i class="icofont-rounded-down" />
          </span>
        </div>
      </div>
    </div>
    <b-collapse id="collapse-deduction" v-model="visibleTable.deduction" class="mt-2">
      <b-card>
        <deductionMB :obj="obj" />
      </b-card>
    </b-collapse>
    <!-- End Deduction -->

    <!-- Start Excess Tax -->
    <div
      :class="visibleTable.excesstaxoriginal ? null : 'collapsed'"
      :aria-expanded="visibleTable.excesstaxoriginal ? 'true' : 'false'"
      aria-controls="collapse-excesstaxoriginal"
      @click="visibleTable.excesstaxoriginal = !visibleTable.excesstaxoriginal"
    >
      <div class="header-table">
        <div class="header-note" />
        <div class="header-title">
          <span>{{ $t('views.salary-details.excess-tax-table.title') }}</span>
        </div>
        <div class="icon-toggle">
          <span class="caret float-right when-opened">
            <i class="icofont-rounded-up" />
          </span>

          <span class="caret float-right when-closed">
            <i class="icofont-rounded-down" />
          </span>
        </div>
      </div>
    </div>
    <b-collapse id="collapse-excesstaxoriginal" v-model="visibleTable.excesstaxoriginal" class="mt-2">
      <b-card>
        <excesstaxoriginalMB :obj="obj" />
      </b-card>
    </b-collapse>
    <!-- End Excess Tax -->

    <!-- Start Payment Amount -->
    <div
      :class="visibleTable.paymentamount ? null : 'collapsed'"
      :aria-expanded="visibleTable.paymentamount ? 'true' : 'false'"
      aria-controls="collapse-paymentamount"
      @click="visibleTable.paymentamount = !visibleTable.paymentamount"
    >
      <div class="header-table">
        <div class="header-note" />
        <div class="header-title">
          <span> {{ $t('views.salary-details.payment-amount-table.title') }}</span>
        </div>
        <div class="icon-toggle">
          <span class="caret float-right when-opened">
            <i class="icofont-rounded-up" />
          </span>

          <span class="caret float-right when-closed">
            <i class="icofont-rounded-down" />
          </span>
        </div>
      </div>
    </div>
    <b-collapse id="collapse-paymentamount" v-model="visibleTable.paymentamount" class="mt-2">
      <b-card>
        <paymentamountMB :obj="obj" />
      </b-card>
    </b-collapse>
    <!-- End Payment Amount -->
  </div>
</template>

<script>

import empinfoMB from './components/empinfo.vue';
import servicerecordMB from './components/servicerecord.vue';
import paymentMB from './components/payment.vue';
import deductionMB from './components/deduction.vue';
import excesstaxoriginalMB from './components/excesstaxoriginal.vue';
import paymentamountMB from './components/paymentamount.vue';

export default {
    name: 'PayslipDetailMB',
    components: {
        empinfoMB,
        servicerecordMB,
        paymentMB,
        deductionMB,
        excesstaxoriginalMB,
        paymentamountMB,
    },
    props: {
        obj: {
            type: Object,
            required: true,
            default() {
                return {};
            },
        },
    },
    data() {
        return {
            visibleTable: {
                deduction: false,
                empinfo: false,
                excesstaxoriginal: false,
                payment: false,
                paymentamount: false,
                servicerecord: false,
            },
        };
    },
};
</script>
