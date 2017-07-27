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
        app_tomorrow: '',
        g_b_doctor_today: '',
        g_b_doctor_tomorrow: '',
        date_now: '',
        date_tomorrow: ''
    },

    created() {

        this.fechAllData()
            // this.lineNotify()
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

        fechAllData() {
            this.fetchData()
            this.fetchDataTomorrow()
            this.getGroupByDoctorToday()
            this.getGroupByDoctorTomorrow()
        },

        deleteAppoint(id) {
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
                            this.fechAllData()
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

        fetchData() {
            this.$http.get('/home/getNowAppoint').then((res) => {
                //console.log(res.data.rawData)
                //console.log(res.data.date_now)
                this.app_now = res.data.rawData
                this.date_now = res.data.date_now
            })
        },
        fetchDataTomorrow() {
            this.$http.get('/home/getTomorAppoint').then((res) => {
                //console.log(res.data.rawData)
                //console.log(res.data.date_now)
                this.app_tomorrow = res.data.rawData
                this.date_tomorrow = res.data.tomorrow
            })
        },
        getGroupByDoctorToday() {
            this.$http.get('/home/getGroupByDoctorToday').then((res) => {
                //console.log(res.data.rawData)
                //console.log(res.data.date_now)
                this.g_b_doctor_today = res.data.rawData
                this.date_now = res.data.date_now
                console.log(res.data.rawData)
            })
        },
        getGroupByDoctorTomorrow() {
            this.$http.get('/home/getGroupByDoctorTomorrow').then((res) => {
                //console.log(res.data.rawData)
                //console.log(res.data.date_now)
                this.g_b_doctor_tomorrow = res.data.rawData
                this.date_tomorrow = res.data.tomorrow
                    //console.log(res.data.rawData)
            })
        }

        // lineNotify() {
        //     this.$http.get('/home/lineNotify').then((res) => {
        //         console.log(res.data.rawData)
        //         console.log(res.data.date_tomorrow)
        //         console.log(res.data.app_no)
        //         console.log(res.data.message)
        //     })
        // }
    }
})