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

            img_file: '',
            userId: ''
        },

        updatePatient: {
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

            img_file: '',
            userId: ''
        },

        editPatient: {
            hospcodeE: '',
            idNoE: '',
        },
        newApp: {
            id_no: '',
            hosp_ref: '',
            doctor: '',
            app_date: '',
            app_detail: '',
            app_other: '',
            userId: ''
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
        ind_patient: '',
        img_data: {
            id_no: '',
            img_patient: ''
        },
        uploadSuccess: false,
        buttonCall: 'create'
    },

    created() {
        this.newPatient.hn = hn_str
        console.log(this.newPatient.hn)
        console.log(this.buttonCall)
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
        onImageChange(e) {
            console.log('onImageChange')
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0]);
        },
        createImage(file) {
            var image = new Image();
            var reader = new FileReader();
            var vm = this;

            reader.onload = (e) => {
                vm.img_data.img_patient = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        removeImage: function(e) {
            this.img_data.id_no = ''
            this.img_data.img_patient = ''
            this.uploadSuccess = false
        },

        clearImage() {
            this.img_data.id_no = ''
            this.img_data.img_patient = ''
            this.uploadSuccess = false
        },

        saveImage(idNo) {
            this.img_data.id_no = idNo
                //console.log(this.img_data.id_no)
                //console.log(this.img_data.img_patient)
            this.$http.post('/api/saveImage', this.img_data).then((res) => {

                console.log(res.data)
                if (res.data == 1) {
                    console.log('complete save !!!!!!')
                    this.uploadSuccess = true
                    this.fetchData(this.pagination.current_page)
                    $('#modalViewPatient').modal('hide')
                } else {
                    console.log('save is error !!!!!!')
                }
            })
        },

        addNewPatient() {

            $('#modalAddPatient').modal('hide')

            this.newPatient.userId = this.$refs.user_id_add.value
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

        updatePatientF() {
            console.log('5555555555555555')
            $('#modalUpdatePatient').modal('hide')

            console.log(this.$refs.user_id_add[0].value)
            console.log(this.$refs.hospcodeE[0].value)
            var pId = this.$refs.patient_id[0].value
            this.updatePatient.userId = this.$refs.user_id_add[0].value
            this.updatePatient.hospcode = this.$refs.hospcodeE[0].value
            this.updatePatient.idNo = this.$refs.idNoE[0].value
            this.updatePatient.hn = this.$refs.hnE[0].value
            this.updatePatient.first_sick = this.$refs.first_sickE[0].value
            this.updatePatient.recieve_date = this.$refs.recieve_dateE[0].value
            this.updatePatient.preName = this.$refs.preNameE[0].value
            this.updatePatient.fName = this.$refs.fNameE[0].value
            this.updatePatient.lName = this.$refs.lNameE[0].value
            this.updatePatient.dob = this.$refs.dobE[0].value
            this.updatePatient.sex = this.$refs.sexE[0].value
            this.updatePatient.race = this.$refs.raceE[0].value
            this.updatePatient.nation = this.$refs.nationE[0].value
            this.updatePatient.mStatus = this.$refs.mStatusE[0].value
            this.updatePatient.education = this.$refs.educationE[0].value
            this.updatePatient.occupation = this.$refs.occupationE[0].value
            this.updatePatient.religion = this.$refs.religionE[0].value

            // address 
            this.updatePatient.address_no = this.$refs.address_noE[0].value
            this.updatePatient.moo = this.$refs.mooE[0].value
            this.updatePatient.village = this.$refs.villageE[0].value
            this.updatePatient.tambon = this.$refs.tambonE[0].value
            this.updatePatient.ampur = this.$refs.ampurE[0].value
            this.updatePatient.changwat = this.$refs.changwatE[0].value

            console.log(this.updatePatient)
            this.$http.put('/patient/' + pId, this.updatePatient).then((res) => {
                console.log(res.data)
                if (res.data.success === 'successfully') {
                    console.log("An Update is Successfully")
                    this.clearData(res.data.rawData)
                    var self = this
                    self.statusBar = true
                    setTimeout(() => {
                        this.fetchData(this.pagination.current_page)
                        self.statusBar = false
                    }, 1500)
                } else {
                    $('#modalUpdatePatient').modal('show')
                    console.log("An Update is ERROR!!!!!!!!!!!!!!")
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
            this.pagination.current_page = page
            this.fetchData(page)
        },

        getPatient(event, id_no) {

            this.fetchAppointment(id_no)

            this.$http.post('/api/getPatientByIdNo', id_no).then((res) => {
                var p_data = res.data.rawData
                console.log(p_data)
                this.ind_patient = p_data
                this.newApp.id_no = id_no
                console.log(this.ind_patient[0].prename)
                if (this.ind_patient[0].prename === '001' || this.ind_patient[0].prename === '003') {
                    this.updatePatient.sex = 1
                    this.txtSex = 'ชาย'
                } else {
                    this.updatePatient.sex = 2
                    this.txtSex = 'หญิง'
                }
            })
            if (event.currentTarget.id == 'pEdit') {
                this.buttonCall = 'edit'
                console.log(this.buttonCall)
            }
        },

        addNewAppoint() {
            $('#modalAppointment').modal('hide')
            this.newApp.userId = this.$refs.user_id.value
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

        deleteAppoint(id, id_no) {
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
                        self.$http.delete("/appointment/" + id).then((res) => {
                            console.log('Record Delete Successfully')
                            this.fetchAppointment(id_no)
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

        changeGender(v) {
            if (v === 'c') {
                if (this.newPatient.preName === '001' || this.newPatient.preName === '003') {
                    this.newPatient.sex = 1
                    this.txtSex = 'ชาย'
                } else {
                    this.newPatient.sex = 2
                    this.txtSex = 'หญิง'
                }
            } else {
                var pn = this.$refs.preNameE[0].value
                if (pn === '001' || pn === '003') {
                    this.updatePatient.sex = 1
                    this.txtSex = 'ชาย'
                } else {
                    this.updatePatient.sex = 2
                    this.txtSex = 'หญิง'
                }
            }
        },
    }
})