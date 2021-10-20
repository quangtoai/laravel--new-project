<template>
  <div>
    <div class="zone-display-table">
      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.service-record-table.working-days') }}

              <i id="working-days" class="icofont-question btn_helper" />
              <b-tooltip target="working-days" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.working-days') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.working_days }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.service-record-table.working-out-of-days') }}
              <i id="working-out-of-days" class="icofont-question btn_helper" />
              <b-tooltip target="working-out-of-days" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.working-out-of-days') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.working_out_of_days }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.service-record-table.special-leave-days') }}
              <i id="special-leave-days" class="icofont-question btn_helper" />
              <b-tooltip target="special-leave-days" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.special-leave-days') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.special_leave_days }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.service-record-table.paid-off-days') }}</span>
              <i id="paid-off-days" class="icofont-question btn_helper" />
              <b-tooltip target="paid-off-days" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.paid-off-days') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.paid_off_days }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.service-record-table.off-days') }}
              <i id="off-days" class="icofont-question btn_helper" />
              <b-tooltip target="off-days" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.off-days') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.off_days }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              {{ $t('views.salary-details.service-record-table.remaining-paid-off-days') }}
              <i id="remaining-paid-off-days" class="icofont-question btn_helper" />
              <b-tooltip target="remaining-paid-off-days" triggers="hover" placement="leftbottom" variant="warning">
                <p class="explain-text">
                  {{ $t('views.payslip.description.remaining-paid-off-days') }}
                </p>
              </b-tooltip>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.remaining_paid_off_days }}</span>
            </div>
          </b-col>
        </b-row>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: 'ServicerecordMB',
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
