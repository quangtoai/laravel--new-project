<template>
  <main id="veho_payslipimport">
    <h2 class="title">{{ $t("routes.csv-import") }}</h2>
    <div class="import-zone">
      <section class="header">
        <span id="header-text">{{ $t('views.import-csv.csv-data') }}</span>
      </section>
      <section class="content">
        <div class="input_line">
          <label>{{ $t('views.import-csv.choose-month') }}</label>
          <b-form-select v-model="selectMonth" class="select_month">
            <b-form-select-option v-for="(v, k) in listMonth" :key="k" :value="k">
              {{ (v) }}
            </b-form-select-option>
          </b-form-select>
        </div>
        <div v-if="showFileName" class="input_line">
          <label>{{ $t('views.import-csv.file-name') }}: </label>
          <span style="color: red;">{{ fileName }}</span>
        </div>
        <div class="input_line">
          <label>{{ $t('views.import-csv.import-data') }}:</label>
          <input id="get_file" type="button" :value="$t('views.import-csv.select-files')" :disabled="isDiableSubmit" @click="openFileInput()">
          <input
            id="my_file"
            ref="inputCSV"
            name="file_csv"
            class="hide"
            type="file"
            accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
            @change="changeFile()"
          >
        </div>
        <div v-if="isCall" class="api_report">
          <span class="close" @click="isCall=false; showFileName=false">X</span>
          <div>{{ $t('views.import-csv.total-success') }}: <strong class="success">{{ report.numberSuccess }}</strong></div>
          <div>{{ $t('views.import-csv.total-fail') }}: <strong class="danger">{{ report.numberFail }}</strong></div>
          <!-- <div class="errors">{{ $t('views.import-csv.errors') }}: <p v-for="(mess, k) in report.errors" :key="k">{{ mess }}</p></div> -->
        </div>
      </section>
    </div>
    <div class="form_action text-center">
      <button class="btn btn_blue btn_submit import_csv" :disabled="isDiableSubmit" @click="handleSendFile()">
        <b-icon v-if="isDiableSubmit" icon="arrow-clockwise" font-scale="1" animation="spin" /> {{ $t('views.import-csv.import') }}
      </button>
    </div>
  </main>
</template>

<script>
import { vToast } from '../../utils/toast_message';
import { getListMonthPayslip, postPayslipCSV } from '../../api/payslip';

export default {
    name: 'PayslipImport',
    data() {
        return {
            fileName: '',
            isValidate: false,
            isDiableSubmit: false,
            selectMonth: null,
            listMonth: [],
            showFileName: false,
            isCall: false,
            report: {
                numberSuccess: 0,
                numberFail: 0,
                errors: [],
            },
        };
    },
    created() {
        if (!this.$store.state.user.auth.isManager){
            window.location.href = process.env.MIX_LARAVEL_PATH + 'payslip/detail';
        }
        this.handleGetListMonth();
    },
    methods: {
        async handleGetListMonth(){
            const param = { 'is_full': 1 };
            await getListMonthPayslip(param).then((res) => {
                if (res.code === 200) {
                    this.listMonth = res.data.list_month;
                    this.selectMonth = res.data.current_month;
                }
            });
        },
        changeFile() {
            this.showFileName = true;
            this.fileName = document.getElementById('my_file').files[0].name;
        },
        openFileInput() {
            this.$refs.inputCSV.click();
        },
        async handleSendFile() {
            const EL = document.getElementById('my_file');
            const FILE = EL.files[0];
            let err = '';
            if (!FILE) {
                err = 'views.import-csv.toast.warning.validate-file-exit';
            } else if (!this.isValidateTypeFile(FILE) || !this.isValidateSizeFile(FILE)) {
                err = 'views.import-csv.toast.warning.validate-size';
            } else if (!this.selectMonth) {
                err = 'views.import-csv.toast.warning.validate-choose-month';
            }
            if (err){
                vToast(err);
                return;
            }

            this.isDiableSubmit = true;
            var DATA = new FormData();
            DATA.append('file', FILE);
            DATA.append('month', this.selectMonth);

            await postPayslipCSV(DATA)
                .then((res) => {
                    if (res.code === 200){
                        this.isCall = true;
                        this.report = res.data;
                        vToast('views.import-csv.toast.success.content', 1);
                    } else {
                        vToast(res.message);
                    }
                })
                .catch(() => {
                    vToast('views.import-csv.toast.danger.content');
                });
            this.isDiableSubmit = false;
        },
        isValidateTypeFile(file) {
            if (!(/\.(xls|xlsx|csv)$/.test(file.name.toLowerCase()))) {
                return false;
            }
            return true;
        },
        isValidateSizeFile(file) {
            const SIZE = (file.size / (1024 * 1024)).toFixed(2);
            if (SIZE > 5) {
                return false;
            }
            return true;
        },
    },
};
</script>
