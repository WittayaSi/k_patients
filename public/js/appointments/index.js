new Vue({
    http: {
        root: '/root',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
        }
    },
    el: '#vueApp',
    data: {
        app_now: '',
        newApp: {
            id_no: '',
            hosp_ref: '',
            doctor: '',
            app_date: '',
            app_detail: '',
            app_other: '',
            userId: ''
        },
        codes: {
            c_hos_ref: hos_ref,
            c_doctor: doctor,
            c_patient: patient
        },
        appointments: {},
        ind_patient: '',
        modal_data: ''
    },

    created() {
        console.log(this.codes.c_hos_ref)
        console.log(this.codes.c_doctor)
        console.log(this.codes.c_patient)
    },
    methods: {
        getPatient(id_no) {
            this.fetchAppointment(id_no)
            this.$http.post('/api/getPatientByIdNo', id_no).then((res) => {
                var p_data = res.data.rawData
                this.ind_patient = p_data
                this.newApp.id_no = id_no
            })
        },
        addNewAppoint() {
            $('#modalAppointment_c').modal('hide')

            this.newApp.userId = this.$refs.user_id.value
            var newAppoint = this.newApp
            this.$http.post('/appointment', newAppoint).then((res) => {
                if (res.data.success === 'successfully') {
                    alert("An insert is Successfully")
                    var self = this
                    setTimeout(() => {
                        window.location.href = '/appointment'
                    }, 1000)
                } else {
                    $('#modalAppointment_c').modal('show')
                    alert("An insert is ERROR!!!!!!!!!!!!!!")
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
    }
})