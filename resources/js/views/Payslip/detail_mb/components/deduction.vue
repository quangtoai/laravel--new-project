<template>
  <div>
    <div class="zone-display-table">

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.health-insurance-premium') }}
              <i id="health-insurance-premium" class="icofont-question btn_helper" />
              <b-tooltip target="health-insurance-premium" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.health-insurance-premium') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.health_insurance }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.nursing-care-insurance-premium') }}
              <i id="nursing-care-insurance-premium" class="icofont-question btn_helper" />
              <b-tooltip target="nursing-care-insurance-premium" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.nursing-care-insurance-premium') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.nursing_care_insurance }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.welfare-pension-insurance-premium') }}
              <i id="welfare-pension-insurance-premium" class="icofont-question btn_helper" />
              <b-tooltip target="welfare-pension-insurance-premium" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.welfare-pension-insurance-premium') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.welfare_pension_insurance }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.unemployment-insurance-premium') }}
              <i id="unemployment-insurance-premium" class="icofont-question btn_helper" />
              <b-tooltip target="unemployment-insurance-premium" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.unemployment-insurance-premium') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.unemployment_insurance }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.total-insurance-amount') }}
              <i id="total-insurance-amount" class="icofont-question btn_helper" />
              <b-tooltip target="total-insurance-amount" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.total-insurance-amount') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.total_insurance_amount }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.pit') }}
              <i id="pit" class="icofont-question btn_helper" />
              <b-tooltip target="pit" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.personal-income-tax') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.pit }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.inhabitant-tax') }}
              <i id="inhabitant-tax" class="icofont-question btn_helper" />
              <b-tooltip target="inhabitant-tax" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.inhabitant-tax') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.inhabitant_tax }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.inhabitant-tax-deduction') }}
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.inhabitant_tax_deduction }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.apartment-fee') }}
              <i id="apartment-fee" class="icofont-question btn_helper" />
              <b-tooltip target="apartment-fee" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.apartment-fee') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.apartment_fee }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.other-1') }}
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.other_1 }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.other-2') }}
              <i id="other-2" class="icofont-question btn_helper" />
              <b-tooltip target="other-2" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.other-2') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.other_2 }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.other-3') }}
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.other_3 }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.incurred-transfer-previous-month') }}
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.incurred_previous_month }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.advance-paid') }}
              <i id="advance-paid" class="icofont-question btn_helper" />
              <b-tooltip target="advance-paid" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.advance-paid') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.advance_paid }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.withholding') }}
              <i id="withholding" class="icofont-question btn_helper" />
              <b-tooltip target="withholding" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.withholding') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.withholding }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.adjustment-deduction') }}
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.adjustment_deduction }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.year-end-adjustment') }}
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.year_end_adjustment }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.deduction-table.total-deduction-amount') }}
              <i id="total-deduction-amount" class="icofont-question btn_helper" />
              <b-tooltip target="total-deduction-amount" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.total-deduction-amount') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.total_dedution_amount }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

    </div>
  </div>
</template>

<script>
export default {
    name: 'DeductionMB',
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
