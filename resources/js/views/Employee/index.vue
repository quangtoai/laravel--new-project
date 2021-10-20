<template>
  <main id="veho_emplist">
    <h2 class="title">{{ $t("routes.employee") }}</h2>
    <div v-if="isLoading" class="loading"><i class="spinner-border" /></div>
    <!-- Main content -->
    <div v-if="isManager" class="filter-zone">
      <hr>
      <span class="btn_dropdown_filter" @click="dropdownFilter">
        <i :class="icon" />
        {{ $t('views.employee.filter') }}
      </span>
      <div v-show="isShowFilter" class="content">
        <span class="btn_clear" @click="clearFilter">{{ $t('views.employee.clear') }}</span>
        <div class="input_line"><!-- Employee Code Filter -->
          <b-form-checkbox v-model="isFilterCode" size="lg" class="checkbox_empcode" />
          <label class="label_search"> {{ $t('views.employee.employee-code') }}</label>
          <b-form-input
            v-model="params.emp_code"
            dusk="input_emp_code"
            class="input_short"
            type="number"
            :disabled="!isFilterCode"
            :placeholder="$t('views.employee.employee-code')"
            trim
          />
        </div>

        <!-- Employee Name input -->
        <div class="input_line">
          <b-form-checkbox v-model="isFilterName" size="lg" class="checkbox_empname" />
          <label class="label_search">{{ $t('views.employee.employee-name') }}</label>
          <b-form-input
            v-model="params.emp_name"
            dusk="input_emp_name"
            class="input_short"
            name="input_name"
            type="text"
            :disabled="!isFilterName"
            :placeholder="$t('views.employee.employee-name')"
            trim
          />
        </div>
        <b-button class="btn_apply" @click="getList()">{{ $t('views.employee.apply') }}</b-button>
        <hr>
      </div>
    </div>

    <b-table-simple responsive :items="items" :bordered="true" :outlined="false" :fixed="false" class="table-mb">
      <b-thead>
        <b-th>
          {{ $t("views.employee.employee-code") }}
          <i v-if="isManager" id="btn_sortcode" class="btn_sort icofont-sort-alt" @click="sort('emp_code')" />
        </b-th>
        <b-th>
          {{ $t("views.employee.employee-name") }}
          <i v-if="isManager" id="btn_sortname" class="btn_sort icofont-sort-alt" @click="sort('first_name')" />
        </b-th>
        <b-th>
          {{ $t("views.employee.mail-address") }}
          <i hidden class="btn_sort icofont-sort-alt" @click="sort('email')" />
        </b-th>
        <b-th v-if="isManager">
          {{ $t("views.employee.user-authority") }}
          <i id="btn_sort_authority" class="btn_sort icofont-sort-alt" @click="sort('role')" />
        </b-th>
        <b-th v-if="isManager">
          {{ $t("views.employee.retirement") }}
          <i id="btn_sort_retirement" class="btn_sort icofont-sort-alt" @click="sort('retirement_at')" />
        </b-th>
        <b-th> - </b-th>
      </b-thead>
      <b-tbody>
        <b-tr
          v-for="(employee, index) in EmployeeList"
          :id="'row_'+employee.emp_code"
          :key="index"
          :class="'sort_'+index"
        >
          <b-td>{{ employee.emp_code }}</b-td>
          <b-td>{{ employee.first_name + " " + employee.last_name }}</b-td>
          <b-td>{{ employee.email }}</b-td>
          <b-td v-if="isManager">{{ employee.role }}</b-td>
          <b-td v-if="isManager">
            <span v-if="employee.retirement_at === null" />
            <span v-else>🏴󠁧󠁢󠁳󠁣󠁴󠁿</span>
          </b-td>
          <b-td>
            <span class="btn_row" @click="goToChangeScreen(employee.emp_code)">
              {{ $t("views.employee.change") }}
            </span>
          </b-td>
        </b-tr>
      </b-tbody>
    </b-table-simple>

    <div v-if="isManager" class="pagination">
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
  </main>
</template>

<script>
import { getUser } from '../../api/employee';
// import { MakeToast } from '../../utils/toast_message';
const paramInit = {
    page: 1,
    per_page: 20,
    sortby: 'id',
    sorttype: 1,
    emp_code: '',
    emp_name: '',
};
export default {
    name: 'EmployeeIndex',
    data() {
        return {
            params: { ...paramInit },
            EmployeeList: [],
            isManager: this.$store.state.user.auth.isManager,
            emp_code: this.$store.state.user.auth.emp_code,
            icon: 'icofont-stylish-up',
            isFilterName: false,
            isFilterCode: false,
            isShowFilter: false,
            isLoading: false,
            totalRow: 0,
            items: [],
        };
    },
    computed: {
        isCurrentPageChange() {
            return this.params.page;
        },
    },
    watch: {
        isCurrentPageChange() {
            this.getList();
        },
    },

    mounted() {
        this.params.emp_code = this.$store.state.user.auth.isManager ? '' : this.$store.state.user.auth.emp_code;
        this.getList();
    },
    methods: {
        sort(field) {
            this.params.sorttype = this.params.sortby === field ? !this.params.sorttype | 0 : 1;
            this.params.sortby = field;
            this.getList();
        },

        clearFilter() {
            this.params = { ...paramInit };
            this.getList();
        },
        dropdownFilter() {
            this.isShowFilter = !this.isShowFilter;
            this.icon = this.isShowFilter ? 'icofont-stylish-down' : 'icofont-stylish-up';
        },
        async getList() {
            this.isLoading = true;
            this.EmployeeList = [];
            const params = this.params;
            if (!this.isFilterName) {
                delete params.name;
            }
            if (!this.isFilterCode) {
                delete params.code;
            }

            await getUser(params)
                .then((response) => {
                    if (response.code === 200) {
                        this.EmployeeList = this.$store.state.user.auth.role === 'MANAGER' ? response.data.result : [response.data];
                        if (this.isManager) {
                            this.totalRow = response.data.pagination.total_records;
                        }
                    }
                })
                .catch((err) => {
                    console.log(err);
                });

            this.isLoading = false;
        },
        goToChangeScreen(emp_code) {
            this.$router.push({ path: `/employee/edit/${emp_code}` }, onAbort => {});
        },
    },
};
</script>
