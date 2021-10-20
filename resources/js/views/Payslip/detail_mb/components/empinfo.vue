<template>
  <div>
    <div class="zone-display-table">
      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.employee-table.department') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.department }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.employee-table.employee-number') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.emp_code }}</span>
            </div>
          </b-col>
        </b-row>
      </div>

      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.employee-table.full-name') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.full_name }}</span>
            </div>
          </b-col>
        </b-row>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: 'EmpinfoMB',
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
