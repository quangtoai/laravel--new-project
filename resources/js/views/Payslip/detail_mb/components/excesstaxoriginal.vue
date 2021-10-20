<template>
  <div>
    <div class="zone-display-table">
      <div class="zone-display-row">
        <b-row>
          <b-col cols="6">
            <div class="zone-title">
              <span>{{ $t('views.salary-details.excess-tax-table.payable-overpaid-tax') }}</span>
            </div>
          </b-col>

          <b-col cols="6">
            <div class="zone-value">
              <span>{{ obj.payable_overpaid_tax }}</span>
            </div>
          </b-col>
        </b-row>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: 'ExcesstaxoriginalMB',
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
