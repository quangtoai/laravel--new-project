<template>
  <div ref="DeductionTable" class="deduction-table">
    <b-table-simple :bordered="true" :outlined="false" :fixed="false">
      <!-- Row 1 -->
      <b-tr>
        <b-th :style="printStyle" class="vertical-header" rowspan="8">
          {{ $t('views.salary-details.deduction-table.title') }}
        </b-th>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.deduction-table.health-insurance-premium') }}
          <i id="health-insurance-premium" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="health-insurance-premium" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.health-insurance-premium') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.nursing-care-insurance-premium') }}</span>
          <span v-else>{{ $t('views.salary-details.deduction-table.welfare-pension-insurance-premium') }}</span>
          <i id="nursing-care-insurance-premium" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="nursing-care-insurance-premium" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.nursing-care-insurance-premium') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.welfare-pension-insurance-premium') }}</span>
          <span v-else />
          <i id="welfare-pension-insurance-premium" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="welfare-pension-insurance-premium" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.welfare-pension-insurance-premium') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.deduction-table.unemployment-insurance-premium') }}
          <i id="unemployment-insurance-premium" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="unemployment-insurance-premium" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.unemployment-insurance-premium') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.total-insurance-amount') }}</span>
          <span v-else>{{ $t('views.salary-details.deduction-table.pit') }}</span>
          <i id="total-insurance-amount" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="total-insurance-amount" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.total-insurance-amount') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.pit') }}</span>
          <span v-else>{{ $t('views.salary-details.deduction-table.inhabitant-tax') }}</span>
          <i id="pit" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="pit" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.personal-income-tax') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td :hidden="!isprint" class="bg_gray">
          <span v-if="!isprint" />
          <span v-else>{{ $t('views.salary-details.deduction-table.apartment-fee') }}</span>
        </b-td>
      </b-tr>
      <!-- Row 2 -->
      <b-tr>
        <b-td>
          <span>{{ obj.health_insurance }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.nursing_care_insurance }}</span>
          <span v-else>{{ obj.welfare_pension_insurance }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.welfare_pension_insurance }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span>{{ obj.unemployment_insurance }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.total_insurance_amount }}</span>
          <span v-else>{{ obj.pit }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.pit }}</span>
          <span v-else>{{ obj.inhabitant_tax }}</span>
        </b-td>
        <b-td :hidden="!isprint">
          <span v-if="!isprint" />
          <span v-else>{{ obj.apartment_fee }}</span>
        </b-td>
      </b-tr>
      <!-- Row 3 -->
      <b-tr>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.inhabitant-tax') }}</span>
          <span v-else />
          <i id="inhabitant-tax" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="inhabitant-tax" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.inhabitant-tax') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.inhabitant-tax-deduction') }}</span>
          <span v-else>{{ $t('views.salary-details.deduction-table.other-2') }}</span>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.apartment-fee') }}</span>
          <span v-else />
          <i id="apartment-fee" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="apartment-fee" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.apartment-fee') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.other-1') }}</span>
          <span v-else />
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.other-2') }}</span>
          <span v-else />
          <i id="other-2" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="other-2" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.other-2') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.other-3') }}</span>
          <span v-else />
        </b-td>
        <b-td :hidden="!isprint" class="bg_gray">
          <span v-if="!isprint" />
          <span v-else>{{ $t('views.salary-details.deduction-table.advance-paid') }}</span>
        </b-td>
      </b-tr>
      <!-- Row 4 -->
      <b-tr>
        <b-td>
          <span v-if="!isprint">{{ obj.inhabitant_tax }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.inhabitant_tax_deduction }}</span>
          <span v-else>{{ obj.other_2 }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.apartment_fee }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.other_1 }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.other_2 }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.other_3 }}</span>
          <span v-else />
        </b-td>
        <b-td :hidden="!isprint">
          <span v-if="!isprint" />
          <span v-else>{{ obj.advance_paid }}</span>
        </b-td>
      </b-tr>
      <!-- Row 5 -->
      <b-tr>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.incurred-transfer-previous-month') }}</span>
          <span v-else>{{ $t('views.salary-details.deduction-table.withholding') }}</span>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.advance-paid') }}</span>
          <span v-else />
          <i id="advance-paid" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="advance-paid" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.advance-paid') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.withholding') }}</span>
          <span v-else />
          <i id="withholding" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="withholding" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.withholding') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.adjustment-deduction') }}</span>
          <span v-else />
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.year-end-adjustment') }}</span>
          <span v-else />
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.deduction-table.total-deduction-amount') }}</span>
          <span v-else />
          <i id="total-deduction-amount" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="total-deduction-amount" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.total-deduction-amount') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td style="background: #545454 !important;" :hidden="!isprint" class="bg_gray">
          <span style="color: #ffffff;">{{ $t('views.salary-details.deduction-table.total-deduction-amount') }}</span>
        </b-td>
      </b-tr>
      <!-- Row 6 -->
      <b-tr>
        <b-td>
          <span v-if="!isprint">{{ obj.incurred_previous_month }}</span>
          <span v-else>{{ obj.withholding }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.advance_paid }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.withholding }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.adjustment_deduction }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.year_end_adjustment }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.total_dedution_amount }}</span>
          <span v-else />
        </b-td>
        <b-td :hidden="!isprint">
          <span>{{ obj.total_dedution_amount }}</span>
        </b-td>
      </b-tr>
    </b-table-simple>
  </div>
</template>

<script>
export default {
    name: 'Deduction',
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
