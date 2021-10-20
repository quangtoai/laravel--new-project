<template>
  <div class="payment-table">
    <b-table-simple :bordered="true" :outlined="false" :fixed="false">
      <!-- Row 1 -->
      <b-tr>
        <b-th :style="printStyle" class="vertical-header" rowspan="8">
          {{ $t('views.salary-details.payment-table.title') }}
        </b-th>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.payment-table.basic-salary') }}
          <i id="basic-salary" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="basic-salary" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.basic-salary') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.payment-table.salary-for-performance') }}
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-table.position-cp') }}</span>
          <span v-else />
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-table.heavy-truck-cp') }}</span>
          <span v-else />
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-table.bd-cp') }}</span>
          <span v-else />
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-table.other-cp') }}</span>
          <span v-else />
        </b-td>
        <b-td :hidden="!isprint" class="bg_gray" />
      </b-tr>
      <!-- Row 2 -->
      <b-tr>
        <b-td>
          <span>{{ obj.basic_salary }}</span>
        </b-td>
        <b-td>
          <span>{{ obj.salary_for_performance }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.position_cp }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.heavy_truck_cp }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.bd_cp }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.other_cp }}</span>
          <span v-else />
        </b-td>
        <b-td :hidden="!isprint" />
      </b-tr>
      <!-- Row 3 -->
      <b-tr>
        <b-td class="bg_gray">
          <span v-if="!isprint" class="font_normal">{{ $t('views.salary-details.payment-table.ot-salary-cp') }}</span>
          <span v-else />
          <i id="ot-salary-cp" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="ot-salary-cp" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.ot-salary-cp') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-table.hard-work-2-cp') }}</span>
          <span v-else />
          <i id="hard-work-2-cp" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="hard-work-2-cp" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.hard-work-2-cp') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-table.midnight-cp-time') }}</span>
          <span v-else />
          <i id="midnight-cp-time" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="midnight-cp-time" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.midnight-cp') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-table.paid-off-adjustment') }}</span>
          <span v-else />
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-table.ot-cp-adjustment') }}</span>
          <span v-else />
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-table.last-month-adjustment') }}</span>
          <span v-else>{{ $t('views.salary-details.payment-table.attendance-deduction') }}</span>
        </b-td>
        <b-td :hidden="!isprint" class="bg_gray">
          <span v-if="!isprint" />
          <span v-else>{{ $t('views.salary-details.payment-table.other-payment-paid-off') }}</span>
        </b-td>
      </b-tr>
      <!-- Row 4 -->
      <b-tr>
        <b-td>
          <span v-if="!isprint">{{ obj.ot_salary_cp }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.hard_work_2_cp }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.midnight_cp }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.paid_off_adjustment }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.ot_cp_adjustment }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.last_month_adjustment }}</span>
          <span v-else>{{ obj.attendance_deduction }}</span>
        </b-td>
        <b-td :hidden="!isprint">
          <span v-if="!isprint" />
          <span v-else>{{ obj.other_payment_paid_off }}</span>
        </b-td>
      </b-tr>
      <!-- Row 5 -->
      <b-tr :hidden="isprint">
        <b-td class="bg_gray">
          {{ $t('views.salary-details.payment-table.adjusted-salary') }}
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.payment-table.bounty') }}
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.payment-table.attendance-deduction') }}
          <i id="attendance-deduction" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="attendance-deduction" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.attendance-deduction') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.payment-table.other-payment-paid-off') }}
          <i id="other-payment-paid-off" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="other-payment-paid-off" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.other-payment-paid-off') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.payment-table.ot-adjustment-cp') }}
          <i id="ot-adjustment-cp" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="ot-adjustment-cp" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.ot-adjustment-cp') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.payment-table.reduced-amount') }}
        </b-td>
        <b-td :hidden="!isprint" class="bg_gray" />
      </b-tr>
      <!-- Row 6 -->
      <b-tr :hidden="isprint">
        <b-td>
          <span>{{ obj.adjusted_salary }}</span>
        </b-td>
        <b-td>
          <span>{{ obj.bounty }}</span>
        </b-td>
        <b-td>
          <span>{{ obj.attendance_deduction }}</span>
        </b-td>
        <b-td>
          <span>{{ obj.other_payment_paid_off }}</span>
        </b-td>
        <b-td>
          <span>{{ obj.ot_adjustment_cp }}</span>
        </b-td>
        <b-td>
          <span>{{ obj.reduced_amount }}</span>
        </b-td>
        <b-td :hidden="!isprint" />
      </b-tr>
      <!-- Row 7 -->
      <b-tr>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-table.taxable-amount') }}</span>
          <span v-else>{{ $t('views.salary-details.payment-table.ot-adjustment-cp') }}</span>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-table.transportation-cp') }}</span>
          <span v-else>{{ $t('views.salary-details.payment-table.hard-work-2-cp') }}</span>
          <i id="transportation-cp" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="transportation-cp" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.transportation-cp') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.payment-table.total-amount-of-payment') }}</span>
          <span v-else>{{ $t('views.salary-details.service-record-table.midnight-cp-time') }}</span>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint" />
          <span v-else>{{ $t('views.salary-details.payment-table.transportation-cp') }}</span>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint" />
          <span v-else>{{ $t('views.salary-details.payment-table.ot-salary-cp') }}</span>
        </b-td>
        <b-td class="bg_gray" />
        <b-td style="background: #545454 !important;" :hidden="!isprint" class="bg_gray">
          <span style="color: #ffffff;">{{ $t('views.salary-details.payment-table.gross-payment') }}</span>
        </b-td>
      </b-tr>
      <!-- Row 8 -->
      <b-tr>
        <b-td>
          <span v-if="!isprint">{{ obj.taxable_amount }}</span>
          <span v-else>{{ obj.ot_salary_cp }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.transportation_cp }}</span>
          <span v-else>{{ obj.hard_work_2_cp }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.total_amount_of_payment }}</span>
          <span v-else>{{ obj.midnight_cp_time }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint" />
          <span v-else>{{ obj.transportation_cp }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint" />
          <span v-else>{{ obj.ot_salary_cp }}</span>
        </b-td>
        <b-td />
        <b-td :hidden="!isprint">
          <span>{{ obj.gross_payment }}</span>
        </b-td>
      </b-tr>
    </b-table-simple>
  </div>
</template>
<script>
export default {
    name: 'Payment',
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
