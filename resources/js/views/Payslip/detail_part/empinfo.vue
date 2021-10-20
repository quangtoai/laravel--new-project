<template>
  <div class="employee-table emp_info">
    <b-table-simple :bordered="true" :outlined="false" :fixed="false">
      <!-- Heading -->
      <b-tr>
        <b-th class="vertical-header" :style="printStyle" rowspan="2">
          <span>{{ $t('views.salary-details.employee-table.title') }}</span>
        </b-th>
        <b-td class="bg_gray">
          <span>{{ $t('views.salary-details.employee-table.department') }}</span>
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.employee-table.employee-number') }}
        </b-td>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.employee-table.full-name') }}
        </b-td>
      </b-tr>
      <!-- Body -->
      <b-tr>

        <b-td>
          <span>{{ obj.department }}</span>
        </b-td>

        <b-td>
          <span>{{ obj.emp_code }}</span>
        </b-td>

        <b-td>
          <span>{{ obj.full_name }}</span>
        </b-td>
      </b-tr>
    </b-table-simple>
  </div>

</template>
<script>
export default {
    name: 'Empinfo',
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
