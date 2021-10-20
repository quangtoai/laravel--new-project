<template>
  <div class="service-record-table">
    <b-table-simple :bordered="true" :outlined="false" :fixed="false">
      <!-- Heading 1 -->
      <b-tr>
        <b-th :style="printStyle" class="vertical-header" rowspan="4">
          <span>{{ $t('views.salary-details.service-record-table.title') }}</span>
        </b-th>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.service-record-table.working-days') }}
          <i id="working-days" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="working-days" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.working-days') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.service-record-table.working-out-of-days') }}
          <i id="working-out-of-days" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="working-out-of-days" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.working-out-of-days') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.service-record-table.special-leave-days') }}
          <i id="special-leave-days" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="special-leave-days" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.special-leave-days') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span>{{ $t('views.salary-details.service-record-table.paid-off-days') }}</span>
          <i id="paid-off-days" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="paid-off-days" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.paid-off-days') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.service-record-table.off-days') }}
          <i id="off-days" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="off-days" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.off-days') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.service-record-table.remaining-paid-off-days') }}
          <i id="remaining-paid-off-days" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="remaining-paid-off-days" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.remaining-paid-off-days') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td :hidden="!isprint" class="bg_gray" />
        <b-td :hidden="!isprint" class="bg_gray" />
        <b-td :hidden="!isprint" class="bg_gray" />
        <b-td :hidden="!isprint" class="bg_gray" />
      </b-tr>
      <!-- Body 1 -->
      <b-tr>
        <b-td>
          <span>{{ obj.working_days }}</span>
        </b-td>
        <b-td>
          <span>{{ obj.working_out_of_days }}</span>
        </b-td>
        <b-td>
          <span>{{ obj.special_leave_days }}</span>
        </b-td>
        <b-td>
          <span>{{ obj.paid_off_days }}</span>
        </b-td>
        <b-td>
          <span>{{ obj.off_days }}</span>
        </b-td>
        <b-td>
          <span>{{ obj.remaining_paid_off_days }}</span>
        </b-td>
        <b-td :hidden="!isprint" />
        <b-td :hidden="!isprint" />
        <b-td :hidden="!isprint" />
        <b-td :hidden="!isprint" />
      </b-tr>
      <!-- Heading 2 -->
      <b-tr>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.service-record-table.working-time') }}
          <i id="working-time" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="working-time" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.working-time') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.service-record-table.late-early') }}
          <i id="late-early" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="late-early" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.late-early') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.service-record-table.common-ot') }}
          <i id="common-ot" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="common-ot" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.common-ot') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.service-record-table.hard-work-time-2') }}</span>
          <span v-else />
          <i id="hard-work-time-2" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="hard-work-time-2" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.hard-work-time-2') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint">{{ $t('views.salary-details.service-record-table.midnight-cp-time') }}</span>
          <span v-else>{{ $t('views.salary-details.service-record-table.hard-work-time-2') }}</span>
          <i id="midnight-cp-time" :hidden="isprint" class="icofont-question btn_helper" @hover="showExplaination" />
          <b-tooltip target="midnight-cp-time" triggers="hover" placement="leftbottom" variant="warning">
            <p class="explain-text">
              {{ $t('views.payslip.description.midnight-cp-time') }}
            </p>
          </b-tooltip>
        </b-td>
        <b-td class="bg_gray">
          <span v-if="!isprint" />
          <span v-else>{{ $t('views.salary-details.service-record-table.midnight-cp-time') }}</span>
        </b-td>
        <b-td :hidden="!isprint" class="bg_gray" />
        <b-td :hidden="!isprint" class="bg_gray">
          <span>{{ $t('views.salary-details.service-record-table.paid-scheduled-hours') }}</span>
        </b-td>
        <b-td :hidden="!isprint" class="bg_gray">
          <span>{{ $t('views.salary-details.service-record-table.paid-midnight-hours') }}</span>
        </b-td>

        <b-td :hidden="!isprint" class="bg_gray" />
      </b-tr>
      <!-- Body 2 -->
      <b-tr>
        <b-td>
          <span>{{ obj.working_time }}</span>
        </b-td>
        <b-td>
          <span>{{ obj.late_early }}</span>
        </b-td>
        <b-td>
          <span>{{ obj.common_ot }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.hard_work_time_2 }}</span>
          <span v-else />
        </b-td>
        <b-td>
          <span v-if="!isprint">{{ obj.midnight_cp_time }}</span>
          <span v-else>{{ obj.hard_work_time_2 }}</span>
        </b-td>
        <b-td>
          <span v-if="!isprint" />
          <span v-else>{{ obj.midnight_cp_time }}</span>
        </b-td>
        <b-td :hidden="!isprint" />
        <b-td :hidden="!isprint">
          <span>{{ obj.paid_scheduled_hours }}</span>
        </b-td>
        <b-td :hidden="!isprint">
          <span>{{ obj.paid_midnight_hours }}</span>
        </b-td>
        <b-td :hidden="!isprint" />
      </b-tr>
    </b-table-simple>
  </div>
</template>
<script>
export default {
    name: 'Servicerecord',
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
    created: function() {
        this.printStyle = 'background: #082e52;';
    },
    methods: {
        showExplaination() {},
    },
};
</script>
