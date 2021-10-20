<template>
  <div ref="PaymentAmountTable" class="payment-amount-table">
    <b-table-simple :bordered="true" :outlined="false" :fixed="false">
      <!-- Heading -->
      <b-tr>
        <b-th :hidden="isprint" :style="printStyle" class="vertical-header" rowspan="2">
          {{ $t('views.salary-details.payment-amount-table.title') }}
        </b-th>
        <b-td v-if="!isprint" class="bg_gray">
          {{ $t('views.salary-details.payment-amount-table.net-payment') }}
          <i id="net-payment" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="net-payment" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.net-payment') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td v-else style="background: #545454 !important; color: #ffffff;" class="bg_gray">
          {{ $t('views.salary-details.payment-amount-table.net-payment') }}
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-amount-table.cash-salary') }}</span>
          <span v-else>{{ $t('views.salary-details.payment-amount-table.transfer-amount-１') }}</span>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-amount-table.transfer-amount-１') }}</span>
          <span v-else>{{ $t('views.salary-details.payment-amount-table.transfer-amount-2') }}</span>
        </b-td>
        <b-td :hidden="!isprint" class="bg_gray">
          <span>{{ $t('views.salary-details.payment-amount-table.cash-salary') }}</span>
        </b-td>
        <b-td :hidden="!isprint" class="bg_gray">
          <span>{{ $t('views.salary-details.payment-amount-table.carry-over-amount-to-the-following-month') }}</span>
        </b-td>
        <b-td :hidden="!isprint" class="bg_gray">
          <span>{{ $t('views.salary-details.payment-amount-table.carried-over-amount-from-previous-month') }}</span>
        </b-td>
      </b-tr>
      <!-- Body -->
      <b-tr>
        <b-td>
          <span>{{ obj.net_payment }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.cash_salary }}</span>
          <span v-else>{{ obj.tranfer_amount_１ }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.tranfer_amount_１ }}</span>
          <span v-else>{{ obj.tranfer_amount_2 }}</span>
        </b-td>
        <b-td :hidden="!isprint">
          <span>{{ obj.cash_salary }}</span>
        </b-td>
        <b-td :hidden="!isprint">
          <span>{{ obj.carry_over_amount_to_the_following_month }}</span>
        </b-td>
        <b-td :hidden="!isprint">
          <span>{{ obj.carried_over_amount_from_previous_month }}</span>
        </b-td>
      </b-tr>
    </b-table-simple>
  </div>
</template>

<script>
export default {
    name: 'PaymentAmount',
    props: {
        obj: {
            type: Object,
            required: true,
            default() {
                return {};
            },
        },
        isprint: {
            type: Boolean,
            required: true,
        },
    },
    created() {
        this.printStyle = 'background: #082e52;';
    },
    methods: {
        showExplaination() {},
    },
};
</script>
