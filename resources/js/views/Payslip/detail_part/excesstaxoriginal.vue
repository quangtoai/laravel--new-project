<template>
  <div v-if="!isprint" ref="ExcessTaxTable" class="excess-tax-table">
    <b-table-simple :bordered="true" :outlined="false" :fixed="false" class="excess-tax">
      <!-- Heading -->
      <b-tr>
        <b-th :style="printStyle" class="vertical-header" rowspan="2">
          {{ $t('views.salary-details.excess-tax-table.title') }}
        </b-th>
        <b-td class="bg_gray">
          {{ $t('views.salary-details.excess-tax-table.payable-overpaid-tax') }}
        </b-td>
      </b-tr>
      <!-- Body -->
      <b-tr>
        <b-td>
          <span>{{ obj.payable_overpaid_tax }}</span>
        </b-td>
      </b-tr>
    </b-table-simple>
  </div>
</template>

<script>
export default {
    name: 'ExcessTax',
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
