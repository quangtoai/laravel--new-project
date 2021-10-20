<template>
  <div>
    <div class="zone-display-table">
      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.payment-amount-table.net-payment') }}
              <i id="net-payment" class="icofont-question btn_helper" />
              <b-tooltip target="net-payment" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.net-payment') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.net_payment }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-amount-table.cash-salary') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.cash_salary }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-amount-table.transfer-amount-１') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.tranfer_amount_１ }}</span>
            </div>
          </b-col>
        </b-row>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: 'PaymentamountMB',
    props: {
        obj: {
            type: Object,
            required: true,
            default() {
                return {};
            },
        },
    },
};
</script>

<style>

</style>
