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
            app_other: ''
        },
        codes: {
            c_hos_ref: hos_ref,
            c_doctor: doctor,
            c_patient: patient
        },
    },

    created() {
        console.log(this.codes.c_hos_ref)
        console.log(this.codes.c_doctor)
        console.log(this.codes.c_patient)
    },
    methods: {
        addNewAppoint() {
            $('#modalAppointment').modal('hide')
            var newAppoint = this.newApp
            this.$http.post('/appointment', newAppoint).then((res) => {
                if (res.data.success === 'successfully') {
                    alert("An insert is Successfully")
                    var self = this
                    setTimeout(() => {
                        window.location.href = '/appointment'
                    }, 1000)
                } else {
                    $('#modalAppointment').modal('show')
                    alert("An insert is ERROR!!!!!!!!!!!!!!")
                }
            }, (error) => {
                console.log(error)
            })

        },
    }
})