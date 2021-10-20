<template>
  <main>
    <h2 class="title">{{ $t("routes.payslip") }}</h2>
    <div v-if="isLoading" class="loading"><i class="spinner-border" /></div>
    <b-form-select v-model="params.month" class="select_month">
      <b-form-select-option v-for="(v, k) in listMonth" :key="k" :value="k">
        {{ (v) }}
      </b-form-select-option>
    </b-form-select>
    <div class="filter-zone">
      <hr>
      <span class="btn_dropdown_filter" @click="dropdownFilter">
        <i :class="icon" />
        {{ $t('views.employee.filter') }}
      </span>
      <div v-show="isShowFilter" class="content">
        <span class="btn_clear" @click="clearFilter">{{ $t('views.employee.clear') }}</span>
        <div class="input_line"><!-- Employee Code Filter -->
          <b-form-checkbox v-model="isFilterCode" class="checkbox_filtercode" size="lg" />
          <label class="label_search"> {{ $t('views.employee.employee-code') }}</label>
          <b-form-input
            v-model="params.emp_code"
            class="input_short"
            name="emp_code"
            type="number"
            :disabled="!isFilterCode"
            :placeholder="$t('views.employee.employee-code')"
            trim
          />
        </div>

        <!-- Employee Name input -->
        <div class="input_line">
          <b-form-checkbox v-model="isFilterName" class="checkbox_filtername" size="lg" />
          <label class="label_search">{{ $t('views.employee.employee-name') }}</label>
          <b-form-input
            v-model="params.emp_name"
            class="input_short"
            name="emp_name"
            type="text"
            :disabled="!isFilterName"
            :placeholder="$t('views.employee.employee-name')"
            trim
          />
        </div>
        <b-button class="btn_apply" @click="getList()"> {{ $t('views.employee.apply') }}</b-button>
        <hr>
      </div>
    </div>

    <b-table-simple :bordered="true" :outlined="false" :fixed="false" class="table_medium table_payslip">
      <b-thead>
        <b-th>
          {{ $t("views.employee.employee-code") }}
          <i class="btn_sort btn_sortcode icofont-sort-alt" @click="sort('emp_code')" />
        </b-th>
        <b-th>
          {{ $t("views.employee.employee-name") }}
          <i class="btn_sort btn_sortname icofont-sort-alt" @click="sort('full_name')" />
        </b-th>
        <b-th>{{ $t("views.employee.payslip") }}</b-th>
      </b-thead>
      <b-tbody>
        <b-tr
          v-for="(item, index) in PayslipList"
          :id="'row_'+item.emp_code"
          :key="index"
          :class="'sort_'+index"
        >
          <b-td>{{ item.emp_code }}</b-td>
          <b-td>{{ item.full_name }} </b-td>
          <b-td>
            <span class="btn_row" @click="goToPayslipScreen(item)">
              {{ $t("views.employee.display") }}
            </span>
          </b-td>
        </b-tr>
      </b-tbody>
    </b-table-simple>

    <!-- Pagination -->
    <div class="pagination">
      <b-pagination
        v-model="params.page"
        :per-page="params.per_page"
        :total-rows="totalRow"
        class="custom-pagination"
        :disabled="isLoading"
      >
        <template #first-text><span class="first">«</span></template>
        <template #prev-text><span class="prev">‹</span></template>
        <template #next-text><span class="next">›</span></template>
        <template #last-text><span class="last">»</span></template>
      </b-pagination>
    </div>
    <!-- End Pagination -->
  </main>
</template>

<script>
import { getAll, getListMonthPayslip } from '../../api/payslip';
import { MakeToast } from '../../utils/toast_message';
const paramInit = {
    page: 1,
    per_page: 20,
    month: '',
    sortby: 'id',
    sorttype: 1,
    emp_code: '',
    emp_name: '',
};
export default {
    name: 'PayslipIndex',
    data() {
        return {
            params: { ...paramInit },
            listMonth: {},
            PayslipList: [],
            icon: 'icofont-stylish-up',
            isFilterName: false,
            isFilterCode: false,
            isShowFilter: false,
            isLoading: false,
            totalRow: 0,
        };
    },
    computed: {
        isCurrentPageChange() {
            return this.params.page;
        },
        isChangeMonth() {
            return this.params.month;
        },
    },
    watch: {
        isCurrentPageChange() {
            this.getList();
        },
        isChangeMonth() {
            this.getList();
        },

    },
    beforeCreate(){
        if (!this.$store.state.user.auth.isManager){
            window.location.href = process.env.MIX_LARAVEL_PATH + 'payslip/detail';
        }
    },
    created() {
        this.handleGetListMonth();
    },

    methods: {
        sort(field) {
            this.params.sorttype = this.params.sortby === field ? !this.params.sorttype | 0 : 1;
            this.params.sortby = field;
            this.getList();
        },

        clearFilter() {
            const params = { ...paramInit };
            params.month = this.params.month;
            this.params = params;
            this.getList();
        },
        dropdownFilter() {
            this.isShowFilter = !this.isShowFilter;
            this.icon = this.isShowFilter ? 'icofont-stylish-down' : 'icofont-stylish-up';
        },
        async handleGetListMonth() {
            this.isLoading = true;
            await getListMonthPayslip().then((res) => {
                if (res.code === 200) {
                    this.listMonth = res.data.list_month;
                    this.params.month = res.data.current_month;
                }
            });
        },
        async getList() {
            this.isLoading = true;
            this.PayslipList = [];
            const params = JSON.parse(JSON.stringify(this.params));
            if (!this.isFilterName) {
                delete params.emp_name;
            }
            if (!this.isFilterCode) {
                delete params.emp_code;
            }
            await getAll(params)
                .then(response => {
                    if (response.code === 200) {
                        this.PayslipList = response.data.result;
                        this.totalRow = response.data.pagination.total_records;
                    } else {
                        MakeToast({
                            variant: 'warning',
                            title: this.$t('views.employee.warning'),
                            content: response.message,
                        });
                    }
                })
                .catch(error => {
                    MakeToast({
                        variant: 'danger',
                        title: this.$t('views.employee.danger'),
                        content: error.message,
                    });
                });
            this.isLoading = false;
        },
        goToPayslipScreen(item) {
            this.$router.push({
                path: `/payslip/detail/${item.emp_code}/${item.month}` },
            onAbort => {}
            );
        },
    },
};
</script>
