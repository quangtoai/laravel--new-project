<template>
  <div>
    <div class="zone-display-table">
      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.payment-table.basic-salary') }}
              <i id="basic-salary" class="icofont-question btn_helper" />
              <b-tooltip target="basic-salary" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.basic-salary') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.basic_salary }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-table.salary-for-performance') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.salary_for_performance }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-table.position-cp') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.position_cp }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-table.heavy-truck-cp') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.heavy_truck_cp }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-table.bd-cp') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.bd_cp }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-table.other-cp') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.other_cp }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-table.ot-salary-cp') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.ot_salary_cp }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-table.hard-work-2-cp') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.hard_work_2_cp }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-table.midnight-cp-time') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.midnight_cp }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-table.paid-off-adjustment') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.paid_off_adjustment }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-table.ot-cp-adjustment') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.ot_cp_adjustment }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-table.last-month-adjustment') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.last_month_adjustment }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-table.adjusted-salary') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.adjusted_salary }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.payment-table.bounty') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.bounty }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.payment-table.attendance-deduction') }}
              <i id="attendance-deduction" class="icofont-question btn_helper" />
              <b-tooltip target="attendance-deduction" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.attendance-deduction') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.attendance_deduction }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.payment-table.other-payment-paid-off') }}
              <i id="other-payment-paid-off" class="icofont-question btn_helper" />
              <b-tooltip target="other-payment-paid-off" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.other-payment-paid-off') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.other_payment_paid_off }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.payment-table.ot-adjustment-cp') }}
              <i id="ot-adjustment-cp" class="icofont-question btn_helper" />
              <b-tooltip target="ot-adjustment-cp" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.ot-adjustment-cp') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.ot_adjustment_cp }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.payment-table.reduced-amount') }}
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.reduced_amount }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.payment-table.taxable-amount') }}
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.taxable_amount }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.payment-table.transportation-cp') }}
              <i id="transportation-cp" class="icofont-question btn_helper" />
              <b-tooltip target="transportation-cp" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.transportation-cp') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.transportation_cp }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.payment-table.total-amount-of-payment') }}
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.total_amount_of_payment }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

    </div>
  </div>
</template>

<script>
export default {
    name: 'PaymentMB',
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
