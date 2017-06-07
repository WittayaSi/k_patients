var vueSpace = new Vue({
    http: {
        root: '/root',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
        }
    },
    el: '#vueApp',
    data: {
        pagination: {
            total: 0,
            per_page: 2,
            from: 1,
            to: 0,
            current_page: 1
        },
        offset: 4,
        newPatient: {
            hospcode: '',
            idNo: '',
            hn: '',
            first_sick: '',
            recieve_date: '',
            preName: '',
            fName: '',
            lName: '',
            dob: '',
            sex: '',
            race: '',
            nation: '',
            mStatus: '',
            education: '',
            occupation: '',
            religion: '',

            // address 
            address_no: '',
            moo: '',
            village: '',
            tambon: '',
            ampur: '',
            changwat: '',

            img_file: ''
        },
        newApp: {
            id_no: '',
            hosp_ref: '',
            doctor: '',
            app_date: '',
            app_detail: '',
            app_other: ''
        },
        appointments: {},

        codes: {
            disease: disease,
            preName: prename,
            nation: nation,
            mStatus: mstatus,
            education: education,
            occupation: occupation,
            religion: religion,
            tambon: tambon,
            hos_ref: hos_ref,
            c_doctor: doctor,
        },

        //for search 
        persons: 0,
        hoscode: '',
        txtName: '',
        txtLastName: '',
        fullName: {
            'fName': '',
            'lName': ''
        },

        option: 'b',
        hospital: hospital,
        txtSex: 'เพศ',
        statusBar: false,
        patients: [],
        ind_patient: ''
    },

    created() {
        this.newPatient.hn = hn_str
        this.fetchData(this.pagination.current_page)
    },

    computed: {
        isActived: function() {
            return this.pagination.current_page;
        },
        pagesNumber: function() {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
    },

    filters: {
        showStringDisease(data) {
            if (data.length > 42) {
                return data.substr(0, 42) + "..."
            } else {
                return data
            }
        },
        calAges(b) {
            var ages = moment().diff(moment(b, 'YYYYMMDD'), 'years')
            return ages
        },
        getDate(date) {
            const d = new Date(date)
            const m = [
                'มกราคม',
                'กุมภาพันธ์',
                'มีนาคม',
                'เมษายน',
                'พฤษภาคม',
                'มิถุนายน',
                'กรกฎาคม',
                'สิงหาคม',
                'กันยายน',
                'ตุลาคม',
                'พฤศจิกายน',
                'ธันวาคม'
            ]
            const month = m[(d.getMonth())]
            return `${d.getDate() < 10
            ? '0' + d.getDate()
            : d.getDate()} ${month} ${d.getFullYear()+543}`
        }
    },

    methods: {
        addNewPatient() {

            $('#modalAddPatient').modal('hide')

            var patient = this.newPatient
            console.log(patient)
            this.$http.post('/patient', patient).then((res) => {
                console.log(res.data)
                if (res.data.success === 'successfully') {
                    console.log("An insert is Successfully")
                    this.clearData(res.data.rawData)
                    var self = this
                    self.statusBar = true
                    setTimeout(() => {
                        this.fetchData(this.pagination.current_page)
                        self.statusBar = false
                    }, 1500)
                } else {
                    $('#modalAddPatient').modal('show')
                    console.log("An insert is ERROR!!!!!!!!!!!!!!")
                }
            }, (error) => {
                console.log(error)
            })
        },

        fetchData(page) {
            this.$http.get('/api/getAllPatient?page=' + page).then((res) => {
                this.patients = res.data.rawData.data
                this.pagination = res.data.pagination
            })
        },

        clearData(hn) {
            this.newPatient.hospcode = ''
            this.newPatient.idNo = ''
            this.newPatient.hn = hn
            this.newPatient.first_sick = ''
            this.newPatient.recieve_date = ''
            this.newPatient.preName = ''
            this.newPatient.fName = ''
            this.newPatient.lName = ''
            this.newPatient.dob = ''
            this.newPatient.sex = ''
            this.newPatient.race = ''
            this.newPatient.nation = ''
            this.newPatient.mStatus = ''
            this.newPatient.education = ''
            this.newPatient.occupation = ''
            this.newPatient.religion = ''

            // address 
            this.newPatient.address_no = ''
            this.newPatient.moo = ''
            this.newPatient.village = ''
            this.newPatient.tambon = ''
            this.newPatient.ampur = ''
            this.newPatient.changwat = ''

            this.txtSex = 'เพศ'
        },

        changePage(page) {
            this.pagination.current_page = page;
            this.fetchData(page);
        },

        getPatient(id_no) {
            this.fetchAppointment(id_no)
            this.$http.post('/api/getPatientByIdNo', id_no).then((res) => {
                var p_data = res.data.rawData
                this.ind_patient = p_data
                this.newApp.id_no = id_no
            })
        },

        addNewAppoint() {
            $('#modalAppointment').modal('hide')
            var newAppoint = this.newApp
            this.$http.post('/appointment', newAppoint).then((res) => {
                console.log()
                if (res.data.success === 'successfully') {
                    console.log("An insert is Successfully")
                    this.clearAppointment(this.newApp.id_no)
                    var self = this
                    setTimeout(() => {
                        this.fetchAppointment(this.newApp.id_no)
                    }, 1500)
                } else {
                    $('#modalAppointment').modal('show')
                    console.log("An insert is ERROR!!!!!!!!!!!!!!")
                }
            }, (error) => {
                console.log(error)
            })

        },
        fetchAppointment(id) {
            console.log(id)
            this.$http.post('/api/getAppointment', id).then((res) => {
                console.log(res.data.rawData)
                this.appointments = res.data.rawData
            })
        },
        clearAppointment(id) {
            console.log(id)
            this.newApp.id_no = id
            this.newApp.hosp_ref = ''
            this.newApp.doctor = ''
            this.newApp.app_date = ''
            this.newApp.app_detail = ''
            this.newApp.app_other = ''
        },

        getPatientByHosId() {
            console.log(this.hoscode)
            this.$http.post("/api/getPatientByHosId", this.hoscode).then((res) => {
                this.patients = res.data.rawData.data
                this.pagination = res.data.pagination
            })
        },
        getPatientByName(txtName) {
            this.fullName.fName = txtName.target.value
            console.log(this.fullName.fName)
            this.$http.post("/api/getPatientByFullName", this.fullName).then((res) => {
                this.patients = res.data.rawData.data
                this.pagination = res.data.pagination
            })
        },
        getPatientByLastName(txtLastName) {
            this.fullName.lName = txtLastName.target.value
            console.log(this.fullName.lName)
            this.$http.post("/api/getPatientByFullName", this.fullName).then((res) => {
                this.patients = res.data.rawData.data
                this.pagination = res.data.pagination
            })
        },

        deletePatient(id) {
            console.log(id)
            var self = this
            swal({
                    title: 'คุณแน่ใจว่าต้องการลบ ?',
                    text: "ไม่ต้องการลบกด ยกเลิก !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน !',
                    cancelButtonText: 'ยกเลิก',
                    closeOnConfirm: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        self.$http.delete("/patient/" + id).then((res) => {
                            console.log('Record Delete Successfully')
                            this.fetchData(this.pagination.current_page)
                        })
                        swal(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        );
                        return true;
                    } else {
                        return false;
                    }
                }.bind(self))
        },
        changeGender() {
            if (this.newPatient.preName === '001' || this.newPatient.preName === '003') {
                this.newPatient.sex = 1
                this.txtSex = 'ชาย'
            } else {
                this.newPatient.sex = 2
                this.txtSex = 'หญิง'
            }
        },
    }
})